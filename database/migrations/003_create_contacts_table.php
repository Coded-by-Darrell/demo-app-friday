// database/migrations/2024_01_01_000003_create_contacts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('service_interest')->nullable();
            $table->string('budget_range')->nullable();
            $table->enum('preferred_contact', ['email', 'phone', 'either'])->default('email');
            $table->enum('status', ['unread', 'read', 'responded'])->default('unread');
            $table->text('admin_notes')->nullable();
            $table->string('source')->default('web'); // web, api, etc.
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
            $table->index(['email', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};