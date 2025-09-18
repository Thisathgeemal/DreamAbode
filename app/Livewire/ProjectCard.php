<?php
namespace App\Livewire;

use App\Models\ProjectAd;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectCard extends Component
{
    use WithPagination;

    public $search           = '';
    public $projectType      = '';
    public $location         = '';
    public $maxPrice         = null;
    public $minParkingSpaces = null;
    public $projectStatus    = '';

    // Reset page when any filter changes
    public function updating($field)
    {
        $this->resetPage();
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->reset(['search', 'projectType', 'location', 'maxPrice', 'minParkingSpaces', 'projectStatus']);
    }

    public function render()
    {
        $projects = ProjectAd::query()
            ->where('status', 'approve')
            ->when($this->search, fn($q) =>
                $q->where('project_name', 'like', "%{$this->search}%")
            )
            ->when($this->projectType, fn($q) =>
                $q->where('property_type', $this->projectType)
            )
            ->when($this->location, fn($q) =>
                $q->where('location', 'like', "%{$this->location}%")
            )
            ->when($this->maxPrice, fn($q) =>
                $q->where('price', '<=', $this->maxPrice)
            )
            ->when($this->minParkingSpaces, fn($q) =>
                $q->where('parking_spaces', '>=', $this->minParkingSpaces)
            )
            ->when($this->projectStatus, fn($q) =>
                $q->where('project_status', $this->projectStatus)
            )
            ->paginate(8)
            ->through(function ($project) {
                $project->formatted_price = $this->formatPrice($project->price);
                return $project;
            });

        return view('livewire.project-card', compact('projects'));
    }

    // Format price to K (thousands) and M (millions)
    private function formatPrice($price)
    {
        if (! $price) {
            return '0';
        }

        if ($price >= 1000000) {
            return round($price / 1000000, 1) . 'M';
        }

        if ($price >= 1000) {
            return round($price / 1000, 1) . 'K';
        }

        return $price;
    }
}
