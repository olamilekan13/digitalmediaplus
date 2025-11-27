<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name',
        'logo',
        'phone',
        'email',
        'address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'whatsapp_business_number',
        'whatsapp_chat_enabled',
        'whatsapp_welcome_message',
        'primary_color',
        'secondary_color',
        'copyright_text',
    ];
}
