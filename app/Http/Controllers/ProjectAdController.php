<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ProjectAd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userProjects = $this->getUserProjects();
        $allProjects  = $this->getAllProjects();

        return response()->json([
            'user_projects' => $userProjects,
            'all_projects'  => $allProjects,
        ]);
    }

    /**
     * Get projects of logged-in user
     */
    private function getUserProjects()
    {
        $userId = Auth::id();

        return [
            'pending'   => ProjectAd::with('images')->where('member_id', $userId)->where('status', 'pending')->get(),
            'approved'  => ProjectAd::with('images')->where('member_id', $userId)->where('status', 'approve')->get(),
            'rejected'  => ProjectAd::with('images')->where('member_id', $userId)->where('status', 'reject')->get(),
            'completed' => ProjectAd::with('images')
                ->where('status', 'complete')
                ->where(function ($query) use ($userId) {
                    $query->where('member_id', $userId)
                        ->orWhereJsonContains('buyer_ids', $userId);
                })
                ->get(),
        ];
    }

    /**
     * Get all projects by status
     */
    private function getAllProjects()
    {
        return [
            'pending'   => ProjectAd::with('images')->where('status', 'pending')->get(),
            'approved'  => ProjectAd::with(['images', 'agent'])->where('status', 'approve')->get(),
            'rejected'  => ProjectAd::with('images')->where('status', 'reject')->get(),
            'completed' => ProjectAd::with('images')->where('status', 'complete')->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'projectName'    => 'required|string|max:255',
            'propertyType'   => 'required|in:apartment,commercial',
            'location'       => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'totalUnits'     => 'required|integer|min:1',
            'bedrooms'       => 'nullable|integer|min:0',
            'bathrooms'      => 'nullable|integer|min:0',
            'parkingSpaces'  => 'nullable|integer|min:0',
            'measurement'    => 'required|numeric|min:0',
            'projectStatus'  => 'required|in:upcoming,ongoing,completed',
            'completionDate' => 'nullable|date',
            'images'         => 'required',
            'images.*'       => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $project = ProjectAd::create([
                'member_id'       => Auth::id(),
                'project_name'    => $validated['projectName'],
                'property_type'   => $validated['propertyType'],
                'location'        => $validated['location'],
                'price'           => $validated['price'],
                'total_units'     => $validated['totalUnits'],
                'bedrooms'        => $validated['bedrooms'] ?? null,
                'bathrooms'       => $validated['bathrooms'] ?? null,
                'parking_spaces'  => $validated['parkingSpaces'] ?? null,
                'measurement'     => $validated['measurement'],
                'project_status'  => $validated['projectStatus'],
                'completion_date' => $validated['completionDate'] ?? null,
                'status'          => 'pending',
            ]);

            // Save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('project_images', 'public');

                    Image::create([
                        'project_id' => $project->project_id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success'      => 'Project ad created successfully and awaiting approval.',
                'project'      => $project,
                'redirect_url' => route('member.project.pending'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create project ad: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = ProjectAd::with('images')->findOrFail($id);

        return response()->json([
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $project = ProjectAd::findOrFail($id);

            $validated = $request->validate([
                'projectName'    => 'required|string|max:255',
                'propertyType'   => 'required|in:apartment,commercial',
                'location'       => 'required|string|max:255',
                'price'          => 'required|numeric|min:0',
                'totalUnits'     => 'required|integer|min:0',
                'bedrooms'       => 'nullable|integer|min:0',
                'bathrooms'      => 'nullable|integer|min:0',
                'parkingSpaces'  => 'nullable|integer|min:0',
                'measurement'    => 'required|numeric|min:0',
                'completionDate' => 'nullable|date',
                'projectStatus'  => 'required|string|max:255',
                'images'         => 'nullable',
                'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $project->update([
                'project_name'    => $validated['projectName'],
                'property_type'   => $validated['propertyType'],
                'location'        => $validated['location'],
                'price'           => $validated['price'],
                'total_units'     => $validated['totalUnits'],
                'bedrooms'        => $validated['bedrooms'] ?? null,
                'bathrooms'       => $validated['bathrooms'] ?? null,
                'parking_spaces'  => $validated['parkingSpaces'] ?? null,
                'measurement'     => $validated['measurement'],
                'completion_date' => $validated['completionDate'] ?? null,
                'project_status'  => $validated['projectStatus'],
            ]);

            // Only update images if new images are uploaded
            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($project->images as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
                // Save new images
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('project_images', 'public');
                    Image::create([
                        'project_id' => $project->project_id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success'      => 'Project updated successfully',
                'project'      => $project->load('images'),
                'redirect_url' => route('member.project.pending'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update project: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = ProjectAd::findOrFail($id);
            $images  = Image::where('project_id', $project->project_id)->get();

            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            $project->delete();

            return response()->json([
                'success' => 'Project and related images deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete project: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Accept project
     */
    public function accept(ProjectAd $project)
    {
        try {
            DB::transaction(function () use ($project) {
                $project->status   = 'approve';
                $project->admin_id = auth()->user()->id;
                $project->save();

                $this->assignAgentWithLeastProjects($project);
            });

            return response()->json(['success' => 'Project approved successfully.']);
        } catch (\Exception $e) {
            \Log::error('Accept Project Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to accept project: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reject project
     */
    public function reject(ProjectAd $project)
    {
        try {
            DB::transaction(function () use ($project) {
                $project->status   = 'reject';
                $project->admin_id = auth()->user()->id;
                $project->save();
            });

            return response()->json([
                'success' => 'Project rejected successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Reject Project Error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to reject project: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Assign agent with least projects
     */
    private function assignAgentWithLeastProjects(ProjectAd $project)
    {
        try {
            DB::transaction(function () use ($project) {
                $agent = User::whereJsonContains('user_roles', 'agent')
                    ->withCount('projectAgents')
                    ->orderBy('project_agents_count', 'asc')
                    ->first();

                if ($agent) {
                    $project->agent_id = $agent->id;
                    $project->save();
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

}
