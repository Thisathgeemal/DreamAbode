<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\BuyerMail;
use App\Mail\PropertyOwnerMail;
use App\Models\Image;
use App\Models\Payment;
use App\Models\PropertyAd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PropertyAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userProperties  = $this->getUserProperties();
        $allProperties   = $this->getAllProperties();
        $agentProperties = $this->getAgentProperties();

        return response()->json([
            'user_properties'  => $userProperties,
            'all_properties'   => $allProperties,
            'agent_properties' => $agentProperties,
        ]);
    }

    /**
     * Get properties of logged-in user
     */
    private function getUserProperties()
    {
        $userId = Auth::id();

        return [
            'pending'   => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'pending')->get(),
            'approved'  => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'approve')->get(),
            'rejected'  => PropertyAd::with('images')->where('member_id', $userId)->where('status', 'reject')->get(),
            'completed' => PropertyAd::with('images')
                ->where('status', 'complete')
                ->where(function ($query) use ($userId) {
                    $query->where('member_id', $userId)
                        ->orWhere('buyer_id', $userId);
                })
                ->get(),
        ];
    }

    /**
     * Get all properties by status
     */
    private function getAllProperties()
    {
        return [
            'pending'   => PropertyAd::with('images')->where('status', 'pending')->get(),
            'approved'  => PropertyAd::with(['images', 'agent'])->where('status', 'approve')->get(),
            'rejected'  => PropertyAd::with('images')->where('status', 'reject')->get(),
            'completed' => PropertyAd::with('images')->where('status', 'complete')->get(),
        ];
    }

    /**
     * Get properties of the logged-in agent
     */
    private function getAgentProperties()
    {
        $agentId = Auth::id();

        return [
            'approved'  => PropertyAd::with('images')
                ->where('agent_id', $agentId)
                ->where('status', 'approve')
                ->get(),

            'completed' => PropertyAd::with('images')
                ->where('agent_id', $agentId)
                ->where('status', 'complete')
                ->get(),
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
            'measurement'   => 'nullable|numeric|min:0',
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
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = PropertyAd::with('images')->findOrFail($id);

        return response()->json([
            'property' => $property,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            DB::beginTransaction();
            $property = PropertyAd::findOrFail($id);

            $request->validate([
                'propertyName'  => 'required|string|max:255',
                'propertyType'  => 'required|string',
                'location'      => 'required|string|max:255',
                'price'         => 'required|numeric|min:0',
                'postType'      => 'required|string|in:Sale,Rent',

                'bedroomCount'  => 'nullable|integer|min:0',
                'bathroomCount' => 'nullable|integer|min:0',
                'floorCount'    => 'nullable|integer|min:0',
                'measurement'   => 'nullable|numeric|min:0',
                'perches'       => 'nullable|numeric|min:0',

                'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $property->update([
                'property_name' => $request->propertyName,
                'price'         => $request->price,
                'post_type'     => $request->postType,
                'location'      => $request->location,
                'property_type' => $request->propertyType,
                'bedrooms'      => $request->bedroomCount,
                'bathrooms'     => $request->bathroomCount,
                'floors'        => $request->floorCount,
                'perches'       => $request->perches,
                'measurement'   => $request->measurement,
            ]);

            if ($request->hasFile('images')) {
                foreach ($property->images as $img) {
                    Storage::delete($img->image_path);
                    $img->delete();
                }

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
                'success'  => 'Property updated successfully',
                'property' => $property->load('images'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to update property: ' . $e->getMessage(),
            ], 500);
        }
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

    /**
     * Accept property
     */
    public function accept(PropertyAd $property)
    {
        try {
            DB::transaction(function () use ($property) {
                $property->status   = 'approve';
                $property->admin_id = auth()->user()->id;
                $property->save();

                $this->assignAgentWithLeastProperties($property);
            });

            return response()->json(['success' => 'Property approved and assigned successfully.']);
        } catch (\Exception $e) {
            \Log::error('Accept Property Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to Accept property: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reject property
     */
    public function reject(PropertyAd $property)
    {
        try {
            DB::transaction(function () use ($property) {
                $property->status   = 'reject';
                $property->admin_id = auth()->user()->id;
                $property->save();
            });

            return response()->json([
                'success' => 'Property rejected successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Reject Property Error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to reject property: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Assign agent with least properties
     */
    private function assignAgentWithLeastProperties(PropertyAd $property)
    {
        try {
            DB::transaction(function () use ($property) {
                $agent = User::whereJsonContains('user_roles', 'agent')
                    ->withCount('propertyAgents')
                    ->orderBy('property_agents_count', 'asc')
                    ->first();

                if ($agent) {
                    $property->agent_id = $agent->id;
                    $property->save();
                }
            });
        } catch (\Exception $e) {
            \Log::error('Failed to assign agent: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Store payment record
     */
    public function payment(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:property_ads,property_id',
            'amount'      => 'required|numeric|min:1',
        ]);

        try {
            $userId   = auth()->id();
            $property = PropertyAd::findOrFail($request->property_id);

            // Default values
            $title       = '';
            $description = '';

            if ($property->post_type === 'sale') {
                $title       = "Buy Property";
                $description = "Buying property '{$property->property_name}' and 2% of total price paid as down payment.";
            } elseif ($property->post_type === 'rent') {
                $title       = "Rent Property";
                $description = "Renting property '{$property->property_name}' and one month amount of total price paid as down payment.";
            }

            // Save payment
            $payment = Payment::create([
                'member_id'   => $userId,
                'property_id' => $property->property_id,
                'amount'      => $request->amount,
                'title'       => $title,
                'description' => $description,
            ]);

            $property->status   = 'complete';
            $property->buyer_id = $userId;
            $property->save();

            $buyer  = User::findOrFail($property->buyer_id);
            $member = User::findOrFail($property->member_id);
            $agent  = User::findOrFail($property->agent_id);

            // Send email to Buyer (with Member details)
            Mail::to($buyer->email)->send(new BuyerMail($buyer, $member, $agent, $property));

            // Send email to Member (with Buyer details)
            Mail::to($member->email)->send(new PropertyOwnerMail($buyer, $member, $agent, $property));

            return response()->json([
                'success' => 'Payment successful and property status updated.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
