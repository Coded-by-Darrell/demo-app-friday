// database/migrations/2024_01_01_000006_create_service_inquiries_table.php
// Tutorial #61: One to Many Relationship
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('message');
            $table->json('requirements')->nullable(); // Specific project requirements
            $table->string('budget_range')->nullable();
            $table->date('preferred_start_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['new', 'contacted', 'quoted', 'won', 'lost'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->index(['service_id', 'status']);
            $table->index('created_at');
            $table->index('priority');
        });
    }