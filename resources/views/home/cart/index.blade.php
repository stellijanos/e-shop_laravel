@extends('layouts.app')
@section('content')

@if($cart->count() !== 0 )
<style>
    #cart {
        display:flex;
        flex-direction: row;
        flex-wrap:wrap-reverse;
        justify-content: space-around;
        gap:1rem;
    }

    div.card > img {
        width:150px;
        height:150px;
    }

    #items {
        display:flex;
        flex-direction: column;
        gap:1rem;
    }

    .summary-info {
        display:flex;
        flex-direction: row;
        justify-content:space-between;
    }

</style>
@endif

<div id="cart">
    @include('home.cart.products')
</div>

@if($cart->count() !== 0 )

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const token = $('meta[name="csrf-token"]').attr('content');

function changeQuantity(button) {
    const productId = $(button).data('product-id');
    const quantity = $(button).data('quantity');
    const cart = $('#cart');

    $.ajax({
        url: `{{url('/user/cart')}}/${productId}/quantity/${quantity}`,
        type: 'POST',
        data: {
            _token: token
        },
        success: function(response) {
            cart.html(response);
        },
        error: function(xhr) {
            cart.html(xhr.responseText);
        }
    });
}


</script>

@endif

@endsection
