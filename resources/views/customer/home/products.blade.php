<div class="row mb-3">
    <!-- sort-per-page.txt -->
</div>

<div class="d-flex flex-row justify-content-start flex-wrap gap-5 mb-5">
    @foreach ($products as $product)

        <div class="product-item bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" style="width:150px">
            <a href="{{ route('product.show', $product->id) }}">

                <img class="rounded" src="{{asset('images/products/' . $product->image)}}" style="width:120px; height:120px"
                    alt="{{$product->name}}-image">
                <figcaption>
                    <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">{{$product->name}}</p>
                    <p class="text-truncate fw-bold m-0" style="max-width: 150px;">({{$product->category->name}})</p>
                    <p class="text-truncate m-1" style="max-width: 150px;">{{$product->description}}</p>
                    <p class="fs-5 text-start fw-bold m-2">${{$product->price}}</p>
                    <div class="row justify-content-around mb-1">
                        @php
                            $favouriteIcon = in_array($product->id, $favourites) ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>' : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
                        @endphp
                        <a class="col-4 text-center toggle-favourites"
                            data-product-id="{{$product->id}}"><?=$favouriteIcon?></a>
                        <a class="col-4 text-center inc-cart-item" data-product-id="{{$product->id}}"
                            data-new-quantity="{{($cart[$product->id] ?? 0) + 1}}"><i
                                class="fa-solid fa-cart-plus fa-2x"></i></a>
                    </div>
                </figcaption>
            </a>
        </div>
        <!-- onclick="favourite(this)" -->
    @endforeach
</div>


<div class="text-center" id="products-link">
    {{$products->links()}}
</div>
