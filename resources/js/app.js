/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "@fortawesome/fontawesome-free/css/all.min.css";

import "./bootstrap";
import { createApp } from "vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from "./components/ExampleComponent.vue";
app.component("example-component", ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// app.mount('#app');

const currentPath = window.location.pathname;

// const jsIncludes = {
//     "/": []
// }

// ###################################################

if (currentPath.includes("/products/create")) {
    import("./employee/product").then((module) => {
        module.default();
    });
}

if (currentPath.match(/^\/employee\/.*\/edit/)) {
    import("./employee/employee").then((module) => {
        module.updateForm();
    });

    if (currentPath.includes("/products")) {
        import("./employee/product").then((module) => {
            module.default();
        });
    }
}

if (
    currentPath === "/" ||
    currentPath === "/favourites" ||
    currentPath.includes("/product/")
) {
    import("./customer/cart").then((module) => {
        module.incrementCartItemQuantity();
    });
}

if (currentPath === "/" || currentPath.includes("/product/")) {
    import("./customer/favourite").then((module) => {
        module.toggleFavourites();
    });

    import("../css/spinner.css").then((module) => {
        console.log("spinner css loaded");
    });
}

if (currentPath === "/favourites") {
    import("./customer/favourite").then((module) => {
        module.removeFromFavourites();
    });
}

if (currentPath === "/cart") {
    import("../css/customer/cart.css");

    import("./customer/cart").then((module) => {
        module.incrementCartItemQuantity();
        module.decrementCartItemQuantity();
        module.deleteCartItem();
    });
}

import("../css/spinner.css").then((module) => {
    console.log("spinner css loaded");
});

console.log("janos from app.js");
