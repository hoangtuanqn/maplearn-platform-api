<?php

namespace App\Policies;

use App\Models\CourseCategory;
use App\Models\User;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Auth\Access\Response;

class CourseCategoryPolicy
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
    public function view(?User $user, CourseCategory $courseCategory): bool
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
            : Response::deny('Bạn không có quyền tạo danh mục khóa học.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CourseCategory $courseCategory): Response
    {
        return $this->canManage($user, $courseCategory, 'cập nhật');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CourseCategory $courseCategory): Response
    {
        return $this->canManage($user, $courseCategory, 'xóa');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CourseCategory $courseCategory): Response
    {
        return $this->canManage($user, $courseCategory, 'khôi phục');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CourseCategory $courseCategory): Response
    {
        return $this->canManage($user, $courseCategory, 'xóa vĩnh viễn');
    }
}
