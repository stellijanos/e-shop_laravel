import $ from "jquery";
import { alertFail, alertSuccess } from "../utils/alerts";
import { showSpinner, hideSpinner } from "../utils/spinner";

export function incrementCartItemQuantity() {
    const cartIcons = document.querySelectorAll(".inc-cart-item");
    cartIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            incrementQuantity(el);
        });
    });
}

export function decrementCartItemQuantity() {
    const cartIcons = document.querySelectorAll(".dec-cart-item");
    cartIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            decrementQuantity(el);
        });
    });
}

function incrementQuantity(el) {
    const productId = el.getAttribute("data-product-id");

    $.ajax({
        url: `${window.location.origin}/user/cart/${productId}/quantity/increment`,
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            showSpinner();
        },
        success: function (res) {
            handleSuccess({ el, res });
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
        complete: function () {
            hideSpinner();
        },
    });
}

function decrementQuantity(el) {
    const productId = el.getAttribute("data-product-id");
    $.ajax({
        url: `${window.location.origin}/user/cart/${productId}/quantity/decrement`,
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            showSpinner();
        },
        success: function (res) {
            handleSuccess({ el, res });
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
        complete: function () {
            hideSpinner();
        },
    });
}

function handleSuccess({ el, res }) {
    const badge = $("#cart-count-badge");
    const cartItem = res.data.cartItem;

    alertSuccess(res.message);
    badge.html(res.data.nrOfCartProducts);

    if (window.location.pathname === "/cart") {
        setCartItemDetails(res.data.cartItem);
    } else {
        toggleTickIcon(el);
    }
}

function toggleTickIcon(el) {
    el.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';

    window.setTimeout(function () {
        el.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>';
    }, 1000);
}

function setCartItemDetails(cartItem) {
    const incBtn = $(`#${cartItem.product.id}-inc-btn`);
    const decBtn = $(`#${cartItem.product.id}-dec-btn`);

    $(`#${cartItem.product.id}-item-price`).html(
        Number(cartItem.product.price * cartItem.quantity).toFixed(2)
    );
    $(`#${cartItem.product.id}-item-quantity`).html(cartItem.quantity);

    if (!incBtn || !decBtn) return;
    decBtn.toggleClass("disabled", cartItem.quantity <= 1);
    incBtn.toggleClass("disabled", cartItem.quantity >= cartItem.product.stock);
}
