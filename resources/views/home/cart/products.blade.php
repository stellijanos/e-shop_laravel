

    @if($cart->count() === 0 )
        @include('home.no-products')
    @else  
    <div id="items" class="">
    @php 
    $total_cost = 0;
    @endphp
        @foreach ($cart as $item)
            @php 
                $total_cost += $item->quantity * $item->product->price;
            @endphp
            <div class="card" style="display:flex; flex-direction:row; width:600px !important">
                <img src="{{asset('public/images/products/'.$item->product->image)}}" class="card-img-top img-thumbnail" alt="{{$item->product->name}}">
                <div class="card-body">
                    <div class="summary-info">
                        <a href="{{url('/product/'.$item->product->id)}}" class="text-dark"><h5 class="card-title fw-bold">{{$item->product->name}}</h5></a>
                        <p class="card-text fw-bold">&euro;{{number_format($item->product->price * $item->quantity)}}</p>
                    </div>
                    <div class="summary-info">
                        <p class="text-truncate" style="max-width:80%">{{$item->product->description}}</p>

                        <div class="quantity d-flex flex-direction-row align-items-baseline">
                            <button class="btn bg-secondary-subtle rounded-circle" data-product-id="{{$item->product->id}}" {{$item->quantity === 1 ? 'disabled' : ''}} data-quantity="{{$item->quantity-1}}" onclick="changeQuantity(this)"><i class="fa-solid fa-minus"></i></button>
                            <p style="width:40px!important" class="text-center">{{$item->quantity}}</p>
                            <button class="btn bg-secondary-subtle rounded-circle" data-product-id="{{$item->product->id}}" {{$item->quantity === $item->product->stock ? 'disabled' : ''}} data-quantity="{{$item->quantity+1}}" onclick="changeQuantity(this)"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @php
        $shipping_fee = $total_cost > 150  ? 0 : 15;
    @endphp 
    </div>

    <div id="checkout">
        <div class="card" style="width:500px">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                <div class="summary-info">
                    <h5 class="card-title">Products cost:</h5>
                    <p class="card-text">&euro;{{number_format($total_cost,2)}}</p>
                </div>
                <div class="summary-info">
                    <h5 class="card-title">Shipping fee:</h5>
                    <p class="card-text">&euro;{{number_format($shipping_fee, 2)}}</p>
                </div>
                <hr>
                <div class="summary-info mb-3">
                    <h5 class="card-title fs-4">Total cost:</h5>
                    <p class="card-text fs-4 fw-bold">&euro;{{number_format($total_cost + $shipping_fee, 2)}}</p>
                </div>
                <a href="#" class="btn btn-success">>>> Proceed to checkout >>></a>
            </div>
        </div>
    </div>
@endif
