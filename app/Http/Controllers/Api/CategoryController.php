<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return apiResponse(1, 'all categories', $categories);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'string|unique:categories|min:3'
        ]);

        if($validator->fails()) {
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }

        $category = Category::create($request->all());
        return apiResponse(1, 'category has been saved successfully', $category);
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if(is_null($category)) {
            return apiResponse(0, 'there is no category with this id');
        }
        return apiResponse(1, 'category has been returned successfully', $category);
    }

    public function update(Request $request, string $id)
    {
        // dd(request()->all());

        $category = Category::find($id);

        if(is_null($category)) {
            return apiResponse(0, 'there is no category with this id');
        }

        $validator = validator($request->all(), [
            'name' => 'string|unique:categories|min:3',
        ]);

        if($validator->fails()) {
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }

        $category->update($request->all());

        return apiResponse(1, 'category has been updated successfully', $category);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(is_null($category)) {
            return apiResponse(0, 'there is no category with this id');
        }

        $category->delete();
        return apiResponse(1, 'category has been deleted successfully');
    }
}
