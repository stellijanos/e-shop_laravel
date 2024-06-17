
<form class="row mb-3">
    <div class="col-3">
        <div class=" input-group">
            <label class="input-group-text" for="sort-by">Sort by: </label>
            <select name="sort_by" id="sort-by" class="form-select" onchange="this.form.submit()">
                <option value="_">Default</option>
                <option value="price-asc" {{$sort_by=== "price-asc" ? 'selected' : ''}}>Price (Ascending)</option>
                <option value="price-desc" {{$sort_by === "price-desc" ? 'selected' : ''}}>Price (Descending)</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class=" input-group" style="width:200px;">
            <label class="input-group-text" for="show-per-page">Show per page: </label>
            <select class="form-select" name="per_page" id="show-per-page" onchange="this.form.submit()">
                @foreach ($per_page_values as $page_value)
                    <option value="{{$page_value}}" {{$per_page === $page_value ? 'selected' : ''}}>{{$page_value}}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="d-flex flex-row justify-content-start flex-wrap gap-5 mb-5" id="product-list">
    @foreach ($products as $product)
        <div class="product-item bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" style="width:150px">
            <a href="{{ route('product', ['product' => $product->id]) }}"></a>    
                <img class="rounded" src="{{asset('public/images/products/'.$product->image)}}" style="width:120px; height:120px" alt="{{$product->name}}-image">
                <figcaption>
                    <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">{{$product->name}}</p>
                    <p class="text-truncate fw-bold m-0" style="max-width: 150px;">({{$product->category->name}})</p>
                    <p class="text-truncate m-1" style="max-width: 150px;">{{$product->description}}</p>
                    <p class="fs-5 text-start fw-bold m-2">${{$product->price}}</p>
                    <div class="row justify-content-around mb-1">
                        <a class="col-4 text-center" data-product-id="{{$product->id}}" onclick="favourite(this)"><i class="fa-solid fa-heart fa-2x" style="color:red;"></i></a>
                        <a class="col-4 text-center" data-product-id="{{$product->id}}"onclick="addToCart(this)"><i class="fa-solid fa-cart-plus fa-2x"></i></a>
                        </div>
                </figcaption>
            </a>
        </div>
    @endforeach
</div>
<div class="text-center">
        {{$products->links()}}
</div>    