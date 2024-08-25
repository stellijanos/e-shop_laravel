export function getCurrentQueryString() {
    return new URL(window.location.href).searchParams.toString();
}

export function updateQueryParam(queryString) {
    const url = new URL(window.location.href);
    url.search = queryString;
    console.log(queryString);
    history.replaceState(null, "", url.toString());
}
