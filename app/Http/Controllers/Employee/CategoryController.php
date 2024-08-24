<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('employee.category.index', [
            'categories' => Category::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('employee.category.create');
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
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        $request->session()->flash('status', "Category \"$request->name\" successfully created!");
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        $category || abort(404);

        return view('employee.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        if (!$category) {
            return (new Response('fail', 'Category not found!', 404))->get();
        }

        if ($category->name == $request->name) {
            return (new Response('success', 'Nothing to update!'))->get();
        }


        $rules = [
            'name' => 'required|string|max:255|unique:categories'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return (new Response('fail', json_encode($validator->errors()->toArray(), true), 422))->get();
        }

        // if (!Auth::user()->correctPassword($request->password)) {
        //      return (new Response('fail', 'Incorrect password!', 401))->get();
        // }

        $category->update([
            'name' => $request->name,
        ]);

        return (new Response('success', 'Category successfully updated!'))->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category || abort(404);
        $category->delete();

        Session()->flash('status', "Category \"$category->name\" successfully updated!");
        return redirect()->route('categories.index');
    }
}
