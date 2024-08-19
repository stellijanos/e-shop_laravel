@if($products->count() === 0)
    @include('customer.home.no-products')
@else 
    <div class="row mb-3">
        <!-- sort-per-page.txt -->
    </div>
    <div class="d-flex flex-row mb-3 flex-wrap column-gap-5">

        @foreach ($products as $product)
            <div class="card p-2 mb-3 product-item" style="width: 18rem; height:350px; width:200px">
                <a href="{{ route('product.show', $product->id) }}">
                    <img src="{{asset('images/products/' . $product->image)}}" style="width:100%;"
                        alt="{{$product->name}}-image" class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <a href="{{ route('product.show', $product->id) }}">
                        <h5 class="card-title text-truncate text-center" style="width:100%">{{$product->name}}</h5>
                        <p class="card-text text-truncate m-0 text-center" style="width:100%">
                            ({{$product->category->name}})
                        </p>
                        <p class="card-text text-truncate mb-3 fw-bold fs-4" style="width:100%">${{$product->price}}</p>
                    </a>
                    <div class="row justify-content-around mb-1">
                        @php
                            $favouriteIcon = !isset($favourites) || in_array($product->id, $favourites)
                                ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>'
                                : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
                        @endphp
                        <a class="col-4 text-center add-to-cart" data-product-id="{{$product->id}}">
                            <i class="fa-solid fa-cart-plus fa-2x"></i>
                        </a>
                        <a class="col-4 text-center toggle-favourites"
                            data-product-id="{{$product->id}}"><?=$favouriteIcon?></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center" id="products-link">

    </div>

@endif