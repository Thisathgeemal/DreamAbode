<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\PropertyAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropertyAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userProperties = $this->getUserProperties();
        $allProperties  = $this->getAllProperties();

        return response()->json([
            'user_properties' => $userProperties,
            'all_properties'  => $allProperties,
        ]);
    }

    /**
     * Get properties of logged-in user
     */
    private function getUserProperties()
    {
        $userId = Auth::id();

        return [
            'pending'  => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'pending')->get(),
            'approved' => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'approve')->get(),
            'rejected' => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'reject')->get(),
        ];
    }

    /**
     * Get all properties by status
     */
    private function getAllProperties()
    {
        return [
            'pending'  => PropertyAd::with('images')->where('status', 'pending')->get(),
            'approved' => PropertyAd::with('images')->where('status', 'approve')->get(),
            'rejected' => PropertyAd::with('images')->where('status', 'reject')->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'propertyName'  => 'required|string|max:255',
            'propertyType'  => 'required|string',
            'location'      => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'postType'      => 'required|string|in:Sale,Rent',

            'bedroomCount'  => 'nullable|integer|min:0',
            'bathroomCount' => 'nullable|integer|min:0',
            'floorCount'    => 'nullable|integer|min:0',
            'measurement'   => 'nullable|numeric|max:255',
            'perches'       => 'nullable|numeric|min:0',

            'images'        => 'required',
            'images.*'      => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $property = PropertyAd::create([
                'member_id'     => Auth::id(),
                'property_name' => $validated['propertyName'],
                'property_type' => $validated['propertyType'],
                'location'      => $validated['location'],
                'measurement'   => $validated['measurement'] ?? null,
                'perches'       => $validated['perches'] ?? null,
                'bedrooms'      => $validated['bedroomCount'] ?? null,
                'bathrooms'     => $validated['bathroomCount'] ?? null,
                'floors'        => $validated['floorCount'] ?? null,
                'price'         => $validated['price'],
                'post_type'     => $validated['postType'],
                'status'        => 'pending',
            ]);

            // Save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('property_images', 'public');

                    Image::create([
                        'property_id' => $property->property_id,
                        'image_path'  => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success'      => 'Property ad created successfully and awaiting approval.',
                'property'     => $property,
                'redirect_url' => route('member.property.pending'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create property ad: ' . $e->getMessage(),
            ], 500);
            dd(Auth::id());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $property = PropertyAd::findOrFail($id);
            $images   = Image::where('property_id', $property->property_id)->get();

            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            $property->delete();

            return response()->json([
                'success' => 'Property and related images deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete property: ' . $e->getMessage(),
            ], 500);
        }
    }

}
