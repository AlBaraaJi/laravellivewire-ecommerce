<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Catagory;
use Livewire\WithPagination;

class ListCategories extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $category;
    public $showEditModal = false;
    public $categoryIdDelete = null;
    public $searchTerm = null;

    public function addNew()
    {
        $this->reset();
        $this->state = [];
        $this->dispatch("show-catagory-form");
    }

    public function createCategory()
    {
        $validatedData = $this->validate([
            "state.catagory_name" => "required|string|max:255",
        ]);

        Catagory::create(['catagory_name' => $validatedData['state']['catagory_name']]);

        $this->dispatch("hide-catagory-form", ['message' => 'Category Added Successfully']);
        $this->reset('state');
    }

    public function edit(Catagory $category)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->category = $category;
        $this->state = $category->toArray();
        $this->dispatch('show-catagory-form');
    }

    public function updateCategory()
    {
        $validatedData = $this->validate([
            "state.catagory_name" => "required|string|max:255",
        ]);

        $this->category->update(['catagory_name' => $validatedData['state']['catagory_name']]);

        $this->dispatch("hide-catagory-form", ['message' => 'Category Updated Successfully']);
        $this->reset('state', 'showEditModal');
    }

    public function confirmDelete($categoryId)
    {
        $this->categoryIdDelete = $categoryId;
        $this->dispatch("show-delete-catagorymodal");
    }

    public function deleteCategory()
    {
        Catagory::findOrFail($this->categoryIdDelete)->delete();

        $this->dispatch("hide-delete-catagoryform", ['message' => 'Category Deleted Successfully']);
    }

    public function render()
    {
        $categories = Catagory::query()
            ->where('catagory_name', 'like', '%' . $this->searchTerm . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.products.list-categories',compact('categories'));
    }
}
