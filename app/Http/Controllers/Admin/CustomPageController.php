<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;

class CustomPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.custom-pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            abort(403, 'You do not have permission to create custom pages.');
        }
        return view('admin.custom-pages.builder');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            abort(403, 'You do not have permission to edit custom pages.');
        }
        return view('admin.custom-pages.builder', ['pageId' => $id]);
    }

    /**
     * Handle image upload for CKEditor
     */
    public function uploadImage(Request $request)
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            return response()->json(['error' => ['message' => 'Unauthorized']], 403);
        }

        try {
            $request->validate([
                'upload' => 'required|image|max:5120'
            ]);

            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('custom-pages', $filename, 'public');

            // Return full URL
            $fullUrl = url('storage/' . $path);

            return response()->json([
                'uploaded' => true,
                'url' => $fullUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 400);
        }
    }
}
