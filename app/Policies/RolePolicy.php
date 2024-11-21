<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the can view any models.
     *
     * @param  \App\Models\ $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the can view the model.
     *
     * @param  \App\Models\ $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Role $role)
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the can create models.
     *
     * @param  \App\Models\ $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return $user->hasAbility('roles.create');
    }

    /**
     * Determine whether the can update the model.
     *
     * @param  \App\Models\ $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Role $role)
    {
        return $user->hasAbility('roles.update');
    }

    /**
     * Determine whether the can delete the model.
     *
     * @param  \App\Models\ $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Role $role)
    {
        return $user->hasAbility('roles.delete');
    }

    /**
     * Determine whether the can restore the model.
     *
     * @param  \App\Models\ $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Role $role)
    {
        return $user->hasAbility('roles.restore');
    }

    /**
     * Determine whether the can permanently delete the model.
     *
     * @param  \App\Models\ $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Role $role)
    {
        return $user->hasAbility('roles.force-delete');
    }
}
