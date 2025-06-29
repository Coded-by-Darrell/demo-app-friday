// database/seeders/SettingsSeeder.php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'Innovations Solutions & Marketing',
                'type' => 'string',
                'description' => 'Website name',
                'autoload' => true,
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'value' => 'Professional web development, mobile apps, and digital marketing services',
                'type' => 'string',
                'description' => 'Website description',
                'autoload' => true,
            ],
            [
                'group' => 'general',
                'key' => 'contact_email',
                'value' => 'hello@innovations-marketing.com',
                'type' => 'string',
                'description' => 'Main contact email',
                'autoload' => true,
            ],
            [
                'group' => 'general',
                'key' => 'contact_phone',
                'value' => '+63 912 345 6789',
                'type' => 'string',
                'description' => 'Main contact phone',
                'autoload' => true,
            ],
            
            // Social Media Settings
            [
                'group' => 'social',
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/innovations-marketing',
                'type' => 'string',
                'description' => 'Facebook page URL',
                'autoload' => false,
            ],
            [
                'group' => 'social',
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/innovations_mktg',
                'type' => 'string',
                'description' => 'Twitter profile URL',
                'autoload' => false,
            ],
            [
                'group' => 'social',
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/innovations-marketing',
                'type' => 'string',
                'description' => 'LinkedIn company page URL',
                'autoload' => false,
            ],
            
            // Business Settings
            [
                'group' => 'business',
                'key' => 'business_hours',
                'value' => json_encode([
                    'monday' => '8:00 AM - 6:00 PM',
                    'tuesday' => '8:00 AM - 6:00 PM',
                    'wednesday' => '8:00 AM - 6:00 PM',
                    'thursday' => '8:00 AM - 6:00 PM',
                    'friday' => '8:00 AM - 6:00 PM',
                    'saturday' => '9:00 AM - 2:00 PM',
                    'sunday' => 'Closed'
                ]),
                'type' => 'json',
                'description' => 'Business operating hours',
                'autoload' => true,
            ],
            [
                'group' => 'business',
                'key' => 'address',
                'value' => '123 Innovation Street, Tech District, Batangas 4200, Philippines',
                'type' => 'string',
                'description' => 'Business address',
                'autoload' => true,
            ],
            
            // Feature Flags
            [
                'group' => 'features',
                'key' => 'enable_contact_form',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable contact form submissions',
                'autoload' => true,
            ],
            [
                'group' => 'features',
                'key' => 'enable_testimonials',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Show testimonials on homepage',
                'autoload' => true,
            ],
            [
                'group' => 'features',
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Enable maintenance mode',
                'autoload' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}id,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Transform your ideas into powerful mobile applications. We develop native iOS and Android apps, as well as cross-platform solutions using React Native and Flutter. Our apps are designed for performance, user experience, and scalability.',
                'short_description' => 'Native and cross-platform mobile app development for iOS and Android.',
                'category' => 'mobile_app',
                'price' => 5000.00,
                'featured' => true,
                'status' => 'active',
                'sort_order' => 2,
                'tags' => ['iOS', 'Android', 'React Native', 'Flutter'],
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'SEO Optimization',
                'description' => 'Boost your online visibility with our comprehensive SEO services. We optimize your website for search engines, conduct keyword research, create quality content, and build authoritative backlinks to improve your rankings and drive organic traffic.',
                'short_description' => 'Complete SEO optimization to improve search rankings and organic traffic.',
                'category' => 'digital_marketing',
                'price' => 800.00,
                'featured' => true,
                'status' => 'active',
                'sort_order' => 3,
                'tags' => ['SEO', 'Keyword Research', 'Content Marketing', 'Link Building'],
                'created_by' => $adminUser->]