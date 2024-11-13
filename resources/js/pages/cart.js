
import { incQuantity, decQuantity, deleteItem, applyVoucher, discardVoucher } from "../customer/cart"

export default function() {
    incQuantity();
    decQuantity();
    deleteItem();
    applyVoucher();
    discardVoucher();
}
