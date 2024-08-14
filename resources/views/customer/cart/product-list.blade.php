<div class="col" id="cart-list">
    @foreach ($cart as $item)
        @php    $product = $item->product;
            $quantity = $item->quantity; 
        @endphp 
        <div class="col card mb-3" id="{{$product->id}}-item">
            <div class="row g-0">
                <div class="col-4 d-flex align-items-center">
                    <img src="{{asset('images/products/' . $product->image)}}" style="width:130px; padding:10px"
                        class="rounded product__img" alt="{{$product->name}}">
                </div>
                <div class="col-8 card-body d-flex flex-column justify-content-between" style="height:150px">
                    <h5 class="card-title fw-bold fs-3 d-flex justify-content-between">
                        <span class="text-truncate" style="max-width:120px">
                            {{$product->name}}
                        </span>
                        <span style="font-size:1rem">
                            $
                            <span id="{{$product->id}}-item-price">
                                {{number_format($product->price * $quantity, 2)}}
                            </span>
                        </span>
                    </h5>
                    <div class="fw-bold fs-3 d-flex justify-content-between align-items-center">
                        <div class="fw-bold fs-3 d-flex justify-content-between" style="width:150px">
                            <button
                                class="bg-dark border-0 text-white square rounded-start-2 dec-cart-item {{$quantity <= 1 ? 'disabled' : ''}}"
                                data-product-id="{{$product->id}}" id="{{$product->id}}-dec-btn">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <p class="text-center align-middle pt-1 m-0 square" id="{{$product->id}}-item-quantity">
                                {{$quantity}}
                            </p>
                            <button
                                class="bg-dark border-0 text-white square rounded-end-2 inc-cart-item {{$quantity >= $product->stock ? 'disabled' : ''}}"
                                data-product-id="{{$product->id}}" id="{{$product->id}}-inc-btn">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <button class="btn btn-light text-danger fs-2 p-0 square del-cart-item"
                            data-product-id="{{$product->id}}"><i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>