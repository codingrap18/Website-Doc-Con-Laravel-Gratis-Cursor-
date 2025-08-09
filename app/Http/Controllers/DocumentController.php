<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\DocumentReview;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents with filtering.
     */
    public function index(Request $request)
    {
        $query = Document::with(['latestReviewer', 'reviews']);

        // Apply filters
        if ($request->filled('document_number')) {
            $query->documentNumber($request->document_number);
        }

        if ($request->filled('document_title')) {
            $query->documentTitle($request->document_title);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->status($request->status);
        }

        if ($request->filled('revision')) {
            $query->where('revision', $request->revision);
        }

        if ($request->filled('reviewer_id') && $request->reviewer_id !== 'all') {
            $query->where('latest_reviewer_id', $request->reviewer_id);
        }

        if ($request->filled('document_position')) {
            $query->where('document_position', 'like', "%{$request->document_position}%");
        }

        if ($request->filled('submission_date_from')) {
            $query->where('submission_date', '>=', $request->submission_date_from);
        }

        if ($request->filled('submission_date_to')) {
            $query->where('submission_date', '<=', $request->submission_date_to);
        }

        if ($request->boolean('overdue_only')) {
            $query->overdue();
        }

        // Apply sorting
        $sortField = $request->get('sort', 'submission_date');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $documents = $query->paginate(15)->withQueryString();

        // Get filter options
        $reviewers = User::where('role', 'reviewer')->get();
        $statuses = [
            'NS' => 'Not Submitted',
            'IFR' => 'Issued for Review',
            'RIFR' => 'Re-Issued for Review',
            'IFA' => 'Issued for Approval',
            'RIFA' => 'Re-Issued for Approval',
            'IFC' => 'Issued for Construction',
            'RIFC' => 'Re-Issued for Construction',
            'IFI' => 'Issued for Information',
        ];

        return view('documents.index', compact('documents', 'reviewers', 'statuses'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        $reviewers = User::where('role', 'reviewer')->get();
        $statuses = [
            'NS' => 'Not Submitted',
            'IFR' => 'Issued for Review',
            'RIFR' => 'Re-Issued for Review',
            'IFA' => 'Issued for Approval',
            'RIFA' => 'Re-Issued for Approval',
            'IFC' => 'Issued for Construction',
            'RIFC' => 'Re-Issued for Construction',
            'IFI' => 'Issued for Information',
        ];

        return view('documents.create', compact('reviewers', 'statuses'));
    }

    /**
     * Store a newly created document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_number' => 'required|string|unique:documents',
            'document_title' => 'required|string|max:255',
            'revision' => 'required|string',
            'status' => 'required|in:NS,IFR,RIFR,IFA,RIFA,IFC,RIFC,IFI',
            'submission_date' => 'nullable|date',
            'latest_reviewer_id' => 'nullable|exists:users,id',
            'document_position' => 'nullable|string',
        ]);

        $document = Document::create($request->all());

        // Calculate target date if submission date is provided
        if ($document->submission_date) {
            $document->calculateTargetDate();
            $document->save();
        }

        // Create notification for assigned reviewer
        if ($document->latest_reviewer_id) {
            Notification::create([
                'user_id' => $document->latest_reviewer_id,
                'title' => 'New Document Assignment',
                'message' => "Document {$document->document_number} has been assigned to you for review.",
                'type' => 'review'
            ]);
        }

        return redirect()->route('documents.index')
            ->with('success', 'Document created successfully.');
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        $document->load(['latestReviewer', 'reviews.reviewer']);
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the document.
     */
    public function edit(Document $document)
    {
        $reviewers = User::where('role', 'reviewer')->get();
        $statuses = [
            'NS' => 'Not Submitted',
            'IFR' => 'Issued for Review',
            'RIFR' => 'Re-Issued for Review',
            'IFA' => 'Issued for Approval',
            'RIFA' => 'Re-Issued for Approval',
            'IFC' => 'Issued for Construction',
            'RIFC' => 'Re-Issued for Construction',
            'IFI' => 'Issued for Information',
        ];

        return view('documents.edit', compact('document', 'reviewers', 'statuses'));
    }

    /**
     * Update the specified document.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_number' => 'required|string|unique:documents,document_number,' . $document->id,
            'document_title' => 'required|string|max:255',
            'revision' => 'required|string',
            'status' => 'required|in:NS,IFR,RIFR,IFA,RIFA,IFC,RIFC,IFI',
            'submission_date' => 'nullable|date',
            'latest_reviewer_id' => 'nullable|exists:users,id',
            'document_position' => 'nullable|string',
        ]);

        $oldReviewerId = $document->latest_reviewer_id;
        $document->update($request->all());

        // Recalculate target date if submission date changed
        if ($document->submission_date) {
            $document->calculateTargetDate();
            $document->save();
        }

        // Notify new reviewer if changed
        if ($document->latest_reviewer_id && $document->latest_reviewer_id !== $oldReviewerId) {
            Notification::create([
                'user_id' => $document->latest_reviewer_id,
                'title' => 'Document Assignment Update',
                'message' => "Document {$document->document_number} has been assigned to you for review.",
                'type' => 'review'
            ]);
        }

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    /**
     * Bulk update documents.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'document_ids' => 'required|array',
            'action' => 'required|in:update_status,assign_reviewer',
            'status' => 'nullable|in:NS,IFR,RIFR,IFA,RIFA,IFC,RIFC,IFI',
            'reviewer_id' => 'nullable|exists:users,id',
        ]);

        $documents = Document::whereIn('id', $request->document_ids);

        if ($request->action === 'update_status' && $request->status) {
            $documents->update(['status' => $request->status]);
            $message = 'Documents status updated successfully.';
        } elseif ($request->action === 'assign_reviewer' && $request->reviewer_id) {
            $documents->update(['latest_reviewer_id' => $request->reviewer_id]);

            // Create notifications for assigned reviewer
            $reviewer = User::find($request->reviewer_id);
            $documentNumbers = Document::whereIn('id', $request->document_ids)->pluck('document_number');

            Notification::create([
                'user_id' => $request->reviewer_id,
                'title' => 'Multiple Document Assignment',
                'message' => "You have been assigned to review documents: " . $documentNumbers->implode(', '),
                'type' => 'review'
            ]);

            $message = 'Documents assigned successfully.';
        }

        return redirect()->route('documents.index')
            ->with('success', $message ?? 'Bulk action completed.');
    }

    /**
     * Export documents to Excel.
     */
    public function exportExcel(Request $request)
    {
        // Apply same filters as index
        $query = Document::with(['latestReviewer', 'reviews']);

        // Apply all filters from request (same as index method)
        // ... (filter logic would be same as index method)

        $documents = $query->get();

        // Here you would use Laravel Excel to export
        // For now, returning a simple CSV response
        $filename = 'documents-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($documents) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Document Number',
                'Document Title',
                'Revision',
                'Status',
                'Submission Date',
                'Target Date',
                'Latest Reviewer',
                'Document Position',
                'Days Overdue',
            ]);

            foreach ($documents as $document) {
                fputcsv($file, [
                    $document->document_number,
                    $document->document_title,
                    $document->revision,
                    $document->getStatusDescription(),
                    $document->submission_date?->format('Y-m-d'),
                    $document->target_date?->format('Y-m-d'),
                    $document->latestReviewer?->name,
                    $document->document_position,
                    $document->isOverdue() ? $document->getDaysOverdue() : 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export documents to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Document::with(['latestReviewer', 'reviews']);

        // Apply filters (same logic as index)
        // ...

        $documents = $query->get();

        $pdf = PDF::loadView('documents.pdf-export', compact('documents'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('documents-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }
}
