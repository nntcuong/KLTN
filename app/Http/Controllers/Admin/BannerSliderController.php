<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerSliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerSliderCreateRequest;
use App\Models\BannerSlider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function Ramsey\Uuid\v1;

class BannerSliderController extends Controller
{
    use FileUploadTrait;

    
    public function index(BannerSliderDataTable $dataTable)
    {
        return $dataTable->render('admin.banner-slider.index');
    }

    public function create() : View
    {
        return view('admin.banner-slider.create');
    }

 
    public function store(BannerSliderCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');

        $bannerSlider = new BannerSlider();
        $bannerSlider->banner = $imagePath;
        $bannerSlider->title = $request->title;
        $bannerSlider->sub_title = $request->sub_title;
        $bannerSlider->url = $request->url;

        $bannerSlider->status = $request->status;
        $bannerSlider->save();

        toastr()->success("Created Successfully!");

        return to_route('admin.banner-slider.index');
    }

    public function edit(string $id) : View
    {
        $bannerSlider = BannerSlider::findOrFail($id);
        return view('admin.banner-slider.edit', compact('bannerSlider'));
    }

    
    public function update(Request $request, string $id)
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $bannerSlider = BannerSlider::findOrFail($id);
        $bannerSlider->banner = !empty($imagePath) ? $imagePath : $request->old_image;
        $bannerSlider->title = $request->title;
        $bannerSlider->sub_title = $request->sub_title;
        $bannerSlider->url = $request->url;

        $bannerSlider->status = $request->status;
        $bannerSlider->save();

        toastr()->success("Update Successfully!");

        return to_route('admin.banner-slider.index');
    }

    public function destroy(string $id)
    {
        try {
            $slider = BannerSlider::findOrFail($id);
            $this->removeImage($slider->banner);
            $slider->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
