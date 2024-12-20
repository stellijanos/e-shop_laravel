@if(count($cart) === 0)
    @include('customer.home.no-products')
@else
    <div class="container col-lg-7 col-md-12">
        @php 
            $subtotal = 0;
        @endphp
        @foreach ($cart as $item)
            @php
                $product = $item->product;
                $quantity = $item->quantity;
                $subtotal += $product->price * $quantity;
            @endphp
            <div class="col card mb-3 cart-item" id="{{$product->id}}-item">
                <div class="row g-0">
                    <div class="col-4 d-flex align-items-center">
                        <img src="{{ asset('images/products/' . $product->image) }}" style="width:130px; padding:10px"
                            class="rounded product__img" alt="{{ $product->name }}">
                    </div>
                    <div class="col-8 card-body d-flex flex-column justify-content-between" style="height:150px">
                        <h5 class="card-title fw-bold fs-3 d-flex justify-content-between">
                            <span class="text-truncate" style="max-width:120px">
                                {{ $product->name }}
                            </span>
                            <span style="font-size:1rem">
                                $ <span
                                    id="{{ $product->id }}-item-price">{{ number_format($product->price * $quantity, 2) }}</span>
                            </span>
                        </h5>
                        <div class="fw-bold fs-3 d-flex justify-content-between align-items-center">
                            <div class="fw-bold fs-3 d-flex justify-content-between">
                                <button
                                    class="bg-dark border-0 text-white square rounded-start-2 dec-cart-item {{ $quantity <= 1 ? 'disabled' : '' }}"
                                    data-product-id="{{ $product->id }}" id="{{ $product->id }}-dec-btn">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <p class="text-center align-middle m-0 square" id="{{ $product->id }}-item-quantity">
                                    {{ $quantity }}
                                </p>
                                <button
                                    class="bg-dark border-0 text-white square rounded-end-2 inc-cart-item {{ $quantity >= $product->stock ? 'disabled' : '' }}"
                                    data-product-id="{{ $product->id }}" id="{{ $product->id }}-inc-btn">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <button class="btn btn-light text-danger fs-2 p-0 square del-cart-item"
                                data-product-id="{{ $product->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="container col-lg-4 col-md-12">
        <div>
            @php
                $discount = isset($voucher) && !$voucher->isExpired() && $voucher->active ? ($voucher->discount_type === "fixed"
                    ? min($voucher->value, $subtotal)
                    : $subtotal * ($voucher->value / 100))
                    : 0;
                $shipping_fee = ($subtotal - $discount) < 150 ? 14.99 : 0.00;
            @endphp
            <h3 class="text-center h2">Checkout</h3>
            <hr>
            <div id="cart-summary" class="w-100">
                <div class="line">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                @if($discount)
                    <div class="line">
                        <span>Discount</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                @endif
                <div class="line">
                    <span>Shipping fee*</span>
                    <span>${{ number_format($shipping_fee, 2) }}</span>
                </div>
                <div class="line">
                    <span>Total price</span>
                    <span>${{ number_format($subtotal - $discount + $shipping_fee, 2) }}</span>
                </div>
            </div>
            <hr>
            <form id="apply-voucher-form">
                <p class="h3">Voucher</p>
                <div class="input-group">
                    <input type="text" class="form-control" name="voucher" id="voucher" placeholder="Enter code here">
                    <button class="btn btn-success input-group-text" id="apply-voucher" type="submit" {{ isset($voucher) ? 'disabled' : '' }}>Apply</button>
                </div>
                @isset($voucher)
                    <small style="color:green; padding:0 5px;">
                        -{{ $voucher->discount_type === 'percentage' ? "$voucher->value%" : "$$voucher->value" }} off
                        ({{ $voucher->code }})
                        <i class="fa-solid fa-xmark" id="remove-voucher"></i>
                    </small>
                    @if(!$voucher->active)
                        <small style="color:red; padding:0 5px;">
                            Expired voucher, please remove it.
                        </small>
                    @elseif($voucher->isExpired())
                        <small style="color:red; padding:0 5px;">
                            Invalid voucher, please remove it.
                        </small>
                    @endif
                @endisset
            </form>
            <hr>
            <div>
                <button class="btn btn-primary w-100" {{isset($voucher) && ($voucher->isExpired() || $voucher->active) ? 'disabled' : ''}}>Proceed to checkout >>></button>
            </div>
        </div>
    </div>
@endif