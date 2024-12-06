<div>
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

                        {{-- <div class="card-text ">
                            <button wire:click.prevent='edit({{$product}})' type="submit"
                                class="btn btn-success me-3"><i class="ri-edit-line">Edit</i>
                                <button wire:click.prevent='confirmDelete({{$product->id}})' type="submit"
                                    class="btn btn-danger"><i class="ri-delete-bin-6-line">Delete</i>
                        </div> --}}


                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- <div class="mb-5 d-flex justify-content-end">
        {{$products->links()}}
    </div> --}}

    <div class="card">
        <div class="card-body">
            <!-- Product Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach ($products as $index => $product)
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}"
                            class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
    
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    @foreach ($products as $product)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            @if ($product->image)
                                <img src="{{ asset('storage/assets/img/' . $product->image) }}" class="d-block w-100"
                                    alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('assets/img/default-product.jpg') }}" class="d-block w-100"
                                    alt="Default Image">
                            @endif
    
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $product->name }}</h5>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
    
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- End Product Carousel -->
        </div>
    </div>
    




</div>