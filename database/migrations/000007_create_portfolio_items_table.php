// database/migrations/2024_01_01_000007_create_portfolio_items_table.php
// Tutorial #61: One to Many Relationship
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('client_name');
            $table->string('project_url')->nullable();
            $table->json('images'); // Array of image paths
            $table->json('technologies')->nullable(); // Tech stack used
            $table->date('completion_date');
            $table->integer('duration_months')->nullable();
            $table->enum('status', ['completed', 'ongoing', 'paused'])->default('completed');
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['service_id', 'featured']);
            $table->index('completion_date');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};