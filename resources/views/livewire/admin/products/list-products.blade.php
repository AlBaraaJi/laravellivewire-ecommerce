<div>
    <div class="pagetitle">
        <h1>All Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="d-flex justify-content-between mb-3">
        <button wire:click.prevent='addNew' class="btn btn-primary"><i class="ri-add-line"></i> Add New Product</button>
        {{-- search input --}}
        {{--
        <x-search-input wire:model='searchTerm' /> --}}
        @include('components.search-input')
    </div>
    <div class="row">
        @foreach ($products as $product)

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    @if ($product->image)
                    <img src="{{ asset('storage/assets/img/' . $product->image) }}" alt="{{ $product->name }}"
                        class="img-fluid mb-3">
                    @else
                    <img src="{{ asset('assets/img/default-product.jpg') }}" alt="Default Image" class="img-fluid mb-3">
                    @endif


                    <h5 class="card-title">{{$product->name}}</h5>

                    <!-- Display categories as a single line -->
                    @if($product->categories->isNotEmpty())
                    <h6 class="card-subtitle mb-2 text-muted">
                        {{ $product->categories->pluck('catagory_name')->implode(' - ') }}
                    </h6>
                    @else
                    <h6 class="text-muted">No Categories Assigned</h6>
                    @endif

                    <p class="card-text">{{$product->description}}</p>
                    <h6 class="card-text">${{$product->price}}</h4>

                        <div class="card-text ">
                            <button wire:click.prevent='edit({{$product}})' type="submit"
                                class="btn btn-success me-3"><i class="ri-edit-line">Edit</i>
                                <button wire:click.prevent='confirmDelete({{$product->id}})' type="submit"
                                    class="btn btn-danger"><i class="ri-delete-bin-6-line">Delete</i>
                        </div>


                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mb-5 d-flex justify-content-end">
        {{$products->links()}}
    </div>


    @livewire('admin.products.list-categories')


    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog" role="document" wire:ignore.self>
            {{--start form --}}
            <form action="" wire:submit.prevent='{{$showEditModal ? ' updateProduct' : 'createProduct' }}'
                autocomplete="off">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                            <span>Edit Product</span>
                            @else
                            <span>Add New Product</span>
                            @endif
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>

                            <input wire:model.defer='state.name' type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="nameHelp" placeholder="your full name">
                            @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>

                            <input wire:model.defer='state.description' type="text"
                                class="form-control @error('description') is-invalid @enderror" id="description"
                                placeholder="Description...">
                            @error('description')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">price</label>

                            <input wire:model.defer='state.price' type="text"
                                class="form-control @error('price') is-invalid @enderror" id="price"
                                placeholder="price">
                            @error('price')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" wire:ignore>
                            <label>Select Categories</label>
                            <select wire:model.defer='state.catagory_id'
                                class="select2 form-select @error('catagory_id') is-invalid @enderror" id="categories"
                                multiple="multiple" data-placeholder="Select Categories">
                                @foreach ($catagories as $catagory)
                                <option value="{{$catagory->id}}">{{$catagory->catagory_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="image">Image</label>

                            <input wire:model.defer='state.image' type="file"
                                class="form-control @error('image') is-invalid @enderror" id="image"
                                placeholder="image">
                            @error('image')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div> --}}


                        <div class="form-group mb-3">
                            <input type="file" wire:model.defer="state.image" class="form-control">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="ri-close-line"></i>Cancel</button>
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
            {{-- end form --}}
        </div>
    </div>
    {{-- end modal --}}


    <!-- Delete Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            {{--start form --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Product</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure to delete this Product?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fa fa-times mr-1"></i>Cancel</button>
                    <button wire:click.prevent='deleteProduct' type="button" class="btn btn-danger"><i
                            class="fa fa-trash mr-1"></i>
                        <span>Delete</span>
                    </button>
                </div>

            </div>
            {{-- end form --}}
        </div>
    </div>
    {{-- end delete modal --}}


</div>


@push('js')
<script>
    document.addEventListener('livewire:load', function () {
        initSelect2();
    });

    document.addEventListener('livewire:update', function () {
        initSelect2();
    });

    function initSelect2() {
        $('.select2').select2({
            theme: 'bootstrap4', // Apply Bootstrap theme
            dropdownParent: $('#form'), // Ensure dropdown appears correctly inside modal
            width: '100%', // Adjust width to match Bootstrap inputs
        }).on('change', function(){
            @this.set('state.catagory_id', $(this).val());
        });
    }

    // Initialize Select2 only after the modal is fully displayed
    $('#form').on('shown.bs.modal', function () {
        initSelect2();
    });

    // Remove focus from any focused element
    $('#form').on('hide.bs.modal', function () {
        $(this).find(':focus').blur(); 
    });


</script>

@endpush