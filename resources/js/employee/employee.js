import $ from "jquery";

import { alertFail, alertSuccess } from "../utils/alerts";

export default function () {
}

export const updateForm = () => {

    const updateForm = $("#update-form");
    if (!updateForm) return;
    
    const updateBtnText = $("#update-btn").html();

    $("#update-form").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                $("#alert").html("");
                $("#update-btn").html("Updating...");
            },
            success: function (res) {
                alertSuccess(res.message);

                if (res.data && res.data.image) {
                    changeImage(res.data.image);
                }



                // http://127.0.0.1:8000/images/products/
            },
            error: function (err) {
                alertFail(err.responseJSON.message);
            },
            complete: function (xhr, status) {
                $("#update-btn").html(updateBtnText);
            },
        });
    });
};

function changeImage(imageName) {
    const url = $("#show-image").attr("src");
    const imagePath = url.slice(0, url.lastIndexOf("/") + 1);
    $("#show-image").attr("src", `${imagePath}${imageName}`);
}
