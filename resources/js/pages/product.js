
import { addItem } from "../customer/cart";
import { toggleFavourites } from "../customer/favourite";
import reviewModalEventListener from "../customer/review";

export default function () {
    addItem();
    toggleFavourites();
    reviewModalEventListener();
}
