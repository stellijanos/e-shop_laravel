import { functions } from "lodash";

const modulesConfig = {
    "/": [
        { module: "./customer/cart", functions: ["addItem"] },
        { module: "./customer/favourite", functions: ["toggleFavourites"] },
        { module: "./customer/products-sort-by", functions: ["default"] },
        { module: "./customer/filter", functions: ["default"] },
        { module: "../css/spinner.css", functions: null },
    ],
    "/favourites": [
        { module: "./customer/cart", functions: ["addItem"] },
        {
            module: "./customer/favourite",
            functions: ["removeFromFavourites"],
        },
    ],

    "/cart": [
        {
            module: "./customer/cart",
            functions: [
                "incQuantity",
                "decQuantity",
                "deleteItem",
                "applyVoucher",
                "discardVoucher",
            ],
        },
        { module: "../css/customer/cart.css", functions: null },
    ],

    "/product/.*": [
        { module: "./customer/cart", functions: ["addItem"] },
        { module: "./customer/favourite", functions: ["toggleFavourites"] },
        { module: "../css/spinner.css", functions: null },
    ],

    "/employee.*": [
        { module: "../css/employee/employee.css", functions: null },
    ],

    "/employee/.+/[0-9]+/edit": [
        { module: "./employee/employee", functions: ["updateForm"] },
    ],
    "/employee/products/[0-9]+/edit": [
        { module: "./employee/product", functions: ["default"] },
    ],
    "/employee/products/create": [
        { module: "./employee/product", functions: ["default"] },
    ],
    "/employee/vouchers": [
        { module: "./employee/voucher.js", functions: ["default"] }
    ],
    "*": [
        { module: "../css/spinner.css", functions: null },
        { module: "../css/product/product.css", functions: null },
    ],
};

export default modulesConfig;
