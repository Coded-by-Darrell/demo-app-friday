
// database/seeders/ServiceCategorySeeder.php
namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web_development',
                'description' => 'Custom website development and web applications',
                'icon' => 'fas fa-code',
                'color' => '#007AFF',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile_app',
                'description' => 'iOS and Android mobile application development',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#5856D6',
                'sort_order' => 2,
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital_marketing',
                'description' => 'SEO, social media, and online marketing services',
                'icon' => 'fas fa-bullhorn',
                'color' => '#FF9500',
                'sort_order' => 3,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui_ux_design',
                'description' => 'User interface and user experience design',
                'icon' => 'fas fa-paint-brush',
                'color' => '#FF3B30',
                'sort_order' => 4,
            ],
            [
                'name' => 'E-commerce Solutions',
                'slug' => 'ecommerce',
                'description' => 'Online store development and e-commerce platforms',
                'icon' => 'fas fa-shopping-cart',
                'color' => '#34C759',
                'sort_order' => 5,
            ],
            [
                'name' => 'Consulting',
                'slug' => 'consulting',
                'description' => 'Business and technology consulting services',
                'icon' => 'fas fa-lightbulb',
                'color' => '#8E8E93',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}

// database/seeders/ServiceSeeder.php
namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('is_admin', true)->first();
        
        $services = [
            [
                'title' => 'Custom Website Development',
                'description' => 'We create stunning, responsive websites tailored to your business needs. Our team uses the latest technologies including Laravel, React, and Vue.js to build fast, secure, and scalable web applications. From simple landing pages to complex web platforms, we deliver exceptional digital experiences that drive results.',
                'short_description' => 'Professional custom website development with modern technologies and responsive design.',
                'category' => 'web_development',
                'price' => 2500.00,
                'featured' => true,
                'status' => 'active',
                'sort_order' => 1,
                'tags' => ['Laravel', 'React', 'Vue.js', 'Responsive Design'],
                'meta_title' => 'Custom Website Development Services',
                'meta_description' => 'Get professional custom website development with Laravel, React, and modern technologies.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'E-commerce Platform Development',
                'description' => 'Build a powerful online store with our e-commerce solutions. We create custom shopping platforms with payment integration, inventory management, order tracking, and customer management systems. Perfect for businesses ready to sell online.',
                'short_description' => 'Custom e-commerce platforms with payment integration and management systems.',
                'category' => 'ecommerce',
                'price' => 4000.00,
                'featured' => true,
                'status' => 'active',
                'sort_order' => 4,
                'tags' => ['E-commerce', 'Payment Gateway', 'Shopping Cart', 'Inventory Management'],
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'UI/UX Design Services',
                'description' => 'Create engaging user experiences with our professional UI/UX design services. We focus on user research, wireframing, prototyping, and creating beautiful interfaces that convert visitors into customers.',
                'short_description' => 'Professional UI/UX design for web and mobile applications.',
                'category' => 'ui_ux_design',
                'price' => 1500.00,
                'featured' => false,
                'status' => 'active',
                'sort_order' => 5,
                'tags' => ['UI Design', 'UX Research', 'Prototyping', 'User Testing'],
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Social Media Marketing',
                'description' => 'Grow your brand presence across social media platforms. Our team creates engaging content, manages your social accounts, runs targeted ad campaigns, and analyzes performance to maximize your social media ROI.',
                'short_description' => 'Complete social media marketing and management services.',
                'category' => 'digital_marketing',
                'price' => 1200.00,
                'featured' => false,
                'status' => 'active',
                'sort_order' => 6,
                'tags' => ['Social Media', 'Content Creation', 'Facebook Ads', 'Instagram Marketing'],
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Business Consulting',
                'description' => 'Get expert guidance for your business growth. Our consultants help with digital transformation, process optimization, technology strategy, and business development to accelerate your success.',
                'short_description' => 'Strategic business consulting for digital transformation and growth.',
                'category' => 'consulting',
                'price' => 200.00,
                'featured' => false,
                'status' => 'active',
                'sort_order' => 7,
                'tags' => ['Business Strategy', 'Digital Transformation', 'Process Optimization'],
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Website Maintenance',
                'description' => 'Keep your website running smoothly with our maintenance services. We provide regular updates, security monitoring, backup management, performance optimization, and technical support.',
                'short_description' => 'Ongoing website maintenance and support services.',
                'category' => 'web_development',
                'price' => 300.00,
                'featured' => false,
                'status' => 'active',
                'sort_order' => 8,
                'tags' => ['Maintenance', 'Security', 'Backups', 'Support'],
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create additional services using factory
        Service::factory(15)->create([
            'created_by' => $adminUser->id,
        ]);
    }
}

// database/seeders/TeamMemberSeeder.php
namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Sarah Johnson',
                'position' => 'CEO & Founder',
                'department' => 'Executive',
                'bio' => 'Sarah is a visionary leader with over 10 years of experience in digital transformation and business strategy. She founded Innovations Solutions & Marketing to help businesses thrive in the digital age.',
                'email' => 'sarah@innovations-marketing.com',
                'phone' => '+63 912 345 6781',
                'linkedin' => 'https://linkedin.com/in/sarahjohnson',
                'twitter' => 'https://twitter.com/sarahjohnson',
                'skills' => ['Leadership', 'Strategy', 'Digital Transformation', 'Business Development'],
                'hire_date' => '2020-01-01',
                'sort_order' => 1,
                'active' => true,
            ],
            [
                'name' => 'Michael Chen',
                'position' => 'CTO & Lead Developer',
                'department' => 'Technology',
                'bio' => 'Michael is a full-stack developer with expertise in Laravel, React, and cloud technologies. He leads our technical team and ensures we deliver cutting-edge solutions.',
                'email' => 'michael@innovations-marketing.com',
                'phone' => '+63 912 345 6782',
                'linkedin' => 'https://linkedin.com/in/michaelchen',
                'github' => 'https://github.com/michaelchen',
                'skills' => ['Laravel', 'React', 'Vue.js', 'AWS', 'DevOps'],
                'hire_date' => '2020-02-15',
                'sort_order' => 2,
                'active' => true,
            ],
            [
                'name' => 'Emily Rodriguez',
                'position' => 'Creative Director',
                'department' => 'Design',
                'bio' => 'Emily brings creativity and user-centered design to every project. With a background in graphic design and UX, she ensures our solutions are both beautiful and functional.',
                'email' => 'emily@innovations-marketing.com',
                'phone' => '+63 912 345 6783',
                'linkedin' => 'https://linkedin.com/in/emilyrodriguez',
                'skills' => ['UI/UX Design', 'Graphic Design', 'Prototyping', 'User Research'],
                'hire_date' => '2020-03-10',
                'sort_order' => 3,
                'active' => true,
            ],
            [
                'name' => 'David Kim',
                'position' => 'Digital Marketing Manager',
                'department' => 'Marketing',
                'bio' => 'David specializes in digital marketing strategies that drive results. His expertise in SEO, social media, and paid advertising helps our clients achieve their marketing goals.',
                'email' => 'david@innovations-marketing.com',
                'phone' => '+63 912 345 6784',
                'linkedin' => 'https://linkedin.com/in/davidkim',
                'skills' => ['SEO', 'Google Ads', 'Social Media Marketing', 'Analytics'],
                'hire_date' => '2020-04-20',
                'sort_order' => 4,
                'active' => true,
            ],
            [
                'name' => 'Lisa Wang',
                'position' => 'Senior Frontend Developer',
                'department' => 'Technology',
                'bio' => 'Lisa is passionate about creating amazing user interfaces. She specializes in modern frontend frameworks and ensures our applications provide exceptional user experiences.',
                'email' => 'lisa@innovations-marketing.com',
                'phone' => '+63 912 345 6785',
                'github' => 'https://github.com/lisawang',
                'skills' => ['React', 'Vue.js', 'TypeScript', 'CSS3', 'Mobile Development'],
                'hire_date' => '2021-01-15',
                'sort_order' => 5,
                'active' => true,
            ],
            [
                'name' => 'James Wilson',
                'position' => 'Backend Developer',
                'department' => 'Technology',
                'bio' => 'James focuses on building robust and scalable backend systems. His expertise in Laravel and database optimization ensures our applications perform at their best.',
                'email' => 'james@innovations-marketing.com',
                'phone' => '+63 912 345 6786',
                'github' => 'https://github.com/jameswilson',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'Redis', 'API Development'],
                'hire_date' => '2021-03-01',
                'sort_order' => 6,
                'active' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        // Create additional team members using factory
        TeamMember::factory(8)->create();
    }
}