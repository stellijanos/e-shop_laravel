
import $ from 'jquery';

export function showSpinner() {
    $("#spinner-overlay").css('display', 'flex');
}

export function hideSpinner() {
    $("#spinner-overlay").css('display', 'none');
}
