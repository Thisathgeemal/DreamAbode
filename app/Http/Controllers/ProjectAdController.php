<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\BuyerProjectMail;
use App\Mail\ProjectOwnerMail;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\ProjectAd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userProjects  = $this->getUserProjects();
        $allProjects   = $this->getAllProjects();
        $agentProjects = $this->getAgentProjects();

        return response()->json([
            'user_projects'  => $userProjects,
            'all_projects'   => $allProjects,
            'agent_projects' => $agentProjects,
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
                ->where(function ($query) use ($userId) {
                    $query->where(function ($q) use ($userId) {
                        $q->where('status', 'complete')
                            ->where('member_id', $userId);
                    })
                        ->orWhere(function ($q) use ($userId) {
                            $q->where('status', 'approve')
                                ->whereJsonContains('buyer_ids', $userId);
                        });
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
            'completed' => ProjectAd::with('images')
                ->where(function ($query) {
                    $query->where('status', 'complete')
                        ->orWhere(function ($q) {
                            $q->where('status', 'approve')
                                ->whereJsonLength('buyer_ids', '>', 0);
                        });
                })
                ->get(),
        ];
    }

    /**
     * Get projects of logged-in agent
     */
    private function getAgentProjects()
    {
        $agentId = Auth::id();

        return [
            'approved'  => ProjectAd::with('images')
                ->where('agent_id', $agentId)
                ->where('status', 'approve')
                ->get(),

            'completed' => ProjectAd::with('images')
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
                'available_units' => $validated['totalUnits'],
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

            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Project Created',
                'message' => 'Your project "' . $project->project_name . '" has been created successfully and is pending approval.',
                'type'    => 'project',
                'is_read' => false,
            ]);

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

            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Project Updated',
                'message' => 'Your project "' . $project->project_name . '" has been updated successfully.',
                'type'    => 'project',
                'is_read' => false,
            ]);

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

            Notification::create([
                'user_id' => $project->member_id,
                'title'   => 'Project Deleted',
                'message' => 'Your project "' . $project->project_name . '" has been deleted successfully.',
                'type'    => 'project',
                'is_read' => false,
            ]);

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

            Notification::create([
                'user_id' => $project->member_id,
                'title'   => 'Project Accepted',
                'message' => 'Your project "' . $project->project_name . '" has been accepted and is now live.',
                'type'    => 'project',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $project->agent_id,
                'title'   => 'New Project Assigned',
                'message' => 'You have been assigned to manage the project "' . $project->project_name . '".',
                'type'    => 'project',
                'is_read' => false,
            ]);

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

            Notification::create([
                'user_id' => $project->member_id,
                'title'   => 'Project Rejected',
                'message' => 'Your project "' . $project->project_name . '" has been rejected. Please review and resubmit.',
                'type'    => 'project',
                'is_read' => false,
            ]);

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
    public function Payment(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:project_ads,project_id',
            'amount'      => 'required|numeric|min:1',
            'card_type'   => 'required|in:visa,mastercard,amex,discover',
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|digits:16',
            'cvv'         => 'required|digits:3',
            'expiry_date' => ['required', 'date_format:Y-m', function ($attribute, $value, $fail) {
                [$year, $month] = explode('-', $value);
                $expiry         = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
                if ($expiry < now()) {
                    $fail('The expiry date must be today or in the future.');
                }
            }],
        ]);

        try {
            $userId  = auth()->id();
            $project = ProjectAd::findOrFail($request->project_id);

            // Set title & description (only Buy flow, 2% down payment)
            $title       = "Buy Project";
            $description = "Buying project '{$project->project_name}' and 2% of total price paid as down payment.";

            // Save payment
            $payment = Payment::create([
                'member_id'   => $userId,
                'project_id'  => $project->project_id,
                'amount'      => $request->amount,
                'title'       => $title,
                'description' => $description,
            ]);

            // Add buyer ID into array (avoid duplicates)
            $buyers = $project->buyer_ids ?? [];
            if (! in_array($userId, $buyers)) {
                $buyers[]           = $userId;
                $project->buyer_ids = $buyers;
            }

            // Reduce available units by 1 (only if > 0)
            if ($project->available_units > 0) {
                $project->available_units -= 1;
            }

            // Only set status to "complete" when all units are sold
            if ($project->available_units <= 0) {
                $project->status = 'complete';
            }

            $project->save();

            $buyer  = User::findOrFail($userId);
            $member = User::findOrFail($project->member_id);
            $agent  = $project->agent_id ? User::findOrFail($project->agent_id) : null;

            Notification::create([
                'user_id' => $userId,
                'title'   => 'Payment Successful',
                'message' => 'Your payment for "' . $project->project_name . '" was processed successfully.',
                'type'    => 'payment',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $project->member_id,
                'title'   => 'Project Deal Completed',
                'message' => 'Congratulations! The deal for the project "' . $project->project_name . '" has been successfully completed.',
                'type'    => 'project',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $project->agent_id,
                'title'   => 'Project Deal Completed',
                'message' => 'Congratulations! The deal for the project "' . $project->project_name . '" has been successfully completed.',
                'type'    => 'project',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $project->admin_id,
                'title'   => 'Project Deal Completed',
                'message' => 'Congratulations! The deal for the project "' . $project->project_name . '" has been successfully completed.',
                'type'    => 'project',
                'is_read' => false,
            ]);

            // Send email to Buyer (with Member details)
            Mail::to($buyer->email)->send(new BuyerProjectMail($buyer, $member, $agent, $project));

            // Send email to Member (with Buyer details)
            Mail::to($member->email)->send(new ProjectOwnerMail($buyer, $member, $agent, $project));

            return response()->json([
                'success' => 'Payment successful and project status updated.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment failed: ' . $e->getMessage(),
            ], 500);
        }
    }

}
