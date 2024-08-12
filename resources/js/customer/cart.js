import $ from "jquery";
import { alertFail, alertSuccess } from "../utils/alerts";
import { showSpinner, hideSpinner } from "../utils/spinner";

export default function () {
    const cartIcons = document.querySelectorAll(".inc-cart-item");
    cartIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            incrementCartItemQuantity(el);
        });
    });
}

function incrementCartItemQuantity(el) {
    const productId = el.getAttribute("data-product-id");
    const badge = $("#cart-count-badge");

    $.ajax({
        url: `${window.location.origin}/user/cart/${productId}/quantity/increment`,
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function() {
            showSpinner();
        },
        success: function (res) {
            el.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';
            alertSuccess(res.message);
            badge.html(res.data.nrOfCartProducts);

            window.setTimeout(function () {
                el.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>';
            }, 1000);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
        complete: function() {
            hideSpinner();
        }
    });
}
