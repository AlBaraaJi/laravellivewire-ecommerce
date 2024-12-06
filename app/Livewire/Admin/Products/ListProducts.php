<?php

namespace App\Livewire\Admin\Products;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Validator;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;



class ListProducts extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $state = [];
    public $product;
    public $showEditModal = false;
    public $productIdDelete = null;
    public $searchTerm = null;

    public function addNew()
    {
        // dd('test');
        $this->reset();
        $this->state = [];
        // $this->showEditModal = false;
        $this->dispatch("show-form");
    }


    public function createProduct()
    {
        // dd($this->state);
        $validatedata = Validator::make($this->state, [
            "name" => "required",
            "description" => "required | string",
            "price" => "required",
            "image" => "nullable|sometimes|image|max:1024", // Validate image
            "catagory_id" => "required|array",

        ])->validate();

        if (isset($this->state['image'])) {
            $originalFilename = $this->state['image']->getClientOriginalName();
            $storedFilename = time() . '-' . $originalFilename;
            $this->state['image']->storeAs('assets/img', $storedFilename, 'public');
            $validatedata['image'] = $storedFilename;
        }

        // if($this->state['image']){
        //     $validatedata['image'] = $this->state['image']->store('assets/img', 'public');
        // }

        $product = Product::create($validatedata);
        $product->categories()->attach($this->state['catagory_id']);

        // hide modal and show the toast with message
        $this->dispatch("hide-form", ['message' => 'Product Added Successfully']);

        $this->reset('state');
    }

    // ################################# Edit ########################################################################

    public function edit(Product $product)
    {
        // $this->reset();
        $this->showEditModal = true;
        $this->product = $product;
        $this->state = $product->toArray(); //to get the product data
        // Add categories as an array of IDs to the state
        $this->state['catagory_id'] = $product->categories->pluck('id')->toArray();
        $this->dispatch('show-form');
        // dd($product);
    }

    public function updateProduct()
    {
        // dd($this->state);
        // Validate form input
        $validatedata = Validator::make($this->state, [
            "name" => "required",
            "description" => "required|string",
            "price" => "required",
            "image" => isset($this->state['image']) && $this->state['image']
                ? "nullable|sometimes|image|max:1024"
                : "nullable", // Only validate if a new image is uploaded
            "catagory_id" => "required|array",
        ])->validate();


        if (isset($this->state['image']) && $this->state['image']) {

            if ($this->product->image) {
                Storage::disk('public')->delete('assets/img/' . $this->product->image);
            }

            $originalFilename = $this->state['image']->getClientOriginalName();
            $storedFilename = time() . '-' . $originalFilename;
            $this->state['image']->storeAs('assets/img', $storedFilename, 'public');

            $validatedata['image'] = $storedFilename;
        } 
        else {
            $validatedata['image'] = $this->product->image;
        }

        // if($this->state['image']){
        //     Storage::disk('public')->delete($this->product->image);
        //     $validatedata['image'] = $this->state['image']->store('assets/img', 'public');
        // }

        $this->product->update($validatedata);
        // dd('Validated data:', $validatedata);

        // Update categories
        $this->product->categories()->sync($this->state['catagory_id']);

        $this->reset('state', 'showEditModal');
        // Hide the form and show a success message
        $this->dispatch("hide-form", ['message' => 'Product Updated Successfully']);
    }


    // ################################# Delete ########################################################################

    public function confirmDelete($productId)
    {
        $this->productIdDelete = $productId;
        $this->dispatch("show-delete-modal");
        // dd($userId);
    }

    public function deleteProduct()
    {
        $product = Product::findOrFail($this->productIdDelete);
        $product->delete();
        $this->dispatch("hide-delete-form", ['message' => 'Product Deleted Successfully']);
    }



    #[Layout('layouts.app')]
    public function render()
    {
        $searchTerm = $this->searchTerm;

        $products = Product::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('price', 'like', '%' . $this->searchTerm . '%')
            ->orWhereHas('categories', function ($query) use ($searchTerm) {
                $query->where('catagory_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->latest()
            ->paginate(4);

        $catagories = Catagory::all();

        return view('livewire.admin.products.list-products', compact('products', 'catagories'));
    }

}
