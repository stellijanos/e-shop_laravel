import $ from "jquery";

import { alertFail, alertSuccess } from "../utils/alerts";

export function toggleFavourites() {
    addListenerToggleBtns();
}

export function removeFromFavourites() {
    addListenerRemoveBtns();
}

function addListenerToggleBtns() {
    const favouriteIcons = document.querySelectorAll(".toggle-favourites");
    favouriteIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            toggle(el);
        });
    });
}

function addListenerRemoveBtns() {
    const favouriteIcons = document.querySelectorAll(".toggle-favourites");
    favouriteIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            remove(el);
        });
    });
}

function remove(el) {
    const productId = el.getAttribute("data-product-id");

    $.ajax({
        url: `${window.location.origin}/user/favourites/${productId}`,
        type: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: { _method: "delete" },
        success: function (res) {
            handleSuccessRemove(res);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
    });
}

function handleSuccessRemove(res) {
    const badge = $("#favourites-count-badge");
    const nrFavourites = Number(badge.html());

    alertSuccess(res.message);
    console.log(res.data);
    $("#product-list").html(getProductListHTML(res.data.products));
    badge.html(nrFavourites - 1);
    addListenerRemoveBtns();
    console.log(res);
}

function toggle(el) {
    const productId = el.getAttribute("data-product-id");
    const badge = $("#favourites-count-badge");
    const nrFavourites = Number(badge.html());
    $.ajax({
        url: `${window.location.origin}/user/favourites/${productId}`,
        type: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            if (res.status === "added") {
                badge.html(nrFavourites + 1);
                el.innerHTML =
                    '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>';
            } else if (res.status === "removed") {
                badge.html(nrFavourites - 1);
                el.innerHTML = '<i class="fa-regular fa-heart fa-2x" ></i>';
            }
            alertSuccess(res.message);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
    });
}

function getProductListHTML(products) {
    if (products.length)
        return products
            .map(
                (product) => `
    <div class="product-item bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" style="width:150px">
            <a href="/product/${product.id}">
                <img class="rounded" src="${window.location.origin}/images/products/${product.image}" style="width:120px; height:120px"
                    alt="${product.name}-image">
                <figcaption>
                    <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">${product.name}</p>
                    <p class="text-truncate fw-bold m-0" style="max-width: 150px;">(${product.category.name})</p>
                    <p class="text-truncate m-1" style="max-width: 150px;">${product.description}</p>
                    <p class="fs-5 text-start fw-bold m-2">${product.price}</p>
                    <div class="row justify-content-around mb-1">
                        <a class="col-4 text-center toggle-favourites" data-product-id="${product.id}"><i
                                class="fa-solid fa-heart fa-2x" style="color:red;"></i></a>
                        <a class="col-4 text-center add-to-cart" data-product-id="${product.id}"><i
                                class="fa-solid fa-cart-plus fa-2x"></i></a>
                    </div>
                </figcaption>
            </a>
        </div>`
            )
            .join("");

    return `
    <div id="no-products" class="text-center" style="width:100%; height:200px; display:flex; justify-content:center; align-items:center">
        <p class="fs-1 fw-bold">No products were found.</p>
    </div>`;
}
