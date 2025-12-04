<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;

class CustomPageController extends Controller
{
    public function show($slug)
    {
        $page = CustomPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('custom-page', compact('page'));
    }
}
