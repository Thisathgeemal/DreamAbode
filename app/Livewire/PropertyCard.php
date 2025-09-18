<?php
namespace App\Livewire;

use App\Models\PropertyAd;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyCard extends Component
{
    use WithPagination;

    public $search       = '';
    public $postType     = '';
    public $propertyType = '';
    public $location     = '';
    public $maxPrice     = null;
    public $minBedrooms  = null;
    public $minBathrooms = null;

    // Reset page when filter changes
    public function updating($field, $value)
    {
        $this->resetPage();
    }

    // Clear all filters
    public function resetFilters()
    {
        $this->reset(['search', 'propertyType', 'location', 'maxPrice', 'minBedrooms', 'minBathrooms']);
    }

    public function render()
    {
        $properties = PropertyAd::query()
            ->where('status', 'approve')
            ->when($this->search, fn($q) =>
                $q->where('property_name', 'like', "%{$this->search}%")
            )
            ->when($this->propertyType, fn($q) =>
                $q->where('property_type', $this->propertyType)
            )
            ->when($this->location, fn($q) =>
                $q->where('location', 'like', "%{$this->location}%")
            )
            ->when($this->postType, fn($q) =>
                $q->where('post_type', $this->postType)
            )
            ->when($this->maxPrice, fn($q) =>
                $q->where('price', '<=', $this->maxPrice)
            )
            ->when($this->minBedrooms, fn($q) =>
                $q->where('bedrooms', '>=', $this->minBedrooms)
            )
            ->when($this->minBathrooms, fn($q) =>
                $q->where('bathrooms', '>=', $this->minBathrooms)
            )
            ->paginate(8)
            ->through(function ($property) {
                $property->formatted_price = $this->formatPrice($property->price);
                return $property;
            });

        return view('livewire.property-card', compact('properties'));
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
