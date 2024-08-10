import $ from "jquery";

export default function () {
    console.log("Employee file");
}

export const updateForm = () => {
    console.log("employee options edit form");

    const updateBtnText = $("#update-btn").html();

    $("#update-form").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        // console.log();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                $("#alert").html("");
                $("#update-btn").html("Updating...");
            },
            success: function (res) {
                $("#alert").html(alertSuccess(res.message));

                if (res.data.image) {
                    changeImage(res.data.image);
                }

                // http://127.0.0.1:8000/images/products/
            },
            error: function (err) {
                $("#alert").html(alertFail(err.responseJSON.message));
            },
            complete: function (xhr, status) {
                $("#update-btn").html(updateBtnText);
                hideAlertAfter(3000);
            },
        });
    });
};

function changeImage(imageName) {
    const url = $("#show-image").attr("src");
    const imagePath = url.slice(0, url.lastIndexOf("/") + 1);
    $("#show-image").attr("src", `${imagePath}${imageName}`);
}

function alertSuccess(message) {
    return `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
}

function alertFail(message) {
    return `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
}

function hideAlertAfter(time) {
    window.setTimeout(function () {
        $("#alert").html("");
    }, time);
}
