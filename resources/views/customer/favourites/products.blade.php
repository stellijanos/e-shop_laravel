@if($products->count() === 0)
    @include('customer.home.no-products')
@else
    @foreach($products as $product)
        <div class="product-item bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" id="product-{{$product->id}}" style="width:150px">
            <a href="{{ route('product.show', ['product' => $product->id]) }}">
                <img class="rounded" src="{{asset('images/products/' . $product->image)}}" style="width:120px; height:120px"
                    alt="{{$product->name}}-image">
                <figcaption>
                    <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">{{$product->name}}</p>
                    <p class="text-truncate fw-bold m-0" style="max-width: 150px;">({{$product->category->name}})</p>
                    <p class="text-truncate m-1" style="max-width: 150px;">{{$product->description}}</p>
                    <p class="fs-5 text-start fw-bold m-2">${{$product->price}}</p>
                    <div class="row justify-content-around mb-1">
                        <a class="col-4 text-center toggle-favourites" data-product-id="{{$product->id}}"><i
                                class="fa-solid fa-heart fa-2x" style="color:red;"></i></a>
                        <a class="col-4 text-center inc-cart-item" data-product-id="{{$product->id}}"><i
                                class="fa-solid fa-cart-plus fa-2x"></i></a>
                    </div>
                </figcaption>
            </a>
        </div>
    @endforeach
@endif 