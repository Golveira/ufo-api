<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function update(User $user, Report $report): bool
    {
        return $report->user()->is($user);
    }

    public function delete(User $user, Report $report): bool
    {
        return $report->user()->is($user);
    }
}
