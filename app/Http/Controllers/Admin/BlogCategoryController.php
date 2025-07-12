<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogCateogry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

use function Ramsey\Uuid\v1;

class BlogCategoryController extends Controller
{

    public function index(BlogCategoryDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    public function create() : View
    {
        return view('admin.blog.blog-category.create');
    }
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:blog_categories,name'],
            'status' => ['required', 'boolean']
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.blog-category.index');
    }


    
    public function edit(string $id) : View
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit', compact('category'));
    }

    public function update(Request $request, string $id) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:blog_categories,name,'.$id],
            'status' => ['required', 'boolean']
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Update Successfully!');

        return to_route('admin.blog-category.index');
    }

    public function destroy(string $id) : Response
    {
        try {
            $category = BlogCategory::findOrFail($id);
            $category->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
