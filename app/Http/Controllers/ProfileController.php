<?php

namespace App\Http\Controllers;

use App\Filters\Invoice\DateFilter;
use App\Filters\Invoice\StatusFilter;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProfileController extends BaseApiController
{
    public function update(Request $request)
    {
        $request->user()->update($request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'gender' => 'sometimes|string|in:male,female,other',
            'birth_year' => 'sometimes|nullable',
            'school' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'facebook_link' => 'sometimes|string|max:255',
        ]));

        return response()->json([
            'message' => $request->user(),
        ]);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'password_old' => 'required|string|max:255',
            'password_new' => 'required|string|min:6|max:255',
        ]);

        $user = $request->user();

        // Kiểm tra mật khẩu cũ có đúng không
        if (!Hash::check($request->password_old, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu cũ không chính xác.',
            ], 401);
        }

        // Cập nhật mật khẩu mới (đã hash)
        $user->update([
            'password' => Hash::make($request->password_new),
        ]);

        return response()->json([
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }

    // Lấy danh sách khóa học của tôi
    public function getCoursesMe(Request $request)
    {
        $user = $request->user();
        $limit = $request->input('limit', 10); // số item mỗi trang, mặc định 10

        $courses = QueryBuilder::for($user->purchasedCourses()->orderBy('course_enrollments.created_at', 'desc'))
            ->allowedFilters(['title']) // lọc theo title nếu cần
            ->allowedSorts(['created_at', 'id']) // sắp xếp
            // ->latest('created_at')
            ->paginate($limit)
            ->appends($request->query()); // giữ nguyên query string khi phân trang

        return $this->successResponse($courses, "Đã lấy danh sách khóa học của bạn thành công!");
    }

    // Lấy danh sách hóa đơn
    public function getInvoicesMe(Request $request)
    {
        $user = $request->user();
        $invoices = QueryBuilder::for(Invoice::class)
            ->allowedSorts(['created_at'])
            ->allowedFilters(AllowedFilter::custom('status', new StatusFilter), AllowedFilter::custom('date', new DateFilter))
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(10);

        return $this->successResponse($invoices, 'Lấy danh sách hóa đơn thành công!');
    }
}
