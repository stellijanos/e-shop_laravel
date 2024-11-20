import $ from 'jquery';
import { alertFail, alertSuccess } from '../utils/alerts';

export const updateReview = () => handleReview('btn-review-modal', 'form-review-modal');
export const deleteReview = () => handleReview('delete-review-btn', 'delete-review-form');


function handleReview(btnId, formId) {

    const btn = document.getElementById(btnId);
    if (!btn) return;
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const form = document.getElementById(formId);
        const formData = new FormData(form);

        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#alert").html("");
            },
            success: function (res, textStatus, jqXHR) {

                if (jqXHR.status === 200) {
                    update(res.data.review);
                    alertSuccess(res.message || 'Successful.');
                } else if (jqXHR.status === 204) {
                    remove(btn.getAttribute('data-review'));
                    alertSuccess('Review successfully deleted.');
                }
            },
            error: function (err) {
                alertFail(err.responseJSON?.message || 'Something went wrong.');
            },
            complete: function () {

            }
        });

    });
}

function remove(reviewId) {
    const currentReview = document.getElementById(reviewId);
    if (!currentReview) {
        return;
    }
    currentReview.remove();
}


function update(review) {
    const currentReview = document.getElementById(`review-${review.product_id}-${review.user_id}-description`);
    if (!currentReview) {
        return window.location.reload();
    }
    currentReview.innerHTML = review.description
        ? `<p>"${review.description}"</p>` : '';

    markRatingsChecked(review.rating);
}

function markRatingsChecked(rating) {
    const ratingElements = document.querySelectorAll('.user-rating > span');
    ratingElements.forEach((element, index) => {
        if (index < rating) {
            element.classList.add('checked');
        } else {
            element.classList.remove('checked');
        }
    });
}
