import $ from "jquery";

import { showSpinner, hideSpinner } from "../utils/spinner";
import { alertSuccess } from "../utils/alerts";

export default function () {
    const filters = document.querySelectorAll(".filter");
    filters.forEach((el) => {
        el.addEventListener("change", function () {
            applyFilter(el);
        });
    });
}

function applyFilter(el) {
    console.log(el.value, el.checked, el.name);

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
            $('#product-list').html(res.data.html);
            alertSuccess(res.message);
            updateQueryParam(res.data.queryString);
        },
        error: function (err) {
            console.log(err.responseJSON);
        },
        complete: function () {
            hideSpinner();
        },
    });
}

function updateQueryParam(queryString) {
    const url = new URL(window.location.href);
    url.search = queryString;
    console.log(queryString);
    history.replaceState(null, "", url.toString());
}

function toggleQueryParam(el) {
    const currentUrl = window.location.href;
    let url = new URL(currentUrl);

    const searchedValue = `${encodeURIComponent(
        `${el.name}[]`
    )}=${encodeURIComponent(el.value)}`;

    if (el.checked) {
        url.searchParams.append(`${el.name}[]`, el.value);
    } else {
        let queryString = url.searchParams
            .toString()
            .split("&")
            .filter((value) => value !== searchedValue)
            .join("&");

        url = `${window.location.pathname}${
            queryString ? "?" + queryString : ""
        }`;
    }

    history.replaceState(null, "", url);
}

function getCurrentQueryString() {
    return new URL(window.location.href).searchParams.toString();
}
