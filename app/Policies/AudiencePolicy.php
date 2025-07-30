<?php

namespace App\Policies;

use App\Models\Audience;
use App\Models\User;
use App\Traits\AuthorizesAdminOnly;
use Illuminate\Auth\Access\Response;

class AudiencePolicy
{
    use AuthorizesAdminOnly;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Audience $audience): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $this->canManage($user, 'tạo đối tượng');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Audience $audience): Response
    {
        return $this->canManage($user, 'cập nhật đối tượng');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Audience $audience): Response
    {
        return $this->canManage($user, 'xóa đối tượng');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Audience $audience): Response
    {
        return $this->canManage($user, 'khôi phục đối tượng');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Audience $audience): Response
    {
        return $this->canManage($user, 'xóa vĩnh viễn đối tượng');
    }
}
