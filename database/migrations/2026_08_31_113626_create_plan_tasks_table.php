<?php

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\Feature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('plan_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task');
            $table->text('description');
            $table->enum('status', PlanTaskStatus::cases())->default(PlanTaskStatus::PENDING);
            $table->unsignedInteger('sort')->default(0);
            $table->foreignIdFor(Feature::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_tasks');
    }
};
