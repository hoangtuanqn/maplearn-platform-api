<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Auth\Access\Response;



class DocumentPolicy
{
    use AuthorizesOwnerOrAdmin;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Document $document): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, ['admin', 'teacher'])
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo tài liệu.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): Response
    {
        return $this->canManage($user, $document, 'cập nhật');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): Response
    {
        return $this->canManage($user, $document, 'xóa');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): Response
    {
        return $this->canManage($user, $document, 'khôi phục');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): Response
    {
        return $this->canManage($user, $document, 'xóa vĩnh viễn');
    }
}
