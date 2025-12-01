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
        if (!auth()->user()->hasPermission('manage_contact_channels')) {
            abort(403, 'You do not have permission to create contact channels.');
        }
        return view('admin.contact-channels.create');
    }

    public function edit(string $id)
    {
        if (!auth()->user()->hasPermission('manage_contact_channels') && !auth()->user()->hasPermission('edit_contact_channels')) {
            abort(403, 'You do not have permission to edit contact channels.');
        }
        return view('admin.contact-channels.edit', ['channelId' => $id]);
    }
}
