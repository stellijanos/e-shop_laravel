<!-- Modal -->
<style>
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
        width: 200px;
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

<div class="modal fade" id="review-modal" tabindex="-1" aria-labelledby="review-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form class="modal-content" method="post" id="form-review-modal" action="{{$form_action ?? ''}}">
            @csrf
            @if($update ?? false)
                @method('PUT')
            @endif
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="review-modal-label">Add a review for "{{$product->name}}"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex flew-row align-items-center">
                    <span class="mb-0">Rating <span>(required)</span></span>
                    <div class="rate">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{$i === (int) ($rating ?? 0) ? 'checked' : ''}} />
                            <label for="star{{$i}}" title="{{$i}}">{{$i}} stars</label>
                        @endfor
                    </div>
                </div>
                <textarea name="description" class="form-control mb-3" style="height:200px" id="description"
                    placeholder="Description (optional)">{{$description ?? ''}}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"
                    id="btn-review-modal">{{$update ?? false ? 'Update' : 'Create'}}</button>
            </div>
        </form>
    </div>
</div>