<?php

namespace MohamedSaid\Notable\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use MohamedSaid\Notable\Notable;

trait HasNotables
{
    public function notables(): MorphMany
    {
        return $this->morphMany(Notable::class, 'notable');
    }

    public function addNote(string $note, $creator = null): Notable
    {
        $data = ['note' => $note];

        if ($creator) {
            $data['creator_type'] = get_class($creator);
            $data['creator_id'] = $creator->getKey();
        }

        return $this->notables()->create($data);
    }

    public function getNotes()
    {
        return $this->notables()->orderBy('created_at', 'desc')->get();
    }

    public function getLatestNote(): ?Notable
    {
        return $this->notables()->orderBy('created_at', 'desc')->first();
    }

    public function hasNotes(): bool
    {
        return $this->notables()->exists();
    }

    public function notesCount(): int
    {
        return $this->notables()->count();
    }

    public function getNotesByCreator($creator)
    {
        return $this->notables()
            ->where('creator_type', get_class($creator))
            ->where('creator_id', $creator->getKey())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getNotesWithCreator()
    {
        return $this->notables()->with('creator')->orderBy('created_at', 'desc')->get();
    }

    public function deleteNote(int $noteId): bool
    {
        return $this->notables()->where('id', $noteId)->delete();
    }

    public function updateNote(int $noteId, string $note): bool
    {
        return $this->notables()->where('id', $noteId)->update(['note' => $note]);
    }
}
