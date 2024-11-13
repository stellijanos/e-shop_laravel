import $ from "jquery";
import { alertFail, alertSuccess } from "../utils/alerts";
import { showSpinner, hideSpinner } from "../utils/spinner";
import { getCurrentQueryString, updateQueryParam } from "../utils/queryString";

export default function () {
    addListenerSortBy();
}

function addListenerSortBy() {
    const sortBySelect = document.getElementById("sort-by");
    if (!sortBySelect) return;
    sortBySelect.addEventListener("change", function () {
        sortBy(this.value);
    });
}

function sortBy(sortBy) {
    $.ajax({
        url: "/",
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            queryString: getCurrentQueryString(),
            specName: "sortBy",
            specValue: sortBy,
            apply: true,
        },
        beforeSend: function () {
            showSpinner();
        },
        success: function (res) {
            $("#product-list").html(res.data.html);
            alertSuccess(res.message);
            updateQueryParam(res.data.queryString);
            $("#nr-products").html(res.data.nrProducts);
        },
        error: function (err) {
            alertFail(err.responseJSON);
        },
        complete: function () {
            hideSpinner();
        },
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
        beforeSend: function () {
            showSpinner();
        },
        success: function (res) {
            $("#product-list").html(res.data.html);
            alertSuccess(res.message);
            updateQueryParam(res.data.queryString);
            $("#nr-products").html(res.data.nrProducts);
        },
        error: function (err) {
            alertFail(err.responseJSON.message);
        },
        complete: function () {
            hideSpinner();
        },
    });
}
