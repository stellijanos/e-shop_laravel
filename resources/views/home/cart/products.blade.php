



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
                    <p class="card-text fw-bold">&euro;{{$item->product->price}}</p>
                </div>
                <div class="summary-info">
                    <p class="text-truncate" style="max-width:80%">{{$item->product->description}}</p>

                    <div class="quantity">
                        <button class="btn btn-light rounded-circle"><i class="fa-solid fa-minus"></i></button>
                    </div>
                    <p class="card-text">{{$item->quantity}}x</p>
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
                <p class="card-text">{{$total_cost}}</p>
            </div>
            <div class="summary-info">
                <h5 class="card-title">Shipping fee:</h5>
                <p class="card-text">{{0+5000}}</p>
            </div>
            <div class="summary-info">
                <h5 class="card-title">Total cost:</h5>
                <p class="card-text">{{0+5}}</p>
            </div>
            
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
</div>

