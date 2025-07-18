<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use FileUploadTrait;
   
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }


    public function create(): View
    {
        return view('admin.slider.create');
    }

  
    public function store(SliderCreateRequest $request)
    {
        /** Handle image upload */
        $imagePath = $this->uploadImage($request, 'image');

        $slider = new Slider();
        $slider->image = $imagePath;
        $slider->offer = $request->offer;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();

        toastr()->success('Created Successfully');

        return to_route('admin.slider.index');
    }

    public function show(string $id)
    {
        //
    }

  
    public function edit(string $id): View
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

   
    public function update(SliderUpdateRequest $request, string $id): RedirectResponse
    {
        $slider = Slider::findOrFail($id);

        /** Handle Image Upload */
        $imagePath = $this->uploadImage($request, 'image', $slider->image);

        $slider->image = !empty($imagePath) ? $imagePath : $slider->image;
        $slider->offer = $request->offer;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();

        toastr()->success('Updated Successfully');

        return to_route('admin.slider.index');
    }

  
    public function destroy(string $id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $this->removeImage($slider->image);
            $slider->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
