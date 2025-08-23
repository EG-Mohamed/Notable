<?php

namespace MohamedSaid\Notable\Observers;

use MohamedSaid\Notable\Notable;

class NotableObserver
{
    public function creating(Notable $notable): void
    {
        if (empty($notable->creator_type) && auth()->check()) {
            $notable->creator_type = auth()->user()->getMorphClass();
            $notable->creator_id = auth()->id();
        }
    }
}
