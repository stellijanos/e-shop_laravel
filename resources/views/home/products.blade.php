<style>
    div.product-item:hover, div.product-item:active {
        transform:scale(1.03);
        cursor:pointer;
    }
</style>
<form class="row mb-3" action="{{route('home')}}" method="get">
    <div class="col-2">
        <select name="sort_by" id="" class="form-select" onchange="this.form.submit()">
            <option value="_">Sort By (Default)</option>
            <option value="price-asc" {{$sort_by=== "price-asc" ? 'selected' : ''}}>Price (Ascending)</option>
            <option value="price-desc" {{$sort_by === "price-desc" ? 'selected' : ''}}>Price (Descending)</option>
        </select>
    </div>
    <div class="col-4">
        <div class=" input-group">
            <label class="input-group-text" for="show-per-page">Show per page: </label>
            <select class="form-select" style="width:50px!important" name="per_page" id="show-per-page" onchange="this.form.submit()">
                <option value="2" {{$per_page === '2' ? 'selected' : ''}}>24 (Default)</option>
                @foreach ($per_page_values as $page_value)
                    <option value="{{$page_value}}" {{$per_page === $page_value ? 'selected' : ''}}>{{$page_value}}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="row justify-content-flex-start gap-5">
    @foreach ($products as $product)
        <div class="product-item bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" style="width:150px">
            <img class="rounded" src="{{asset('public/images/products/'.$product->image)}}" style="width:120px; height:120px" alt="{{$product->name}}-image">
            <figcaption>
                <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">{{$product->name}}</p>
                <p class="text-truncate fw-bold m-0" style="max-width: 150px;">({{$product->category->name}})</p>
                <p class="text-truncate m-1" style="max-width: 150px;">{{$product->description}}</p>
                <p class="fs-5 text-start fw-bold m-2">${{$product->price}}</p>
                <div class="row justify-content-around mb-1">
                @php
                    $favouriteIcon = in_array($product->id, $favourites) ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>' : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
                @endphp
                    <a class="col-4 text-center" data-product-id="{{$product->id}}" onclick="favourite(this)"><?=$favouriteIcon?></a>
                    <a class="col-4 text-center" data-product-id="{{$product->id}}"onclick="addToCart(this)"><i class="fa-solid fa-cart-plus fa-2x"></i></a>
                </div>
            </figcaption>
        </div>
    @endforeach
    <div class="text-center">
        {{$products->links()}}
    </div>
</div>
