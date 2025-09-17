<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttemptExams\ViolationsCountFilter;
use App\Filters\PaperExam\CategoriesSlugFilter;
use App\Filters\PaperExam\DifficultiesSlugFilter;
use App\Filters\PaperExam\ProvincesSlugFilter;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamAttempt;
use App\Models\ExamPaper;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExamController extends BaseApiController
{
    use AuthorizesRequests, AuthorizesOwnerOrAdmin;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = (int)($request->limit ?? 20);
        // Filter môn học, phân loại học, độ khóa
        $exams = QueryBuilder::for(ExamPaper::class)
            ->allowedFilters([
                'title',
                'grade_level',
                'subject',
                "difficulty",
                AllowedFilter::custom('provinces', new ProvincesSlugFilter),
                AllowedFilter::custom('categories', new CategoriesSlugFilter),
                AllowedFilter::custom('difficulties', new DifficultiesSlugFilter),
            ])
            ->orderByDesc('id')
            ->paginate($limit);
        // ẩn thuộc tính này khi hiển thị
        $exams->makeHidden(['is_in_progress', 'question_count', 'total_attempt_count', 'attempt_count']);

        // Thêm thuộc tính: Số người đã làm bài
        $exams->getCollection()->transform(function ($item) {
            $item->registered_count = $item->examAttempts()->count();
            return $item;
        });

        return $this->successResponse($exams, 'Lấy danh sách đề thi thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        Gate::authorize('admin-teacher');
        $data = $request->validate([
            'exam_category'        => 'required|string|max:255',
            'subject'              => 'required|string|max:255',
            'grade_level'          => 'required|string|max:255',
            'title'                => 'required|string|max:255',
            'province'             => 'nullable|string|max:255',
            'difficulty'           => 'nullable|string|max:255',
            'exam_type'            => 'nullable|string|max:255',
            'max_score'            => 'required|numeric|min:0',
            'pass_score'           => 'required|numeric|min:0',
            'duration_minutes'     => 'required|integer|min:1',
            'anti_cheat_enabled'   => 'nullable|boolean',
            'max_violation_attempts' => 'nullable|integer|min:0',
            'status'               => 'nullable|boolean',
            'start_time'           => 'nullable|date',
            'end_time'             => 'nullable|date|after:start_time',
        ]);

        $data['user_id'] = $user->id;
        $exam = ExamPaper::create($data);
        return $this->successResponse($exam, 'Tạo đề thi thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamPaper $exams_admin)
    {
        return $this->successResponse($exams_admin, 'Lấy thông tin đề thi thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamPaper $exams_admin)
    {
        Gate::authorize('admin-teacher-owner', $exams_admin);
        $data = $request->validate([
            'exam_category'        => 'nullable|string|max:255',
            'subject'              => 'nullable|string|max:255',
            'grade_level'          => 'nullable|string|max:255',
            'title'                => 'nullable|string|max:255',
            'province'             => 'nullable|string|max:255',
            'difficulty'           => 'nullable|string|max:255',
            'exam_type'            => 'nullable|string|max:255',
            'max_score'            => 'nullable|numeric|min:0',
            'pass_score'           => 'nullable|numeric|min:0',
            'duration_minutes'     => 'nullable|integer|min:1',
            'anti_cheat_enabled'   => 'nullable|boolean',
            'max_violation_attempts' => 'nullable|integer|min:0',
            'status'               => 'nullable|boolean',
            'start_time'           => 'nullable|date',
            'end_time'             => 'nullable|date|after:start_time',
        ]);

        $exams_admin->update($data);
        return $this->successResponse($exams_admin, 'Cập nhật đề thi thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamPaper $exams_admin)
    {
        Gate::authorize('admin-teacher-owner', $exams_admin);
        // Chưa có người thi thì xóa được
        if ($exams_admin->examAttempts()->count() > 0) {
            return $this->errorResponse(null, 'Đề thi đã có người tham gia, không thể xóa!', 400);
        }
        $exams_admin->delete();
        return $this->successResponse(null, 'Xóa đề thi thành công!');
    }
    // get tất cả lịch sử làm bài thi
    public function allHistory(Request $request)
    {
        Gate::authorize('admin-teacher');
        $limit = (int)($request->limit ?? 20);
        $histories = QueryBuilder::for(ExamAttempt::class)
            ->allowedFilters([
                "started_at",

                "status",
                "time_spent",
                AllowedFilter::custom('violation_count', new ViolationsCountFilter),
                AllowedFilter::partial('search', 'paper.title'),
                AllowedFilter::callback('min_score', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->where('score', '>=', (float) $value);
                    }
                }),
                AllowedFilter::callback('max_score', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->where('score', '<=', (float) $value);
                    }
                }),
            ])
            ->with(['paper', 'user:id,full_name,username'])
            ->orderByDesc('id')
            ->paginate($limit);
        $histories->makeHidden(['details']);
        return $this->successResponse($histories, 'Lấy tất cả lịch sử làm bài thi thành công!');
    }

    // get lịch sử làm bài thi
    public function history(Request $request, ExamPaper $exams_admin)
    {
        Gate::authorize('admin-teacher-owner', $exams_admin);
        $limit = (int)($request->limit ?? 20);
        $history = $exams_admin->examAttempts()
            ->with('user:id,full_name,username')
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->successResponse($history, 'Lấy lịch sử làm bài thi thành công!');
    }
}
