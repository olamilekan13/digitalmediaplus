<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactChannelController extends Controller
{
    public function index()
    {
        return view('admin.contact-channels.index');
    }

    public function create()
    {
        return view('admin.contact-channels.create');
    }

    public function edit(string $id)
    {
        return view('admin.contact-channels.edit', ['channelId' => $id]);
    }
}
