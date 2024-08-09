<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    const updateBtnText = $('#update-btn').html();
    const id = $('#update-btn').data('id');

    $('#update-form').on('submit', function (e) {
        e.preventDefault();

        $('#alert').html('');
        $('#update-btn').html('Updating...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (res) {
                $('#alert').html(alertSuccess(res.message));
                $('#update-btn').html(updateBtnText);
                hideAlertAfter(3000);
            },
            error: function (err) {
                $('#alert').html(alertFail(err.responseJSON.message));
                $('#update-btn').html(updateBtnText);
                hideAlertAfter(3000);
            }
        })
    });

    function alertSuccess(message) {
        return `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`
    }

    function alertFail(message) {
        return `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`
    }

    function hideAlertAfter(time) {
        window.setTimeout(function () {
            $('#alert').html('');
        }, time);
    }


</script>