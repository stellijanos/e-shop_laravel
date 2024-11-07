import $ from "jquery";

import { showSpinner, hideSpinner } from "../utils/spinner";
import { alertFail, alertSuccess } from "../utils/alerts";
import { getCurrentQueryString, updateQueryParam } from "../utils/queryString";

export default function () {
    const filters = document.querySelectorAll(".filter");
    filters.forEach((el) => {
        el.addEventListener("change", function () {
            applyFilter(el);
        });
    });
}

function applyFilter(el) {
    // console.log(el.value, el.checked, el.name);

    $.ajax({
        url: "/",
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            queryString: getCurrentQueryString(),
            specName: el.name,
            specValue: el.value,
            apply: el.checked,
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
