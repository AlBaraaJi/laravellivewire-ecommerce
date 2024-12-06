<div>
    <div class="pagetitle">
        <h2>Categories</h2>
    </div>

    
        {{-- <button wire:click.prevent="addNew" class="btn btn-primary mb-3">Add Category</button> --}}

    <div class="d-flex justify-content-between mb-3">
        <button wire:click.prevent="addNew" class="btn btn-primary"><i class="ri-add-line"></i> Add New Category</button>
        @include('components.search-input')
    </div>

    <ul class="list-group mb-3">
        @forelse ($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $category->catagory_name }}
                <span>
                    <button wire:click.prevent="edit({{ $category }})" class="btn btn-sm btn-success">Edit</button>
                    <button wire:click.prevent="confirmDelete({{ $category->id }})" class="btn btn-sm btn-danger">Delete</button>
                </span>
            </li>
        @empty
            <li class="list-group-item">No categories found.</li>
        @endforelse
    </ul>

    {{ $categories->links() }}

    <!-- Add/Edit Category Modal -->
    <div class="modal fade" id="categoryFormModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="{{ $showEditModal ? 'updateCategory' : 'createCategory' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $showEditModal ? 'Edit Category' : 'Add Category' }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catagory_name">Category Name</label>
                            <input wire:model.defer="state.catagory_name" type="text" class="form-control @error('catagory_name') is-invalid @enderror" id="category_name" placeholder="Enter category name">
                            @error('catagory_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i>
                            @if ($showEditModal)
                                <span>Save changes</span>
                            @else
                                <span>Save</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="categoryConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Category</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button wire:click.prevent="deleteCategory" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
