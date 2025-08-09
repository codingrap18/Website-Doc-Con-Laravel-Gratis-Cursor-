<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'reviewer_id',
        'status',
        'revision',
        'comment',
        'review_notes',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Get the document that owns the review.
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the reviewer that owns the review.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Mark the review as completed.
     */
    public function markAsReviewed()
    {
        $this->update(['reviewed_at' => now()]);
    }

    /**
     * Check if the review is completed.
     */
    public function isReviewed(): bool
    {
        return !is_null($this->reviewed_at);
    }

    /**
     * Get comment description with color coding.
     */
    public function getCommentClass(): string
    {
        return match($this->comment) {
            'Approved' => 'text-green-600 bg-green-100',
            'App. As Noted' => 'text-yellow-600 bg-yellow-100',
            'Not Approved' => 'text-red-600 bg-red-100',
            default => 'text-gray-600 bg-gray-100',
        };
    }

    /**
     * Scope to get reviews by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get reviews by comment.
     */
    public function scopeComment($query, $comment)
    {
        return $query->where('comment', $comment);
    }

    /**
     * Scope to get pending reviews.
     */
    public function scopePending($query)
    {
        return $query->whereNull('reviewed_at');
    }

    /**
     * Scope to get completed reviews.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('reviewed_at');
    }
}
