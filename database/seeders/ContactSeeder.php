// database/seeders/ContactSeeder.php
namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@techcorp.com',
                'phone' => '+63 912 111 1111',
                'company' => 'TechCorp Solutions',
                'subject' => 'Website Development Inquiry',
                'message' => 'We are looking to develop a new corporate website with modern design and e-commerce capabilities. Could you provide a quote?',
                'service_interest' => 'web_development, ecommerce',
                'budget_range' => '10k_25k',
                'preferred_contact' => 'email',
                'status' => 'unread',
                'source' => 'web',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@startupph.com',
                'phone' => '+63 912 222 2222',
                'company' => 'StartupPH',
                'subject' => 'Mobile App Development',
                'message' => 'We need a mobile app for our delivery service. Looking for both iOS and Android platforms.',
                'service_interest' => 'mobile_app',
                'budget_range' => '25k_50k',
                'preferred_contact' => 'phone',
                'status' => 'read',
                'source' => 'api',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Robert Chen',
                'email' => 'robert@digitalagency.com',
                'phone' => '+63 912 333 3333',
                'company' => 'Digital Agency Pro',
                'subject' => 'SEO Services Partnership',
                'message' => 'We would like to discuss a partnership for SEO services for our clients. Can we schedule a meeting?',
                'service_interest' => 'digital_marketing',
                'budget_range' => 'over_50k',
                'preferred_contact' => 'either',
                'status' => 'responded',
                'source' => 'web',
                'admin_notes' => 'Scheduled meeting for next week. Very promising lead.',
                'created_at' => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        // Create additional contacts using factory
        Contact::factory(25)->create();
    }
}