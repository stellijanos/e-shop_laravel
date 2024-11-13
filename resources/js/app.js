import "@fortawesome/fontawesome-free/css/all.min.css";
import "./bootstrap";
import 'bootstrap-icons/font/bootstrap-icons.css';

function showPage() {
    const spinner = document.getElementById("spinner-overlay");
    const app = document.getElementById("app");
    const footer = document.getElementsByTagName("footer")[0];
    // document.body.removeChild(spinner);
    spinner.style.display = "none";
    spinner.style.background = "rgba(0, 0, 0, 0.2)";
    app.style.display = "block";
    footer.style.display = "block";

}

document.addEventListener("DOMContentLoaded", () => {
    const page = document.getElementById('app-page')?.getAttribute('data-page');

    if (!page) {
        showPage();
        return;
    }

    try {
        import(`./pages/${page}.js`)
            .then(module => {
                module.default();
            })
            .then(() => showPage())
            .catch(error => {
                console.error(`Error loading module for page "${page}":`, error);
            });
    } catch (error) {
        console.error(`Error loading module for page "${page}":`, error);
    }

});
