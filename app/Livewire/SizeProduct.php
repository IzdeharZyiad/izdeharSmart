<?php

namespace App\Livewire;

use Livewire\Component;

class SizeProduct extends Component
{
    public $sizeTypes = [
        1 => 'أحجام الملابس',
        2 => 'أحجام الأطفال',
        3 => 'الأحذية',
        4 => ' الأوزان (للأغذية / المواد)',
        5 => 'السوائل',
        6 => 'الإلكترونيات',
        7 => ' أحجام عامة',
        8 => 'مطعم',
    ];

    public $sizesByType = [
        1 => ['S', 'M', 'L', 'XL', '2xl', '>2xl'],
        2 => ['newborn', '0-3 month', '3-6 month', '6-12 month', '1-2 years', '3-4 years', '5-6 years'],
        3 => ['<38', 38, 39, 40, 41, 42, '>42'],
        4 => ['100g', '250g',  '500g', '1kg', '>1kg'],
        5 => ['250ml', '330ml',  '500ml', '1L', '>1L'],
        6 => ['64GB', '128GB',  '256GB', '512GB', '1TB', '4GB RAM / 64GB Storage', '6GB RAM / 128GB Storage', '8GB RAM / 128GB Storage', '8GB RAM / 256GB Storage',
            '12GB RAM / 256GB Storage', '12GB RAM / 512GB Storage'],
        7 => ['Small', 'Medium',  'Large', 'Extra Large', '5xl', '6xl'],
        8 => ['صحن', 'Medium',  'Large'],
    ];

    public $sizeType_id;
    public $sizes = [];

    public function updateSizeType_id($value)
    {
        $this->sizes = $this->sizesByType[$value] ?? [];
    }

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.size-product');
    }
}
