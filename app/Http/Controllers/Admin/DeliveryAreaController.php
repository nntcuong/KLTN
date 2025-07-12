<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryAreaCreateRequest;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryAreaController extends Controller
{
    
    public function index(DeliveryAreaDataTable $dataTable)
    {
        return $dataTable->render('admin.delivery-area.index');
    }

    
    public function create(): View
    {
        return view('admin.delivery-area.create');
    }

   
    public function store(DeliveryAreaCreateRequest $request)
    {
        $area = new DeliveryArea();
        $area->area_name = $request->area_name;
        $area->min_delivery_time = $request->min_delivery_time;
        $area->max_delivery_time = $request->max_delivery_time;
        $area->delivery_fee = $request->delivery_fee;
        $area->status = $request->status;
        $area->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.delivery-area.index');
    }

   
    public function edit(string $id)
    {
        $area = DeliveryArea::findOrFail($id);
        return view('admin.delivery-area.edit', compact('area'));

    }

  
    public function update(DeliveryAreaCreateRequest $request, string $id)
    {
        $area = DeliveryArea::findOrFail($id);
        $area->area_name = $request->area_name;
        $area->min_delivery_time = $request->min_delivery_time;
        $area->max_delivery_time = $request->max_delivery_time;
        $area->delivery_fee = $request->delivery_fee;
        $area->status = $request->status;
        $area->save();

        toastr()->success('Updated Successfully!');

        return to_route('admin.delivery-area.index');
    }

   
    public function destroy(string $id)
    {
        try {
            DeliveryArea::findOrFail($id)->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
