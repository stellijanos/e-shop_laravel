export const imports = async (currentPath) => {
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
            module.addItem();
        });
    }

    if (currentPath === "/" || currentPath.includes("/product/")) {
        import("./customer/favourite").then((module) => {
            module.toggleFavourites();
        });

        import("../css/spinner.css").then((module) => {
            // console.log("spinner css loaded");
        });
    }

    if (currentPath === "/favourites") {
        import("./customer/favourite").then((module) => {
            module.removeFromFavourites();
        });
    }

    if (currentPath === "/cart") {
        import("../css/customer/cart.css").then(() => {
            // console.log("cart css loaded.");
        });

        import("./customer/cart").then((module) => {
            module.incQuantity();
            module.decQuantity();
            module.deleteItem();
            module.applyVoucher();
            module.discardVoucher();
        });
    }

    import("../css/spinner.css").then((module) => {
        // console.log("spinner css loaded");
    });

    import("../css/product/product.css").then((module) => {
        // console.log("Product css loaded!");
    });

    if (currentPath === "/") {
        import("./customer/filter").then((module) => {
            module.default();
        });
    }

    if (currentPath.includes("/employee")) {
        import("../css/employee/employee.css").then(() => {
            // console.log("imported");
        });
    }

    if (currentPath === "/" || currentPath === "/favourites") {
        import("./customer/products-sort-by").then((module) => {
            module.default();
        });
    }
};
