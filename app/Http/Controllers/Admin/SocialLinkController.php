<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SocialLinkDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialLinkStoreRequest;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
 
    public function index(SocialLinkDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.social-link.index');
    }

  
    public function create() : View
    {
        return view('admin.social-link.create');
    }

    public function store(SocialLinkStoreRequest $request) : RedirectResponse
    {
        $link = new SocialLink();
        $link->icon = $request->icon;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->status = $request->status;
        $link->save();

        toastr()->success('Created Successfully');

        return redirect()->route('admin.social-link.index');

    }

   
    public function edit(string $id)
    {
        $link = SocialLink::findOrFail($id);
        return view('admin.social-link.edit', compact('link'));
    }

   
    public function update(SocialLinkStoreRequest $request, string $id)
    {
        $link = SocialLink::findOrFail($id);
        $link->icon = $request->icon;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->status = $request->status;
        $link->save();

        toastr()->success('Update Successfully');

        return redirect()->route('admin.social-link.index');
    }

    public function destroy(string $id)
    {
        try {
            $link = SocialLink::findOrFail($id);
            $link->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
