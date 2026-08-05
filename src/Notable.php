<?php

namespace MohamedSaid\Notable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notable extends Model
{
    protected $guarded = ['id'];

    public function getTable(): string
    {
        return (string) config('notable.table_name', 'notables');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function notable(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeByCreator(Builder $query, Model $creator): Builder
    {
        return $query->where('creator_type', $creator->getMorphClass())
            ->where('creator_id', $creator->getKey());
    }

    public function scopeWithoutCreator(Builder $query): Builder
    {
        return $query->whereNull('creator_type');
    }

    public function scopeRecent(Builder $query, int $days = 7): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeOlderThan(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '<=', now()->subDays($days));
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function scopeThisYear(Builder $query): Builder
    {
        return $query->whereYear('created_at', now()->year);
    }

    public function scopeBetweenDates(Builder $query, mixed $startDate, mixed $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeContainingText(Builder $query, string $text): Builder
    {
        return $this->scopeSearch($query, $text);
    }

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        return $query->where('note', 'LIKE', '%'.$searchTerm.'%');
    }
}
