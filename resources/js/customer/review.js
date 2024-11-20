import $ from 'jquery';
import { alertFail, alertSuccess } from '../utils/alerts';

export default function () {

    const btnReviewModal = document.getElementById('btn-review-modal');
    if (!btnReviewModal) return;
    btnReviewModal.addEventListener('click', function (e) {
        e.preventDefault();

        const form = document.getElementById('form-review-modal');
        const formData = new FormData(form);

        // Creating an object to log data for debugging purposes
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
            processData: false,  // Prevents jQuery from processing the data
            contentType: false,  // Prevents jQuery from setting the Content-Type header
            beforeSend: function () {
                $("#alert").html("");
            },
            success: function (res) {
                console.log(res);
                updateReview(res.data.review);


                alertSuccess(res.message || 'Successful.');
            },
            error: function (err) {
                alertFail(err.responseJSON?.message || 'Something went wrong.');
            },
            complete: function () {
                // Any additional cleanup code can go here
            }
        });

        console.log(data);  // Debugging the data
    });
}

function updateReview(review) {
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
            element.classList.add('checked'); // Add a checked class
        } else {
            element.classList.remove('checked'); // Remove the checked class if any
        }
    });
}
