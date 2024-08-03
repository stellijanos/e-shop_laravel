<!-- Modal -->
<div class="modal fade" id="add-review-modal" tabindex="-1" aria-labelledby="add-review-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form class="modal-content" method="post" action="{{route('products.reviews.create', ['product' => $product->id])}}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-review-modal-label">Add a review for "{{$product->name}}"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="rating">Choose rating (between 1-5)*</label>
                <select class="form-select mb-3" id="rating" name="rating" required> 
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <textarea name="description" class="form-control mb-3" style="height:200px"
                    id="description" placeholder="Description (optional)"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>