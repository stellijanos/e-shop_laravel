import $ from "jquery";
import { alertFail, alertSuccess } from "../utils/alerts";
import { showSpinner, hideSpinner } from "../utils/spinner";

export const addItem = () => setEventListener("add-to-cart", add);
export const deleteItem = () => setEventListener("del-cart-item", remove);
export const incQuantity = () => setEventListener("inc-cart-item", increment);
export const decQuantity = () => setEventListener("dec-cart-item", decrement);

export const applyCoupon = () => {
    document
        .getElementById("apply-voucher-form")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            const url = "/user/cart/voucher";
            const data = { voucher: document.getElementById("voucher").value };
            ajaxCall({ url, data });
        });
};

function setEventListener(className, callback) {
    const cartIcons = document.querySelectorAll(`.${className}`);
    cartIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            callback(el);
        });
    });
}

function add(el) {
    const productId = el.getAttribute("data-product-id");
    const url = `${window.location.origin}/user/cart/${productId}/quantity/increment`;
    const data = { getHtml: false };
    ajaxCall({ el, url, data });
}

function remove(el) {
    const productId = el.getAttribute("data-product-id");
    const url = `${window.location.origin}/user/cart/${productId}`;
    const data = { _method: "delete" };
    ajaxCall({ el, url, data });
}

function increment(el) {
    const productId = el.getAttribute("data-product-id");
    const url = `${window.location.origin}/user/cart/${productId}/quantity/increment`;
    const data = {};
    ajaxCall({ el, url, data });
}

function decrement(el) {
    const productId = el.getAttribute("data-product-id");
    const url = `${window.location.origin}/user/cart/${productId}/quantity/decrement`;
    const data = {};
    ajaxCall({ el, url, data });
}

function ajaxCall({ el, url, data }) {
    $.ajax({
        url,
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            showSpinner();
        },
        data,
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
    // common
    alertSuccess(res.message);

    if (res.data.voucher) {
        handleVoucher(res.data);
        return;
    }

    const badge = $("#cart-count-badge");
    badge.html(res.data.nrOfCartProducts);
    // remove - increment - decrement
    $("#cart-list").html(res.data.html);

    if (res.data.html) {
        setEventListener("del-cart-item", remove);
        setEventListener("inc-cart-item", increment);
        setEventListener("dec-cart-item", decrement);
    } else {
        // add
        toggleTickIcon(el);
    }
}

function handleVoucher(data) {
    console.log(data.voucher);
    $('#voucher').val('');
    $('#apply-voucher-form').append(`
        <p style="color:green; padding:0 5px;">
            -${data.discount_type === "percentage" ? `${data.value}%` : `$${data.value}` } off (${data.voucher})
            <i class="fa-solid fa-xmark" id="discard-voucher"></i>
        </p>`);
}

function toggleTickIcon(el) {
    el.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';
    window.setTimeout(function () {
        el.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>';
    }, 1000);
}
