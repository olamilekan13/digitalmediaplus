<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Solar Distributor Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f3f4f6;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
            color: white;
            padding: 30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: white;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f3f4f6;
        }
        .section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f97316;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 5px;
        }
        .field-value {
            color: #111827;
            font-size: 15px;
            padding: 10px 12px;
            background: #f9fafb;
            border-radius: 4px;
            border-left: 3px solid #f97316;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-yes {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-no {
            background: #fee2e2;
            color: #991b1b;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 12px;
            border-top: 2px solid #e5e7eb;
            margin-top: 20px;
            background: #f9fafb;
            border-radius: 0 0 8px 8px;
        }
        a {
            color: #f97316;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        @media only screen and (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 26px;">New Solar Distributor Application</h1>
        <p style="margin: 15px 0 0 0; opacity: 0.95; font-size: 15px;">A new distributor has applied to join your network</p>
    </div>

    <div class="content">
        <!-- SECTION A: PERSONAL INFORMATION -->
        <div class="section">
            <div class="section-title">Section A: Personal Information</div>

            <div class="grid">
                <div class="field">
                    <div class="field-label">Full Name</div>
                    <div class="field-value">{{ $application->full_name }}</div>
                </div>

                <div class="field">
                    <div class="field-label">Business Name</div>
                    <div class="field-value">{{ $application->business_name ?? 'Not provided' }}</div>
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <div class="field-label">Phone Number</div>
                    <div class="field-value">
                        <a href="tel:{{ $application->phone_number }}">{{ $application->phone_number }}</a>
                    </div>
                </div>

                <div class="field">
                    <div class="field-label">WhatsApp Number</div>
                    <div class="field-value">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $application->whatsapp_number) }}">{{ $application->whatsapp_number }}</a>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-value">
                    <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Residential Address</div>
                <div class="field-value">{{ $application->residential_address }}</div>
            </div>

            <div class="grid">
                <div class="field">
                    <div class="field-label">City / Town</div>
                    <div class="field-value">{{ $application->city }}</div>
                </div>

                <div class="field">
                    <div class="field-label">State</div>
                    <div class="field-value">{{ $application->state }}</div>
                </div>
            </div>
        </div>

        <!-- SECTION B: BUSINESS DETAILS -->
        <div class="section">
            <div class="section-title">Section B: Business Details</div>

            <div class="field">
                <div class="field-label">Currently Owns a Business</div>
                <div class="field-value">
                    @if($application->has_business)
                        <span class="badge badge-yes">Yes</span>
                    @else
                        <span class="badge badge-no">No</span>
                    @endif
                </div>
            </div>

            @if($application->has_business)
                <div class="grid">
                    <div class="field">
                        <div class="field-label">Business Type</div>
                        <div class="field-value">
                            {{ $application->business_type }}
                            @if($application->business_type === 'Other' && $application->business_type_other)
                                ({{ $application->business_type_other }})
                            @endif
                        </div>
                    </div>

                    <div class="field">
                        <div class="field-label">Years in Business</div>
                        <div class="field-value">{{ $application->years_in_business }}</div>
                    </div>
                </div>
            @endif

            <div class="field">
                <div class="field-label">Has Physical Shop</div>
                <div class="field-value">
                    @if($application->has_physical_shop)
                        <span class="badge badge-yes">Yes</span>
                    @else
                        <span class="badge badge-no">No</span>
                    @endif
                </div>
            </div>

            @if($application->has_physical_shop && $application->shop_address)
                <div class="field">
                    <div class="field-label">Shop Address</div>
                    <div class="field-value">{{ $application->shop_address }}</div>
                </div>
            @endif
        </div>

        <!-- SECTION C: DISTRIBUTION CAPACITY -->
        <div class="section">
            <div class="section-title">Section C: Distribution Capacity</div>

            <div class="field">
                <div class="field-label">Monthly Purchase Capacity</div>
                <div class="field-value">
                    <strong>{{ $application->monthly_purchase_capacity }}</strong>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Proposed Distribution Area</div>
                <div class="field-value">{{ $application->distribution_area }}</div>
            </div>

            <div class="field">
                <div class="field-label">Number of Sales Staff</div>
                <div class="field-value">{{ $application->sales_staff_count ?? 'Not specified' }}</div>
            </div>
        </div>

        <!-- SECTION D: ADDITIONAL INFORMATION -->
        @if($application->additional_info)
        <div class="section">
            <div class="section-title">Section D: Additional Information</div>

            <div class="field">
                <div class="field-value" style="white-space: pre-wrap;">{{ $application->additional_info }}</div>
            </div>
        </div>
        @endif

        <!-- SECTION E: DECLARATION -->
        <div class="section">
            <div class="section-title">Section E: Declaration</div>

            <div class="field">
                <div class="field-value" style="background: #fef3c7; border-left-color: #eab308;">
                    <p style="margin: 0 0 10px 0; font-style: italic;">
                        "I hereby confirm that all information provided in this application is true and correct.
                        I agree to operate as an authorized DMPlus Distributor under the company's terms and conditions."
                    </p>
                    <p style="margin: 0;"><strong>Signed by:</strong> {{ $application->applicant_name }}</p>
                    <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 13px;">
                        <strong>Date:</strong> {{ $application->application_date->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Application Metadata -->
        <div style="margin-top: 30px; padding: 20px; background: #eff6ff; border-radius: 6px; border: 1px solid #bfdbfe;">
            <p style="margin: 0 0 10px 0; color: #1e40af; font-weight: 600;">Application Details:</p>
            <p style="margin: 0; color: #3b82f6; font-size: 13px;">
                <strong>Application ID:</strong> #{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Submitted:</strong> {{ $application->created_at->format('F d, Y \a\t g:i A') }}<br>
                <strong>Status:</strong> {{ $application->is_reviewed ? 'Reviewed' : 'Pending Review' }}
            </p>
        </div>
    </div>

    <div class="footer">
        <p style="margin: 0 0 10px 0; font-weight: 600; color: #111827;">Action Required</p>
        <p style="margin: 0;">Please log in to your admin dashboard to review this application and respond to the applicant.</p>
        <p style="margin: 10px 0 0 0; font-size: 11px; color: #9ca3af;">
            This email was automatically generated from your website's distributor application form.
        </p>
    </div>
</body>
</html>
