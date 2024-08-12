import $ from "jquery";

import { alertFail, alertSuccess } from "../utils/alerts";

export default function () {
    const favouriteIcons = document.querySelectorAll(".add-to-favourites");
    favouriteIcons.forEach(function (el) {
        el.addEventListener("click", function () {
            toggleFavourites(el);
        });
    });
}

function toggleFavourites(el) {
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
                reloadFavourites();
            }
            alertSuccess(res.message);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
    });
}

function reloadFavourites() {
    if (window.location.href.includes("/favourites")) {
        window.location.reload();
    }
}
