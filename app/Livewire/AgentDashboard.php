<?php
namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\ProjectAd;
use App\Models\PropertyAd;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgentDashboard extends Component
{
    public $assignedProperties;
    public $assignedProjects;
    public $completedDeals;
    public $unreadMessages;

    public $lineChartData  = [];
    public $donutChartData = [];
    public $months         = [];

    public $propertyTypes      = ['House', 'Apartment', 'Land', 'Bungalow', 'Villa', 'Commercial'];
    public $propertyTypeCounts = [];

    public $recentActivities = [];

    public function mount()
    {
        $this->loadDashboardData();
        $this->loadChartData();
        $this->loadDonutChartData();
        $this->getRecentActivities();
    }

    // Dashboard Cards
    public function loadDashboardData()
    {
        $userId = Auth::id();

        $this->assignedProperties = PropertyAd::where('agent_id', $userId)->count();
        $this->assignedProjects   = ProjectAd::where('agent_id', $userId)->count();

        $projectDeals = ProjectAd::where('agent_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'complete')
                    ->orWhere(function ($q) {
                        $q->where('status', 'approve')
                            ->whereColumn('available_units', '<', 'total_units');
                    });
            })
            ->count();

        $propertyDeals = PropertyAd::where('agent_id', $userId)
            ->where('status', 'complete')
            ->count();

        $this->completedDeals = $propertyDeals + $projectDeals;

        $this->unreadMessages = ChatMessage::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    // Line Chart Data
    public function loadChartData()
    {
        $userId = Auth::id();

        $this->months = collect(range(1, 12))->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->format('M');
        })->toArray();

        $assignedProperties = [];
        $assignedProjects   = [];
        $completedDeals     = [];

        foreach (range(1, 12) as $month) {
            $assignedProperties[] = PropertyAd::where('agent_id', $userId)
                ->whereMonth('created_at', $month)
                ->count();

            $assignedProjects[] = ProjectAd::where('agent_id', $userId)
                ->whereMonth('created_at', $month)
                ->count();

            $propertyDeals = PropertyAd::where('agent_id', $userId)
                ->where('status', 'complete')
                ->whereMonth('created_at', $month)
                ->count();

            $projectDeals = ProjectAd::where('agent_id', $userId)
                ->whereMonth('created_at', $month)
                ->where(function ($query) {
                    $query->where('status', 'complete')
                        ->orWhere(function ($q) {
                            $q->where('status', 'approve')
                                ->whereColumn('available_units', '<', 'total_units');
                        });
                })
                ->count();

            $completedDeals[] = $propertyDeals + $projectDeals;
        }

        $this->lineChartData = [
            'assignedProperties' => $assignedProperties,
            'assignedProjects'   => $assignedProjects,
            'completedDeals'     => $completedDeals,
        ];
    }

    // Donut Chart Data (Property Types)
    public function loadDonutChartData()
    {
        $userId                   = Auth::id();
        $this->propertyTypeCounts = [];

        foreach ($this->propertyTypes as $type) {
            $count = PropertyAd::where('agent_id', $userId)
                ->where('property_type', $type)
                ->count();
            $this->propertyTypeCounts[$type] = $count;
        }

        $this->donutChartData = $this->propertyTypeCounts;
    }

    // Recent Activities
    public function getRecentActivities()
    {
        $userId     = Auth::id();
        $activities = collect();

        // Completed deals (Properties)
        $completedProperties = PropertyAd::where('agent_id', $userId)
            ->where('status', 'complete')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $completedProperties->each(function ($property) use ($activities) {
            $activities->push([
                'icon'    => 'fa-building',
                'message' => "Completed property: {$property->property_name} ({$property->location})",
                'time'       => $property->created_at->diffForHumans(),
                'created_at' => $property->created_at,
            ]);
        });

        // Completed deals (Projects)
        $completedProjects = ProjectAd::where('agent_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'complete')
                    ->orWhere(function ($q) {
                        $q->where('status', 'approve')
                            ->whereColumn('available_units', '<', 'total_units');
                    });
            })
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $completedProjects->each(function ($project) use ($activities) {
            if ($project->status === 'complete') {
                $activities->push([
                    'icon'    => 'fa-project-diagram',
                    'message' => "Completed project: {$project->project_name} ({$project->location})",
                    'time'       => $project->created_at->diffForHumans(),
                    'created_at' => $project->created_at,
                ]);
            } elseif ($project->status === 'approve' && $project->available_units < $project->total_units) {
                $soldUnits = $project->total_units - $project->available_units;
                $activities->push([
                    'icon'    => 'fa-project-diagram',
                    'message' => "Project partially completed: {$soldUnits} unit(s) sold in {$project->project_name} ({$project->location})",
                    'time' => $project->created_at->diffForHumans(),
                    'created_at' => $project->created_at,
                ]);
            }
        });

        // Recently sent messages
        $recentMessages = ChatMessage::where('sender_id', $userId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentMessages->each(function ($message) use ($activities) {
            $receiverName = $message->receiver ? $message->receiver->name : "User";
            $activities->push([
                'icon'    => 'fa-envelope',
                'message' => "You sent a message to {$receiverName}",
                'time'       => $message->created_at->diffForHumans(),
                'created_at' => $message->created_at,
            ]);
        });

        $this->recentActivities = $activities->sortByDesc('created_at')->take(10)->values();
    }

    public function render()
    {
        return view('livewire.agent-dashboard');
    }
}
