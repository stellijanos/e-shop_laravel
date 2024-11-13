
import $ from "jquery";
import { alertSuccess, alertFail } from "../utils/alerts";

export default function () {
    const voucherBtns = document.querySelectorAll('.voucher-active-switch');
    if (!voucherBtns) return;
    voucherBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            toggleVoucherActive(btn);
        });
    });
}

function toggleVoucherActive(btn) {
    const voucherId = btn.dataset.voucherId;
    const url = `${window.location.origin}/employee/vouchers/${voucherId}/toogle-active`;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url,
        type: "PUT",
        beforeSend: function () {
            $("#alert").html("");
        },
        success: function (res) {
            btn.checked = res.data.isActive;
            alertSuccess(res.message || 'Successful.');
        },
        error: function (err) {
            alertFail(err.responseJSON?.message || 'Something went wrong.');
        },
        complete: function () {

        }
    })
}
