// database/migrations/2024_01_01_000008_add_columns_to_users_table.php
// Extend the existing users table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('company')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('company');
            $table->string('avatar')->nullable()->after('bio');
            $table->boolean('is_admin')->default(false)->after('avatar');
            $table->boolean('is_active')->default(true)->after('is_admin');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->json('preferences')->nullable()->after('last_login_at');
            $table->softDeletes()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'company', 'bio', 'avatar', 'is_admin', 
                'is_active', 'last_login_at', 'preferences', 'deleted_at'
            ]);
        });
    }
};