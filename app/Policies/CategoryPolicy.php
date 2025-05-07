<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function manage(User $user): bool
    {
        // Replace with your admin check logic
        return $user->id === 1;
    }
}
