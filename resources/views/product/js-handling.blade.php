<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    const cartIcons = document.querySelectorAll('.add-to-cart');
    cartIcons.forEach(function (el) {
        el.addEventListener('click', function () {
            addToCart(el);
        });
    });

    const favouriteIcons = document.querySelectorAll('.add-to-favourites');
    favouriteIcons.forEach(function (el) {
        el.addEventListener('click', function () {
            addToFavourites(el)
        });
    });

    function addToCart(el) {
        const productId = el.getAttribute('data-product-id');
        const quantity = 1;
        el.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';

        $.ajax({
            url: `${window.location.origin}/user/cart/${productId}/quantity/${quantity}'}`,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.status !== 'success') alertFail(res.message);
                if (res.message === 'added') el.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>'
            },
            error: function (err) {
                alertFail(err);
            }
        });
    }

    function addToFavourites(el) {
        const productId = el.getAttribute('data-product-id');

        $.ajax({
            url: `${window.location.origin}/user/favourites/${productId}`,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                reloadFavourites();
                if (res.status !== 'success') return alertFail(res.message);
                if (res.message === 'added') return el.innerHTML = '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>';
                if (res.message === 'removed') return el.innerHTML = '<i class="fa-regular fa-heart fa-2x" ></i>';
            },
            error: function (err) {
                alertFail(err.message);
            }
        });
    }

    function reloadFavourites() {
        if (window.location.href.includes('/favourites')) {
            window.location.reload();
        }
    }

    function alertFail(message) {
        console.log(message);
    }

    function alertSuccess(message) {
        console.log(message);
    }

</script>