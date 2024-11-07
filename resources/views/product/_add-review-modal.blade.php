<!-- Modal -->
<style>
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
        width:200px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #c59b08;
    }


</style>

<div class="modal fade" id="add-review-modal" tabindex="-1" aria-labelledby="add-review-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form class="modal-content" method="post"
            action="{{route('products.reviews.create', ['product' => $product->id])}}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-review-modal-label">Add a review for "{{$product->name}}"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex flew-row align-items-center">
                    <span class="mb-0">Rating <span>(required)</span></span>
                    <div class="rate">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5" title="5">5 stars</label>

                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4">4 stars</label>

                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3">3 stars</label>

                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2">2 stars</label>

                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1">1 star</label>
                    </div>
                </div>
                <textarea name="description" class="form-control mb-3" style="height:200px" id="description"
                    placeholder="Description (optional)"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>