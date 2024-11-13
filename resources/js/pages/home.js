import { addItem } from "../customer/cart"
import { toggleFavourites } from "../customer/favourite";
import sortBy from "../customer/products-sort-by";
import filter from "../customer/filter";


export default function () {
    addItem();
    toggleFavourites();
    sortBy();
    filter();
}
