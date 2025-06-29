// database/migrations/2024_01_01_000010_create_settings_table.php
// For application settings
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->text('description')->nullable();
            $table->boolean('autoload')->default(false);
            $table->timestamps();
            
            $table->index(['group', 'key']);
            $table->index('autoload');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};