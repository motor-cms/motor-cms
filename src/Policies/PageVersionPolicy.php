<?php

namespace Motor\CMS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\User;
use Motor\CMS\Models\PageVersion;

class PageVersionPolicy
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
        return $user->hasPermissionTo('page_versions.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\PageVersion  $pageVersion
     * @return mixed
     */
    public function view(User $user, PageVersion $pageVersion)
    {
        return $user->hasPermissionTo('page_versions.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('page_versions.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\PageVersion  $pageVersion
     * @return mixed
     */
    public function update(User $user, PageVersion $pageVersion)
    {
        return $user->hasPermissionTo('page_versions.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\PageVersion  $pageVersion
     * @return mixed
     */
    public function delete(User $user, PageVersion $pageVersion)
    {
        return $user->hasPermissionTo('page_versions.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\PageVersion  $pageVersion
     * @return mixed
     */
    public function restore(User $user, PageVersion $pageVersion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\CMS\Models\PageVersion  $pageVersion
     * @return mixed
     */
    public function forceDelete(User $user, PageVersion $pageVersion)
    {
        //
    }
}
