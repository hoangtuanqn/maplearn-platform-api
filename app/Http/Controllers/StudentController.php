<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class StudentController extends BaseApiController
{
    public function index(Request $request)
    {
        // Đã check quyền admin ở middleware
        $limit = (int)($request->limit ?? 10);

        $students = QueryBuilder::for(User::class)
            ->where('role', 'student')
            ->orderBy('id', "desc")
            ->paginate($limit);
        return $this->successResponse($students, "Lấy danh sách học sinh thành công!");
    }

    // Lấy thông tin 1 student
    public function show(Request $request, $id)
    {
        $student = QueryBuilder::for(User::class)

            ->findOrFail($id);
        return $this->successResponse($student, "Lấy thông tin học sinh thành công!");
    }

    // update thông tin
    public function update(Request $request, User $student)
    {
        $student->update($request->validate([
            'avatar' => 'sometimes|url|max:2048',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'gender' => 'sometimes|string|in:male,female,other',
            'birth_year' => 'sometimes|nullable',
            'school' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'banned' => 'sometimes|boolean',
            'facebook_link' => 'sometimes|string|max:255',
        ]));

        return $this->successResponse($student, "Cập nhật thông tin thành công!");
    }

    public function resetPassword(Request $request, User $student)
    {
        // reset password mới từ admin
        $request->validate([
            'password' => 'required|string|min:6|max:255',
        ]);

        $student->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse($student, "Đặt lại mật khẩu thành công!");
    }

    // Get lịch sử hoạt động
    public function activityHistory(Request $request, User $student)
    {
        $limit = (int)($request->limit ?? 10);
        $activities = $student->activities()->orderBy('id', 'DESC')->paginate($limit);
        return $this->successResponse($activities, "Lấy lịch sử hoạt động thành công!");
    }
}
