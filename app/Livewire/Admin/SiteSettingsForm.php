<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SiteSettingsForm extends Component
{
    use WithFileUploads;

    public $settings;
    public $company_name;
    public $logo;
    public $phone;
    public $email;
    public $address;
    public $facebook_url;
    public $twitter_url;
    public $instagram_url;
    public $linkedin_url;
    public $youtube_url;
    public $teams_url;
    public $telegram_url;
    public $whatsapp_business_number;
    public $whatsapp_chat_enabled;
    public $whatsapp_welcome_message;
    public $primary_color;
    public $secondary_color;
    public $copyright_text;
    public $newLogo;
    public $currentLogo;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'newLogo' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        'phone' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:500',
        'facebook_url' => 'nullable|url|max:255',
        'twitter_url' => 'nullable|url|max:255',
        'instagram_url' => 'nullable|url|max:255',
        'linkedin_url' => 'nullable|url|max:255',
        'youtube_url' => 'nullable|url|max:255',
        'teams_url' => 'nullable|string|max:255',
        'telegram_url' => 'nullable|url|max:255',
        'whatsapp_business_number' => 'nullable|string|max:20',
        'whatsapp_chat_enabled' => 'nullable|boolean',
        'whatsapp_welcome_message' => 'nullable|string|max:500',
        'primary_color' => 'nullable|string|max:7',
        'secondary_color' => 'nullable|string|max:7',
        'copyright_text' => 'nullable|string',
    ];

    protected $messages = [
        'company_name.required' => 'The company name field is required.',
        'newLogo.image' => 'The logo must be an image.',
        'newLogo.max' => 'The logo must not be greater than 2MB.',
        'newLogo.mimes' => 'The logo must be a file of type: jpg, jpeg, png.',
        'email.email' => 'Please enter a valid email address.',
        'facebook_url.url' => 'Please enter a valid URL for Facebook.',
        'twitter_url.url' => 'Please enter a valid URL for Twitter.',
        'instagram_url.url' => 'Please enter a valid URL for Instagram.',
        'linkedin_url.url' => 'Please enter a valid URL for LinkedIn.',
        'youtube_url.url' => 'Please enter a valid URL for YouTube.',
        'teams_url.max' => 'Teams username/userid must not exceed 255 characters.',
        'telegram_url.url' => 'Please enter a valid URL for Telegram.',
    ];

    public function mount()
    {
        $this->settings = SiteSetting::first();

        if (!$this->settings) {
            $this->settings = SiteSetting::create([
                'company_name' => config('app.name'),
                'primary_color' => '#007bff',
                'secondary_color' => '#6c757d',
            ]);
        }

        $this->company_name = $this->settings->company_name;
        $this->phone = $this->settings->phone;
        $this->email = $this->settings->email;
        $this->address = $this->settings->address;
        $this->facebook_url = $this->settings->facebook_url;
        $this->twitter_url = $this->settings->twitter_url;
        $this->instagram_url = $this->settings->instagram_url;
        $this->linkedin_url = $this->settings->linkedin_url;
        $this->youtube_url = $this->settings->youtube_url;
        $this->teams_url = $this->settings->teams_url;
        $this->telegram_url = $this->settings->telegram_url;
        $this->whatsapp_business_number = $this->settings->whatsapp_business_number;
        $this->whatsapp_chat_enabled = (bool) $this->settings->whatsapp_chat_enabled;
        $this->whatsapp_welcome_message = $this->settings->whatsapp_welcome_message;
        $this->primary_color = $this->settings->primary_color;
        $this->secondary_color = $this->settings->secondary_color;
        $this->copyright_text = $this->settings->copyright_text;
        $this->currentLogo = $this->settings->logo;
    }

    public function updatedNewLogo()
    {
        $this->validate([
            'newLogo' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);
    }

    public function removeLogo()
    {
        if ($this->currentLogo && Storage::disk('public')->exists($this->currentLogo)) {
            Storage::disk('public')->delete($this->currentLogo);
        }

        $this->settings->update(['logo' => null]);
        $this->currentLogo = null;
        $this->newLogo = null;

        $this->dispatch('notify', message: 'Logo removed successfully.', type: 'success');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'teams_url' => $this->teams_url,
            'telegram_url' => $this->telegram_url,
            'whatsapp_business_number' => $this->whatsapp_business_number,
            'whatsapp_chat_enabled' => $this->whatsapp_chat_enabled ? true : false,
            'whatsapp_welcome_message' => $this->whatsapp_welcome_message,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'copyright_text' => $this->copyright_text,
        ];

        if ($this->newLogo) {
            // Delete old logo if exists
            if ($this->currentLogo && Storage::disk('public')->exists($this->currentLogo)) {
                Storage::disk('public')->delete($this->currentLogo);
            }

            // Store new logo
            $data['logo'] = $this->newLogo->store('logos', 'public');
            $this->currentLogo = $data['logo'];
            $this->newLogo = null;
        }

        $this->settings->update($data);

        $this->dispatch('notify', message: 'Site settings updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.site-settings-form');
    }
}
