<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentReview;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $statistics = $this->getDashboardStatistics();
        $chartData = $this->getChartData();
        $recentActivities = $this->getRecentActivities();
        $overdueDocuments = $this->getOverdueDocuments();

        return view('dashboard.index', compact(
            'statistics',
            'chartData',
            'recentActivities',
            'overdueDocuments'
        ));
    }

    /**
     * Get dashboard statistics.
     */
    private function getDashboardStatistics()
    {
        return [
            'total_documents' => Document::count(),
            'pending_reviews' => Document::whereNotNull('latest_reviewer_id')
                ->whereNotIn('status', ['IFC', 'IFI'])
                ->count(),
            'overdue_documents' => Document::overdue()->count(),
            'completed_this_month' => Document::whereIn('status', ['IFC', 'IFI'])
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
            'my_pending_reviews' => auth()->user()->isReviewer()
                ? Document::where('latest_reviewer_id', auth()->id())
                    ->whereNotIn('status', ['IFC', 'IFI'])
                    ->count()
                : 0,
        ];
    }

    /**
     * Get chart data for dashboard.
     */
    private function getChartData()
    {
        return [
            'status_distribution' => $this->getStatusDistribution(),
            'monthly_submissions' => $this->getMonthlySubmissions(),
            'reviewer_workload' => $this->getReviewerWorkload(),
        ];
    }

    /**
     * Get document status distribution for pie chart.
     */
    private function getStatusDistribution()
    {
        $statusCounts = Document::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusLabels = [
            'NS' => 'Not Submitted',
            'IFR' => 'Issued for Review',
            'RIFR' => 'Re-Issued for Review',
            'IFA' => 'Issued for Approval',
            'RIFA' => 'Re-Issued for Approval',
            'IFC' => 'Issued for Construction',
            'RIFC' => 'Re-Issued for Construction',
            'IFI' => 'Issued for Information',
        ];

        $data = [];
        foreach ($statusLabels as $status => $label) {
            if (isset($statusCounts[$status])) {
                $data[] = [
                    'label' => $label,
                    'value' => $statusCounts[$status],
                    'status' => $status
                ];
            }
        }

        return $data;
    }

    /**
     * Get monthly submission trends for line chart.
     */
    private function getMonthlySubmissions()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');

            $count = Document::whereYear('submission_date', $date->year)
                ->whereMonth('submission_date', $date->month)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    /**
     * Get reviewer workload for bar chart.
     */
    private function getReviewerWorkload()
    {
        $reviewers = User::where('role', 'reviewer')
            ->withCount(['reviewDocuments as pending_count' => function ($query) {
                $query->whereNotIn('status', ['IFC', 'IFI']);
            }])
            ->get();

        return [
            'labels' => $reviewers->pluck('name')->toArray(),
            'data' => $reviewers->pluck('pending_count')->toArray()
        ];
    }

    /**
     * Get recent activities for the dashboard.
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Recent document submissions
        $recentDocuments = Document::with('latestReviewer')
            ->whereNotNull('submission_date')
            ->orderBy('submission_date', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentDocuments as $document) {
            $activities->push([
                'type' => 'document_submitted',
                'message' => "Document {$document->document_number} was submitted for review",
                'date' => $document->submission_date,
                'icon' => 'document-plus',
                'color' => 'blue'
            ]);
        }

        // Recent reviews
        $recentReviews = DocumentReview::with(['document', 'reviewer'])
            ->whereNotNull('reviewed_at')
            ->orderBy('reviewed_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentReviews as $review) {
            $activities->push([
                'type' => 'document_reviewed',
                'message' => "Document {$review->document->document_number} was reviewed by {$review->reviewer->name}",
                'date' => $review->reviewed_at,
                'icon' => 'check-circle',
                'color' => 'green'
            ]);
        }

        return $activities->sortByDesc('date')->take(10)->values();
    }

    /**
     * Get overdue documents alert.
     */
    private function getOverdueDocuments()
    {
        return Document::overdue()
            ->with('latestReviewer')
            ->orderBy('target_date', 'asc')
            ->limit(5)
            ->get();
    }

    /**
     * Get unread notification count for current user.
     */
    public function getUnreadNotificationCount()
    {
        return response()->json([
            'count' => auth()->user()->notifications()->unread()->count()
        ]);
    }
}
