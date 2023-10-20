<?php

namespace App\Policies;

use App\Models\Dossier;
use App\Models\User;

class DossierPolicy
{
    public function update(User $user, Dossier $dossier): bool
    {
        return $dossier->user()->is($user);
    }

    public function delete(User $user, Dossier $dossier): bool
    {
        return $dossier->user()->is($user);
    }
}
