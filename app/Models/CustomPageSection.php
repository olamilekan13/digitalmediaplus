<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPageSection extends Model
{
    protected $fillable = [
        'custom_page_id',
        'type',
        'content',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function customPage()
    {
        return $this->belongsTo(CustomPage::class);
    }
}
