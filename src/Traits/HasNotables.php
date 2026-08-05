<?php

namespace MohamedSaid\Notable\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use MohamedSaid\Notable\Notable;

trait HasNotables
{
    public function notables(): MorphMany
    {
        return $this->morphMany(Notable::class, 'notable')->orderBy(config('notable.order_by_column', 'created_at'), config('notable.order_by_direction', 'desc'));
    }

    public function addNote(string $note, ?Model $creator = null): Notable
    {
        $data = ['note' => $note];

        if ($creator) {
            $data['creator_type'] = $creator->getMorphClass();
            $data['creator_id'] = $creator->getKey();
        }

        return $this->notables()->create($data);
    }

    public function getNotes(): Collection
    {
        return $this->notables()->get();
    }

    public function getLatestNote(): ?Notable
    {
        return $this->notables()->reorder()->latest()->first();
    }

    public function hasNotes(): bool
    {
        return $this->notables()->exists();
    }

    public function notesCount(): int
    {
        return $this->notables()->count();
    }

    public function getNotesByCreator(Model $creator): Collection
    {
        return $this->notables()
            ->where('creator_type', $creator->getMorphClass())
            ->where('creator_id', $creator->getKey())
            ->get();
    }

    public function getNotesWithCreator(): Collection
    {
        return $this->notables()->with('creator')->get();
    }

    public function deleteNote(int $noteId): bool
    {
        return $this->notables()->reorder()->where('id', $noteId)->delete() > 0;
    }

    public function updateNote(int $noteId, string $note): bool
    {
        return $this->notables()->reorder()->where('id', $noteId)->update(['note' => $note]) > 0;
    }

    public function searchNotes(string $searchTerm): Collection
    {
        return $this->notables()->search($searchTerm)->get();
    }

    public function getNotesToday(): Collection
    {
        return $this->notables()->today()->get();
    }

    public function getNotesThisWeek(): Collection
    {
        return $this->notables()->thisWeek()->get();
    }

    public function getNotesThisMonth(): Collection
    {
        return $this->notables()->thisMonth()->get();
    }

    public function getNotesInRange(mixed $startDate, mixed $endDate): Collection
    {
        return $this->notables()->betweenDates($startDate, $endDate)->get();
    }
}
