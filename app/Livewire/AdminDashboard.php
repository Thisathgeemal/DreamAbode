<?php
namespace App\Livewire;

use App\Models\Payment;
use App\Models\ProjectAd;
use App\Models\PropertyAd;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalAdmins;
    public $totalMembers;
    public $totalAgents;
    public $todaysRevenue;
    public $totalProperties;
    public $totalProjects;
    public $pendingApprovals;
    public $completedDeals;

    public $propertySalesData   = [];
    public $propertyRentalsData = [];
    public $projectSalesData    = [];
    public $months              = [];

    public $monthlyRevenue = [];

    public $propertyTypes      = ['House', 'Apartment', 'Land', 'Bungalow', 'Villa', 'Commercial'];
    public $propertyTypeCounts = [];

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

    public function mount()
    {
        $this->loadDashboardData();
        $this->loadChartData();
        $this->loadPropertyTypeData();
        $this->loadStatusData();
        $this->loadRevenueData();
    }

    public function loadDashboardData()
    {
        $this->totalAdmins  = User::whereJsonContains('user_roles', 'admin')->count();
        $this->totalMembers = User::whereJsonContains('user_roles', 'member')->count();
        $this->totalAgents  = User::whereJsonContains('user_roles', 'agent')->count();

        $this->todaysRevenue = Payment::whereDate('created_at', Carbon::today())
            ->sum('amount');

        $this->totalProperties = PropertyAd::where('status', 'approve')->count();
        $this->totalProjects   = ProjectAd::where('status', 'approve')->count();

        $this->pendingApprovals = PropertyAd::where('status', 'pending')->count() +
        ProjectAd::where('status', 'pending')->count();

        $this->completedDeals = PropertyAd::where('status', 'complete')->count() +
        ProjectAd::where('status', 'complete')->count();
    }

    public function loadChartData()
    {
        $this->months = collect(range(1, 12))->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->format('M');
        })->toArray();

        $this->propertySalesData   = [];
        $this->propertyRentalsData = [];
        $this->projectSalesData    = [];

        foreach (range(1, 12) as $month) {
            $this->propertySalesData[] = PropertyAd::where('status', 'complete')
                ->where('post_type', 'sale')
                ->whereMonth('created_at', $month)
                ->count();

            $this->propertyRentalsData[] = PropertyAd::where('status', 'complete')
                ->where('post_type', 'rent')
                ->whereMonth('created_at', $month)
                ->count();

            $this->projectSalesData[] = ProjectAd::where('status', 'complete')
                ->whereMonth('created_at', $month)
                ->count();
        }
    }

    public function loadRevenueData()
    {
        $this->monthlyRevenue = [];

        foreach (range(1, 12) as $month) {
            $this->monthlyRevenue[] = Payment::whereMonth('created_at', $month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('amount');
        }
    }

    public function loadPropertyTypeData()
    {
        $this->propertyTypeCounts = [];

        foreach ($this->propertyTypes as $type) {
            $this->propertyTypeCounts[] = PropertyAd::where('status', 'approve')
                ->where('property_type', $type)
                ->count();
        }
    }

    public function loadStatusData()
    {
        $this->statusData = [
            PropertyAd::where('status', 'pending')->count(),
            ProjectAd::where('status', 'pending')->count(),
            PropertyAd::where('status', 'rejecte')->count(),
            ProjectAd::where('status', 'rejecte')->count(),
            PropertyAd::where('status', 'approve')->count(),
            ProjectAd::where('status', 'approve')->count(),
            PropertyAd::where('status', 'complete')->count(),
            ProjectAd::where('status', 'complete')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
