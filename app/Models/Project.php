<?php

namespace App\Models;

use App\Enums\Project\ProjectStatus;
use App\Models\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $user_id
 */
#[Fillable(['name', 'description', 'audience', 'status', 'conventions'])]
#[ScopedBy([AuthUserScope::class])]
class Project extends Model
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
            'status' => ProjectStatus::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            $project->user_id = Auth::id();
        });
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }
}
