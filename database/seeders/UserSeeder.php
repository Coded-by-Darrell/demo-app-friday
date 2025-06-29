// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@innovations-marketing.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '+63 912 345 6789',
            'company' => 'Innovations Solutions & Marketing',
            'bio' => 'System administrator and founder of Innovations Solutions & Marketing.',
            'is_admin' => true,
            'is_active' => true,
        ]);

        // Create regular demo user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '+63 912 345 6780',
            'company' => 'Tech Startup Inc.',
            'bio' => 'Web developer and entrepreneur.',
            'is_admin' => false,
            'is_active' => true,
        ]);

        // Create additional demo users
        User::factory(10)->create();
    }
}