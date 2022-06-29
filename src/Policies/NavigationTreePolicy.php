<?php

namespace Motor\CMS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\User;
use Motor\CMS\Models\Navigation;

class NavigationTreePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('navigation_trees.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\Navigation  $navigation
     * @return mixed
     */
    public function view(User $user, Navigation $navigation)
    {
        return $user->hasPermissionTo('navigation_trees.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('navigation_trees.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\Navigation  $navigation
     * @return mixed
     */
    public function update(User $user, Navigation $navigation)
    {
        return $user->hasPermissionTo('navigation_trees.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\Navigation  $navigation
     * @return mixed
     */
    public function delete(User $user, Navigation $navigation)
    {
        return $user->hasPermissionTo('navigation_trees.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\Navigation  $navigation
     * @return mixed
     */
    public function restore(User $user, Navigation $navigation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\Navigation  $navigation
     * @return mixed
     */
    public function forceDelete(User $user, Navigation $navigation)
    {
        //
    }
}
