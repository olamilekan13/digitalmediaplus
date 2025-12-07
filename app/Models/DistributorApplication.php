<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DistributorApplication extends Model
{
    use LogsActivity;

    protected $fillable = [
        'full_name',
        'business_name',
        'phone_number',
        'whatsapp_number',
        'email',
        'residential_address',
        'city',
        'state',
        'has_business',
        'business_type',
        'business_type_other',
        'years_in_business',
        'has_physical_shop',
        'shop_address',
        'monthly_purchase_capacity',
        'distribution_area',
        'sales_staff_count',
        'additional_info',
        'applicant_name',
        'application_date',
        'is_reviewed',
        'admin_notes',
    ];

    protected $casts = [
        'has_business' => 'boolean',
        'has_physical_shop' => 'boolean',
        'is_reviewed' => 'boolean',
        'application_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['full_name', 'email', 'is_reviewed'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Distributor application has been {$eventName}");
    }

    public function scopeUnreviewed($query)
    {
        return $query->where('is_reviewed', false);
    }

    public function scopeReviewed($query)
    {
        return $query->where('is_reviewed', true);
    }
}
