<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::paginate(5);
        return view('employee.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all();

        return view('employee.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'specs' => 'required|array|min:1'
        ]);


        $category = Category::find($request->category);

        if (!$category) {
            return redirect()->back()->withErrors(['category' => 'Category does not exist.']);
        }

        $imageName = 'no-image.png';

        if ($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $imageName = date('Ymdhis') . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }


        print_r($request->specs);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imageName,
            'category_id' => $request->category
        ]);

        foreach ($request->specs as $spec) {

            $spec = explode(';', $spec);

            if (count($spec) !== 2)
                continue;

            ProductSpec::create([
                'product_id' => $product->id,
                'name' => $spec[0],
                'value' => $spec[1],
            ]);
        }


        $request->session()->flash('status', 'Product successfully added!');
        return redirect()->route('products.store');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {

        $product || abort(404);

        return view('employee.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $product || abort(404);

        $categories = Category::all();

        return view('employee.products.edit', compact('product', 'categories'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {

        // dd($request->image);    

        if (!$product) {
            return response()->json(['status' => 'fail', 'message' => 'Product not found!']);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'specs' => 'required|array|min:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'fail',
                'message' => json_encode($validator->errors()->toArray()),
            ], 422);
        }

        $imageName = $product->image;
        if ($request->remove_image) {

            $imageName = $product->setDefaultImage();

        } else if ($request->image) {
            $rule = [
                'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048'
            ];

            $validator = Validator::make($request->only('image'), $rule);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => json_encode($validator->errors()->toArray()),
                ], 422);
            }

            $imageName = $product->changeImage($request->image);

        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imageName,
            'category_id' => $request->category,
        ]);

        $product->addSpecs($request->specs);




        return response()->json([
            'status' => 'success',
            'message' => 'Products successfully updated!',
            'data' => [
                'image' => $imageName
            ]
        ], 200);

        // //////////////////////////////////################### 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product || abort(404);

        $product->remove();

        Session()->flash('status', 'Product #' . $product->id . ' successfully deleted!');
        return redirect()->route('products.index');
    }
}
