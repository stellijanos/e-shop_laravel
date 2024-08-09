<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($request->category)

            $request->validate([
                'name' => 'required|string|max:255|unique:categories'
            ]);

        Category::create([
            'name' => $request->name
        ]);

        $request->session()->flash('status', 'Category "' . $request->name . '" successfully created!');
        return redirect('/employee/category');
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
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }

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
            return response()->json(['status' => 'fail', 'message' => 'Category not found!']);
        }

        if ($category->name == $request->name) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nothing to update!'
            ], 200);
        }


        $rules = [
            'name' => 'required|string|max:255|unique:categories'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => json_encode($validator->errors()->toArray(), true),
            ], 422);
        }

        // if (!Auth::user()->correctPassword($request->password)) {
        //     return response()->json([
        //         'status' => 'fail',
        //         'message' => 'Incorrect password!'
        //     ], 401);
        // }


        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully updated!'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }
        $category->delete();

        Session()->flash('status', 'Category "' . $category->name . '" successfully updated!');
        return redirect('/employee/category');
    }
}
