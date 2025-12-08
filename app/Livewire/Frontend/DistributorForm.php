<?php

namespace App\Livewire\Frontend;

use App\Models\DistributorApplication;
use App\Models\SiteSetting;
use App\Models\User;
use App\Mail\DistributorApplicationMail;
use App\Notifications\NewDistributorApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class DistributorForm extends Component
{
    // Section A: Personal Information
    public $full_name = '';
    public $business_name = '';
    public $phone_number = '';
    public $whatsapp_number = '';
    public $email = '';
    public $residential_address = '';
    public $city = '';
    public $state = '';

    // Section B: Business Details
    public $has_business = null;
    public $business_type = '';
    public $business_type_other = '';
    public $years_in_business = '';
    public $has_physical_shop = null;
    public $shop_address = '';

    // Section C: Distribution Capacity
    public $monthly_purchase_capacity = '';
    public $distribution_area = '';
    public $sales_staff_count = '';

    // Section D: Additional Information
    public $additional_info = '';

    // Section E: Declaration
    public $applicant_name = '';
    public $agree_declaration = false;

    protected $rules = [
        // Section A
        'full_name' => 'required|string|max:255|min:2',
        'business_name' => 'nullable|string|max:255',
        'phone_number' => 'required|string|max:20',
        'whatsapp_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'residential_address' => 'required|string|max:500',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',

        // Section B
        'has_business' => 'required|boolean',
        'business_type' => 'required_if:has_business,true',
        'business_type_other' => 'required_if:business_type,Other',
        'years_in_business' => 'required_if:has_business,true',
        'has_physical_shop' => 'required|boolean',
        'shop_address' => 'required_if:has_physical_shop,true|nullable|string|max:500',

        // Section C
        'monthly_purchase_capacity' => 'required|string',
        'distribution_area' => 'required|string|max:500',
        'sales_staff_count' => 'nullable|string|max:50',

        // Section D
        'additional_info' => 'nullable|string|max:1000',

        // Section E
        'applicant_name' => 'required|string|max:255',
        'agree_declaration' => 'accepted',
    ];

    protected $messages = [
        'full_name.required' => 'Please enter your full name.',
        'phone_number.required' => 'Please enter your phone number.',
        'whatsapp_number.required' => 'Please enter your WhatsApp number.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'residential_address.required' => 'Please enter your residential address.',
        'city.required' => 'Please enter your city/town.',
        'state.required' => 'Please enter your state.',
        'has_business.required' => 'Please select whether you own a business.',
        'business_type.required_if' => 'Please select your business type.',
        'business_type_other.required_if' => 'Please specify your business type.',
        'years_in_business.required_if' => 'Please select how long you have been in business.',
        'has_physical_shop.required' => 'Please select whether you have a physical shop.',
        'shop_address.required_if' => 'Please enter your shop address.',
        'monthly_purchase_capacity.required' => 'Please select your monthly purchase capacity.',
        'distribution_area.required' => 'Please enter your proposed distribution area.',
        'applicant_name.required' => 'Please enter your name for the declaration.',
        'agree_declaration.accepted' => 'You must agree to the declaration to submit the form.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $validatedData = $this->validate();

        // Remove agree_declaration from data (not in database)
        unset($validatedData['agree_declaration']);

        // Add application date
        $validatedData['application_date'] = now();

        // Convert boolean values
        $validatedData['has_business'] = $this->has_business === true || $this->has_business === '1' || $this->has_business === 1;
        $validatedData['has_physical_shop'] = $this->has_physical_shop === true || $this->has_physical_shop === '1' || $this->has_physical_shop === 1;

        // Save to database
        $application = DistributorApplication::create($validatedData);

        // Get site settings contact form email (with fallback to company email)
        $siteSetting = SiteSetting::first();
        $recipientEmail = $siteSetting && $siteSetting->contact_form_email
            ? $siteSetting->contact_form_email
            : ($siteSetting && $siteSetting->email ? $siteSetting->email : null);

        // Send email to the site settings email address
        if ($recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(new DistributorApplicationMail($application));
            } catch (\Exception $e) {
                // Log error but don't fail the form submission
                \Log::error('Failed to send distributor application email: ' . $e->getMessage());
            }
        }

        // Also send email notification to all admin users
        $admins = User::where('is_admin', true)->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new NewDistributorApplication($application));
        }

        // Reset form
        $this->reset([
            'full_name', 'business_name', 'phone_number', 'whatsapp_number', 'email',
            'residential_address', 'city', 'state', 'has_business', 'business_type',
            'business_type_other', 'years_in_business', 'has_physical_shop', 'shop_address',
            'monthly_purchase_capacity', 'distribution_area', 'sales_staff_count',
            'additional_info', 'applicant_name', 'agree_declaration'
        ]);

        // Dispatch browser event for notification and scroll to top
        $this->dispatch('distributor-form-submitted');
    }

    public function render()
    {
        return view('livewire.frontend.distributor-form');
    }
}
