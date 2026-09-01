<?php

use App\Enums\Feature\FeaturePriority;
use App\Enums\Feature\FeatureStatus;
use App\Enums\Feature\FeatureType;
use App\Models\Project;
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

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('plan');
            $table->enum('status', FeatureStatus::cases())->default(FeatureStatus::PENDING);
            $table->enum('priority', FeaturePriority::cases())->default(FeaturePriority::MEDIUM);
            $table->enum('type', FeatureType::cases())->default(FeatureType::FEATURE);
            $table->unsignedInteger('sort')->default(0);
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
