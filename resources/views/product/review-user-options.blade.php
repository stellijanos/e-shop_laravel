<div>
    <form class="input-group rounded w-100 d-flex justify-content-center" id="delete-review-form" action="{{route('products.reviews.delete', [
    'user' => $review->user_id,
    'product' => $review->product_id
])}}" method="post">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-warning input-group-text rounded-start text-center" data-bs-toggle="modal"
            data-bs-target="#review-modal">
            <i class="bi bi-pencil-square"></i>
        </button>
        <button type="submit" class="btn btn-danger input-group-text" id="delete-review-btn" data-review="review-{{$review->product_id}}-{{$review->user_id}}"><i
                class="bi bi-trash3-fill"></i></button>
    </form>
</div>
@include('product.review-modal', [
    'form_action' => route('products.reviews.update', [
        'product' => $product->id,
        'user' => Auth::user()->id
    ]),
    'rating' => $review->rating,
    'description' => $review->description,
    'update' => true
])