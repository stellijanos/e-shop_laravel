import $ from "jquery";

export function alertSuccess(message) {
    $("#alert").html(`
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`);

    hideAlertAfter(3000);
}

export function alertFail(message) {
    $("#alert").html(`
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`);

    hideAlertAfter(5000);
}

function hideAlertAfter(time) {
    window.setTimeout(function () {
        $("#alert").html("");
    }, time);
}
