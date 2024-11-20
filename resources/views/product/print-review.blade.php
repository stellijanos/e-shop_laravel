<hr>
<div id="review-{{$review->product_id}}-{{$review->user_id}}">

    <p class="mb-0"><b>{{$review->customer->firstname}} {{$review->customer->lastname}}</b> on
        {{(new DateTime($review->created_at))->format('Y.m.d')}}
    </p>
    <div class="d-flex flew-row justify-content-between">
        <div>
            <div class="user-rating">
                @for ($i = 1; $i <= $review->rating; $i++)
                    <span class="checked">&#9733;</span>
                @endfor
                @for ($j = $i; $j <= 5; $j++)
                    <span>&#9733;</span>
                @endfor
            </div>
            <div id="review-{{$review->product_id}}-{{$review->user_id}}-description">
                @if ($review->description)
                    <p>"{{$review->description}}"</p>
                @endif
            </div>
        </div>
        @if($wasReviewed)
            @include('product.review-user-options')
        @endif
    </div>
</div>