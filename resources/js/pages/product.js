
import { addItem } from "../customer/cart";
import { toggleFavourites } from "../customer/favourite";
import { updateReview, deleteReview } from "../customer/review";

export default function () {
    addItem();
    toggleFavourites();
    updateReview();
    deleteReview();
}
