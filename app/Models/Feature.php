<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'plan', 'status', 'priority', 'type', 'sort', 'project_id'])]
class Feature extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'project_id' => 'integer',
        ];
    }

    public function acceptanceCriterias(): HasMany
    {
        return $this->hasMany(AcceptanceCriteria::class);
    }

    public function userStories(): HasMany
    {
        return $this->hasMany(UserStory::class);
    }

    public function planTasks(): HasMany
    {
        return $this->hasMany(PlanTask::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
