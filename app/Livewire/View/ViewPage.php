<?php

namespace App\Livewire\View;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Livewire\Component;

class ViewPage extends Component
{
    #[Layout('layouts.app2')]
    public function render()
    {
        $products= Product::all();
        return view('livewire.view.view-page',compact('products'));
    }
}
