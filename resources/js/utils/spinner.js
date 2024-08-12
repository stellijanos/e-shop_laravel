
import $ from 'jquery';

export function showSpinner() {
    $("#overlay").css('display', 'flex');
}

export function hideSpinner() {
    $("#overlay").css('display', 'none');
}
