<?php

namespace MohamedSaid\Notable\Observers;

use Illuminate\Database\Eloquent\Model;
use MohamedSaid\Notable\Notable;

class NotableObserver
{
    public function creating(Notable $notable): void
    {
        $user = auth()->user();

        if (empty($notable->creator_type) && $user instanceof Model) {
            $notable->creator_type = $user->getMorphClass();
            $notable->creator_id = $user->getKey();
        }
    }
}
