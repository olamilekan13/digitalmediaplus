<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distributor_applications', function (Blueprint $table) {
            $table->id();

            // Section A: Personal Information
            $table->string('full_name');
            $table->string('business_name')->nullable();
            $table->string('phone_number');
            $table->string('whatsapp_number');
            $table->string('email');
            $table->text('residential_address');
            $table->string('city');
            $table->string('state');

            // Section B: Business Details
            $table->boolean('has_business');
            $table->string('business_type')->nullable();
            $table->string('business_type_other')->nullable();
            $table->string('years_in_business')->nullable();
            $table->boolean('has_physical_shop');
            $table->text('shop_address')->nullable();

            // Section C: Distribution Capacity
            $table->string('monthly_purchase_capacity');
            $table->text('distribution_area');
            $table->string('sales_staff_count')->nullable();

            // Section D: Additional Information
            $table->text('additional_info')->nullable();

            // Section E: Declaration
            $table->string('applicant_name');
            $table->date('application_date');

            // Admin fields
            $table->boolean('is_reviewed')->default(false);
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_applications');
    }
};
