<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReservationTimeDataTable;
use App\Http\Controllers\Controller;
use App\Models\ReservationTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationTimeController extends Controller
{
   
    public function index(ReservationTimeDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.reservation.reservation-time.index');
    }

  
    public function create() : View
    {
        return view('admin.reservation.reservation-time.create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $time = new ReservationTime();
        $time->start_time = $request->start_time;
        $time->end_time = $request->end_time;
        $time->save();
        toastr()->success('Created Successfully!');

        return redirect()->route('admin.reservation-time.index');
    }

    
    public function edit(string $id) : View
    {
        $time = ReservationTime::findOrFail($id);
        return view('admin.reservation.reservation-time.edit', compact('time'));
    }

    public function update(Request $request, string $id) : RedirectResponse
    {
        $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $time = ReservationTime::findOrFail($id);
        $time->start_time = $request->start_time;
        $time->end_time = $request->end_time;
        $time->save();
        toastr()->success('Created Successfully!');

        return redirect()->route('admin.reservation-time.index');
    }

   
    public function destroy(string $id)
    {
        try {
            $time = ReservationTime::findOrFail($id);
            $time->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
