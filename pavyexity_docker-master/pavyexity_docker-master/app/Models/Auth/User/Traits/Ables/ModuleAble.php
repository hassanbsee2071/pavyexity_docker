<?php

namespace App\Models\Auth\User\Traits\Ables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Module;
use Illuminate\Support\Str;

trait ModuleAble
{
    /**
     * Checks if the user has a role.
     *
     * @param $role
     * @return bool
     */
    public function hasPermissionToModule($module)
    {
        if ($module instanceof Module) $module = $module->getKey();

        if ($this->modules->isEmpty()) return false;

        return ($this->modules->contains('id', null, $module) ||
            $this->modules->contains('name', null, $module) ||
            $this->modules->contains('slug', null, Str::slug($module)));
    }
}
