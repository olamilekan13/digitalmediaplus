<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full access to all features and settings. Can manage other admins.',
                'permissions' => [
                    'manage_site_settings',
                    'manage_hero_sections',
                    'manage_services',
                    'manage_about_sections',
                    'manage_feature_highlights',
                    'manage_statistics',
                    'manage_testimonials',
                    'manage_faqs',
                    'manage_contact_channels',
                    'manage_contact_messages',
                    'manage_pages',
                    'manage_admins',
                    'view_activity_logs',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Content Manager',
                'slug' => 'content-manager',
                'description' => 'Can create, edit, and delete all content. Cannot modify site settings or manage admins.',
                'permissions' => [
                    'manage_hero_sections',
                    'manage_services',
                    'manage_about_sections',
                    'manage_feature_highlights',
                    'manage_statistics',
                    'manage_testimonials',
                    'manage_faqs',
                    'manage_pages',
                    'view_contact_messages',
                    'view_activity_logs',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Support',
                'slug' => 'support',
                'description' => 'Can view and respond to contact messages. Read-only access to content.',
                'permissions' => [
                    'view_hero_sections',
                    'view_services',
                    'view_about_sections',
                    'view_feature_highlights',
                    'view_statistics',
                    'view_testimonials',
                    'view_faqs',
                    'manage_contact_messages',
                    'view_activity_logs',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Can edit existing content but cannot create or delete. Cannot access settings or contact messages.',
                'permissions' => [
                    'edit_hero_sections',
                    'edit_services',
                    'edit_about_sections',
                    'edit_feature_highlights',
                    'edit_statistics',
                    'edit_testimonials',
                    'edit_faqs',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Viewer',
                'slug' => 'viewer',
                'description' => 'Read-only access to dashboard, content, and contact messages.',
                'permissions' => [
                    'view_hero_sections',
                    'view_services',
                    'view_about_sections',
                    'view_feature_highlights',
                    'view_statistics',
                    'view_testimonials',
                    'view_faqs',
                    'view_contact_messages',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
