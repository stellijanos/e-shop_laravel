<div id="checkout">
    <div class="card" style="width:500px">
        <div class="card-header">
            Order Summary
        </div>
        <div class="card-body">
            <div class="summary-info">
                <h5 class="card-title">Products cost:</h5>
                <p class="card-text">&euro;{{number_format($total_cost, 2)}}</p>
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