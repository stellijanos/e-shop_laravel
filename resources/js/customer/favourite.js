import $ from "jquery";
import { alertFail, alertSuccess } from "../utils/alerts";
import { showSpinner, hideSpinner } from "../utils/spinner";

export function toggleFavourites() {
    addListenerToggleBtns();
}

export function removeFromFavourites() {
    addListenerRemoveBtns();
}

function addListenerToggleBtns() {
    const favouriteIcons = document.querySelectorAll(".toggle-favourites");
    if (!favouriteIcons) return;
    favouriteIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            toggle(el);
        });
    });
}

function addListenerRemoveBtns() {
    const favouriteIcons = document.querySelectorAll(".toggle-favourites");
    if (!favouriteIcons) return;
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
        beforeSend: function() {
            showSpinner();
        },
        success: function (res) {
            handleSuccessRemove(res);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
        complete: function() {
            hideSpinner();
        }
    });
}

function handleSuccessRemove(res) {
    const badge = $("#favourites-count-badge");
    const nrFavourites = Number(badge.html());

    alertSuccess(res.message);
    $("#product-list").html(res.data.html);
    badge.html(nrFavourites - 1);
    addListenerRemoveBtns();
}

function toggle(el) {
    const productId = el.getAttribute("data-product-id");
    const badge = $("#favourites-count-badge");
    const nrFavourites = Number(badge.html());
    $.ajax({
        url: `${window.location.origin}/user/favourites/${productId}/toggle`,
        type: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            showSpinner();
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

        complete: function () {
            hideSpinner();
        },
    });
}
