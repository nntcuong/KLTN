<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductGalleryController extends Controller
{
    use FileUploadTrait;
  
    public function index(string $productId) : View
    {
        $images = ProductGallery::where('product_id', $productId)->get();
        $product = Product::findOrFail($productId);
        return view('admin.product.gallery.index', compact('product', 'images'));
    }

   
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'product_id' => ['required', 'integer']
        ]);

        $imagePath = $this->uploadImage($request, 'image');

        $gallery = new ProductGallery();
        $gallery->product_id = $request->product_id;
        $gallery->image = $imagePath;
        $gallery->save();

        toastr()->success('Created Successfully!');

        return redirect()->back();

    }

    public function destroy(string $id) : Response
    {
        try{
            $image = ProductGallery::findOrFail($id);
            $this->removeImage($image->image);
            $image->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
