<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

    function favourite(button) {

        return new Promise((resolve, reject)=> {
            const productId = button.getAttribute('data-product-id');

            axios.post(`{{url('/account/favourite')}}/${productId}`)
            .then(response => {
                reloadFavourites();
                let responseText = response.data.response;
                if (responseText === "added") {
                    button.innerHTML = '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>';
                } else if (responseText === "removed") {
                    button.innerHTML = '<i class="fa-regular fa-heart fa-2x" ></i>'
                }
            })
            .catch(error => {
                //
            });
        });
    }

    function reloadFavourites() {
        if (window.location.href.includes('/favourites')) {
            window.location.reload();
        }
    }


    function addToCart(button) {
        const productId = button.getAttribute('data-product-id');
        button.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';

        axios.post(`{{url('/account/add-to-cart')}}/${productId}`)
        .then(response => {
            let responseText = response.data.response;
            if(responseText === "added") {
                button.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>';
            }
        })
        .catch(error => {});

    }

</script>