<?php

namespace App\Policies\Backend;

use App\Models\Auth\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BackendPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('Super User')) return true;
        if (!$user->active) return false;

        return null;
    }

    /**
     * User has access to backend part
     *
     * @param User $user
     * @return bool|int
     */
    public function view(User $user)
    {
        /**
         * Add roles, who can view backend
         * Super User fill as example
         */
        return $user->hasRoles(['Super User']);
    }
}
