<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\ExamPaper;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends BaseApiController
{

    public function getDashboardData(Request $request)
    {
        // Validate start_date và end_date nếu có
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = [
            'total_in_this_year'  => $this->getTotalInThisYear($startDate, $endDate),
            'total_courses'       => $this->getTotalCourses($startDate, $endDate),
            'total_exams'         => $this->getTotalExams($startDate, $endDate),
            'total_users'         => $this->getTotalUsers($startDate, $endDate),
            'payment_methods'     => $this->getPaymentMethods($startDate, $endDate),
            'courses_by_category' => $this->getCoursesByCategory(),
            'new_users'           => $this->getNewUsers(),
            'new_payments'        => $this->getNewPayments(),
            'top_courses'         => $this->getTopCourses(),
            'activity_in_12_months' => $this->getActivityIn12Months(),
            'recent_activity'     => $this->getRecentActivity(),
        ];
        return $this->successResponse($data, 'Lấy dữ liệu dashboard thành công');
    }


    // tính tổng doanh thu trong năm nay (tính từ tháng 1 năm nay) hoặc theo khoảng thời gian
    private function getTotalInThisYear($startDate = null, $endDate = null): array
    {
        // Nếu không truyền start_date và end_date thì lấy từ đầu năm đến cuối năm hiện tại
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfYear()->toDateString();
            $endDate = now()->endOfYear()->toDateString();
        }

        // Tạo danh sách các tháng trong khoảng thời gian
        $start = \Carbon\Carbon::parse($startDate)->startOfMonth();
        $end = \Carbon\Carbon::parse($endDate)->endOfMonth();
        $months = [];
        $current = $start->copy();
        while ($current <= $end) {
            $months[$current->format('Y-m')] = 0;
            $current->addMonth();
        }

        // Lấy tổng tiền theo từng tháng trong khoảng thời gian
        $payments = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(paid_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($payments as $payment) {
            $months[$payment->month] = (int)$payment->total;
        }

        return $months;
    }


    private function getTotalCourses($startDate = null, $endDate = null): int
    {
        // Nếu không truyền start_date và end_date thì filter trong năm nay (từ tháng 1)
        if (!$startDate || !$endDate) {
            $startOfYear = now()->startOfYear();
            $endOfYear = now()->endOfYear();
            return Course::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
        }

        // Nếu có start_date và end_date thì filter theo khoảng thời gian đó
        return Course::whereBetween('created_at', [$startDate, $endDate])->count();
    }


    private function getTotalExams($startDate = null, $endDate = null): int
    {
        // Nếu không truyền start_date và end_date thì filter trong năm nay (từ tháng 1)
        if (!$startDate || !$endDate) {
            $startOfYear = now()->startOfYear();
            $endOfYear = now()->endOfYear();
            return ExamPaper::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
        }

        // Nếu có start_date và end_date thì filter theo khoảng thời gian đó
        return ExamPaper::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    // tính tổng người dùng student được tạo trong khoảng thời gian
    private function getTotalUsers($startDate = null, $endDate = null): int
    {
        // Nếu không truyền start_date và end_date thì filter trong năm nay (từ tháng 1)
        if (!$startDate || !$endDate) {
            $startOfYear = now()->startOfYear();
            $endOfYear = now()->endOfYear();
            return User::where('role', 'student')
                ->whereBetween('created_at', [$startOfYear, $endOfYear])
                ->count();
        }

        // Nếu có start_date và end_date thì filter theo khoảng thời gian đó
        return User::where('role', 'student')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    // tính số lần thanh toán theo phương thức trong khoảng thời gian. VD: VNPAY: 10, MOMO: 5
    private function getPaymentMethods($startDate = null, $endDate = null): array
    {
        $query = Payment::where('status', 'paid');

        // Nếu không truyền start_date và end_date thì filter trong năm nay (từ tháng 1)
        if (!$startDate || !$endDate) {
            $startOfYear = now()->startOfYear();
            $endOfYear = now()->endOfYear();
            $query->whereBetween('paid_at', [$startOfYear, $endOfYear]);
        } else {
            // Nếu có start_date và end_date thì filter theo khoảng thời gian đó
            $query->whereBetween('paid_at', [$startDate, $endDate]);
        }

        $methods = $query->select('payment_method')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('payment_method')
            ->get()
            ->pluck('count', 'payment_method')
            ->toArray();

        return $methods;
    }

    // phân bổ khóa học theo danh mục (trả về tên danh mục + số khóa học trong đó)
    private function getCoursesByCategory(): array
    {
        $categories = Course::select('category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();
        return $categories;
    }

    // get thông tin 4 người dùng mới (full_name, email)
    private function getNewUsers(): array
    {
        $users = User::select('id', 'full_name', 'avatar', 'email', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->where('role', 'student')
            ->limit(4)
            ->get();
        // loại bỏ trường created_at, role
        $users->makeHidden(['created_at', 'role']);
        return $users->toArray();
    }

    // get 4 hóa đơn được thanh toán mới nhất
    private function getNewPayments(): array
    {
        $payments = Payment::where('status', 'paid')
            ->with(['user:id,full_name', 'course:id,name,slug']) // Thêm slug vào select
            ->orderBy('paid_at', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($payment) {
                $course = $payment->course;
                return [
                    'full_name'   => $payment->user->full_name ?? null,
                    'course_name' => $course->name ?? null,
                    'slug'        => $course->slug ?? null,
                    'amount'      => $payment->amount,
                ];
            })
            ->toArray();
        return $payments;
    }

    // get 4 khóa học có số học viên cao nhất ( chỉ return về name, số học viên, doanh thu bán được)
    private function getTopCourses(): array
    {
        $courses = Course::withCount('students')
            ->withSum('payments', 'amount')
            ->has('students')
            ->orderBy('students_count', 'desc')
            ->limit(4)
            ->get(['id', 'name'])
            ->map(function ($course) {
                return [
                    'name'           => $course->name,
                    'students_count' => $course->students_count,
                    'slug'           => $course->slug,
                    'revenue'        => (int)$course->payments_sum_amount ?? 0,
                ];
            })
            ->toArray();
        return $courses;
    }

    // lịch sử hoạt động trong 12 tháng (tính từ tháng 1 năm nay đến tháng 12) (Khóa học mới, người dùng mới, đề thi mới - chỉ tính số lượng)
    private function getActivityIn12Months(): array
    {
        $activities = [];
        $year = now()->year;
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = now()->setDate($year, $month, 1)->startOfMonth();
            $endOfMonth = now()->setDate($year, $month, 1)->endOfMonth();

            $newCourses = Course::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $newUsers   = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('role', 'student')->count();
            $newExams   = ExamPaper::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

            $activities[] = [
                'month'        => $startOfMonth->format('m-Y'),
                'new_courses'  => $newCourses,
                'new_users'    => $newUsers,
                'new_exams'    => $newExams,
            ];
        }
        return $activities;
    }

    // get thông tin người dùng mới, khóa học mới, đề thi mới trong 1 tháng vừa qua
    private function getRecentActivity(): array
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth   = now()->endOfMonth();

        $newCourses = Course::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newUsers   = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('role', 'student')->count();
        $newExams   = ExamPaper::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        return [
            'new_courses' => $newCourses,
            'new_users'   => $newUsers,
            'new_exams'   => $newExams,
        ];
    }
}
