<?php
namespace App\Livewire;

use App\Models\Payment;
use App\Models\ProjectAd;
use App\Models\PropertyAd;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberDashboard extends Component
{
    public $myApprovedProperties;
    public $myApprovedProjects;
    public $myPendingApprovals;
    public $myCompletedDeals;

    public $propertySalesData   = [];
    public $propertyRentalsData = [];
    public $projectSalesData    = [];
    public $months              = [];

    public $statusLabels = [
        'Pending Property',
        'Pending Project',
        'Rejected Property',
        'Rejected Project',
        'Approved Property',
        'Approved Project',
        'Completed Property',
        'Completed Project',
    ];
    public $statusData = [];

    public $recentActivities = [];

    public function mount()
    {
        $this->loadDashboardData();
        $this->loadChartData();
        $this->loadStatusData();
        $this->getRecentActivities();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();

        $this->myApprovedProperties = PropertyAd::where('member_id', $userId)
            ->where('status', 'approve')
            ->count();

        $this->myApprovedProjects = ProjectAd::where('member_id', $userId)
            ->where('status', 'approve')
            ->count();

        $this->myPendingApprovals = PropertyAd::where('member_id', $userId)
            ->where('status', 'pending')
            ->count()
         + ProjectAd::where('member_id', $userId)
            ->where('status', 'pending')
            ->count();

        $completedProperties = PropertyAd::where(function ($query) use ($userId) {
            $query->where('member_id', $userId)
                ->orWhere('buyer_id', $userId);
        })
            ->where('status', 'complete')
            ->count();

        $completedProjects = ProjectAd::where(function ($query) use ($userId) {
            $query->where('member_id', $userId)
                ->orWhere(function ($q) use ($userId) {
                    $q->where('status', 'complete')
                        ->orWhere(function ($q2) use ($userId) {
                            $q2->where('status', 'approve')
                                ->whereJsonContains('buyer_ids', $userId);
                        });
                });
        })
            ->count();

        $this->myCompletedDeals = $completedProperties + $completedProjects;
    }

    public function loadChartData()
    {
        $userId = Auth::id();

        $this->months = collect(range(1, 12))->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->format('M');
        })->toArray();

        $this->propertySalesData   = [];
        $this->propertyRentalsData = [];
        $this->projectSalesData    = [];

        foreach (range(1, 12) as $month) {
            $this->propertySalesData[] = PropertyAd::where('member_id', $userId)
                ->where('status', 'complete')
                ->where('post_type', 'sale')
                ->whereMonth('created_at', $month)
                ->count();

            $this->propertyRentalsData[] = PropertyAd::where('member_id', $userId)
                ->where('status', 'complete')
                ->where('post_type', 'rent')
                ->whereMonth('created_at', $month)
                ->count();

            $this->projectSalesData[] = ProjectAd::where('member_id', $userId)
                ->where('status', 'complete')
                ->whereMonth('created_at', $month)
                ->count();
        }
    }

    public function loadStatusData()
    {
        $userId = Auth::id();

        $this->statusData = [
            PropertyAd::where('member_id', $userId)->where('status', 'pending')->count(),
            ProjectAd::where('member_id', $userId)->where('status', 'pending')->count(),
            PropertyAd::where('member_id', $userId)->where('status', 'rejecte')->count(),
            ProjectAd::where('member_id', $userId)->where('status', 'rejecte')->count(),
            PropertyAd::where('member_id', $userId)->where('status', 'approve')->count(),
            ProjectAd::where('member_id', $userId)->where('status', 'approve')->count(),
            PropertyAd::where('member_id', $userId)->where('status', 'complete')->count(),
            ProjectAd::where('member_id', $userId)->where('status', 'complete')->count(),
        ];
    }

    public function getRecentActivities()
    {
        $userId     = Auth::id();
        $activities = collect();

        // Recently added properties
        $recentProperties = PropertyAd::where('member_id', $userId)
            ->orderByDesc('created_at')->limit(5)->get();
        $recentProperties->each(function ($property) use ($activities) {
            $activities->push([
                'icon'    => 'fa-building',
                'message' => "Property added: {$property->property_name} ({$property->location})",
                'time'       => $property->created_at->diffForHumans(),
                'created_at' => $property->created_at,
            ]);
        });

        // Recently added projects
        $recentProjects = ProjectAd::where('member_id', $userId)
            ->orderByDesc('created_at')->limit(5)->get();
        $recentProjects->each(function ($project) use ($activities) {
            $activities->push([
                'icon'    => 'fa-project-diagram',
                'message' => "Project added: {$project->project_name} ({$project->location})",
                'time'       => $project->created_at->diffForHumans(),
                'created_at' => $project->created_at,
            ]);
        });

        // Recently done payments
        $recentPayments = Payment::where('member_id', $userId)
            ->orderByDesc('created_at')->limit(5)->get();
        $recentPayments->each(function ($payment) use ($activities) {
            $activities->push([
                'icon'       => 'fa-money-bill-wave',
                'message'    => "You made a payment of Rs. " . number_format($payment->amount) . " for " . $payment->title,
                'time'       => Carbon::parse($payment->created_at)->diffForHumans(),
                'created_at' => Carbon::parse($payment->created_at),
            ]);
        });

        // Recently added feedback
        $recentFeedback = Review::where('member_id', $userId)
            ->orderByDesc('created_at')->limit(5)->get();

        $recentFeedback->each(function ($feedback) use ($activities) {
            $activities->push([
                'icon'       => 'fa-star',
                'message'    => "You add a feedback to the system",
                'time'       => $feedback->created_at->diffForHumans(),
                'created_at' => $feedback->created_at,
            ]);
        });

        $this->recentActivities = $activities->sortByDesc('created_at')->take(10)->values();
    }

    public function render()
    {
        return view('livewire.member-dashboard');
    }
}
