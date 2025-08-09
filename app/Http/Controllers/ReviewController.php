<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentReview;
use App\Models\Document;
use App\Models\Notification;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for current user.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isReviewer()) {
            $reviews = DocumentReview::with(['document', 'reviewer'])
                ->where('reviewer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $reviews = DocumentReview::with(['document', 'reviewer'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Document $document)
    {
        // Check if user is authorized to review this document
        if (!auth()->user()->isReviewer() && $document->latest_reviewer_id !== auth()->id()) {
            abort(403, 'Unauthorized to review this document.');
        }

        return view('reviews.create', compact('document'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:NS,IFR,RIFR,IFA,RIFA,IFC,RIFC,IFI',
            'revision' => 'required|string',
            'comment' => 'required|in:Approved,App. As Noted,Not Approved',
            'review_notes' => 'nullable|string',
        ]);

        // Create the review
        $review = DocumentReview::create([
            'document_id' => $document->id,
            'reviewer_id' => auth()->id(),
            'status' => $request->status,
            'revision' => $request->revision,
            'comment' => $request->comment,
            'review_notes' => $request->review_notes,
            'reviewed_at' => now(),
        ]);

        // Update document status and revision
        $document->update([
            'status' => $request->status,
            'revision' => $request->revision,
        ]);

        // Create notification for document controllers
        $documentControllers = \App\Models\User::where('role', 'document_controller')->get();
        foreach ($documentControllers as $controller) {
            Notification::create([
                'user_id' => $controller->id,
                'title' => 'Document Review Completed',
                'message' => "Document {$document->document_number} has been reviewed by " . auth()->user()->name . " with comment: {$request->comment}",
                'type' => 'review'
            ]);
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Review submitted successfully.');
    }

    /**
     * Display the specified review.
     */
    public function show(DocumentReview $review)
    {
        $review->load(['document', 'reviewer']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show pending reviews for current user.
     */
    public function pending()
    {
        $pendingDocuments = Document::where('latest_reviewer_id', auth()->id())
            ->whereNotIn('status', ['IFC', 'IFI'])
            ->with('reviews')
            ->orderBy('target_date', 'asc')
            ->paginate(15);

        return view('reviews.pending', compact('pendingDocuments'));
    }

    /**
     * Update existing review.
     */
    public function update(Request $request, DocumentReview $review)
    {
        // Check authorization
        if ($review->reviewer_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized to update this review.');
        }

        $request->validate([
            'status' => 'required|in:NS,IFR,RIFR,IFA,RIFA,IFC,RIFC,IFI',
            'revision' => 'required|string',
            'comment' => 'required|in:Approved,App. As Noted,Not Approved',
            'review_notes' => 'nullable|string',
        ]);

        $review->update($request->all());

        // Update document status if this is the latest review
        $latestReview = $review->document->reviews()->latest()->first();
        if ($latestReview->id === $review->id) {
            $review->document->update([
                'status' => $request->status,
                'revision' => $request->revision,
            ]);
        }

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Review updated successfully.');
    }
}
