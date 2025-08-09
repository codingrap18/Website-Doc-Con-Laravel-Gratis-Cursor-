<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'document_title',
        'revision',
        'status',
        'submission_date',
        'target_date',
        'latest_reviewer_id',
        'submit_to_reviewer_date',
        'document_position',
    ];

    protected function casts(): array
    {
        return [
            'submission_date' => 'datetime',
            'target_date' => 'datetime',
            'submit_to_reviewer_date' => 'datetime',
        ];
    }

    /**
     * Get the latest reviewer assigned to the document.
     */
    public function latestReviewer()
    {
        return $this->belongsTo(User::class, 'latest_reviewer_id');
    }

    /**
     * Get all reviews for the document.
     */
    public function reviews()
    {
        return $this->hasMany(DocumentReview::class);
    }

    /**
     * Calculate and set target date (submission_date + 5 working days).
     */
    public function calculateTargetDate()
    {
        if ($this->submission_date) {
            $this->target_date = $this->addWorkingDays($this->submission_date, 5);
        }
    }

    /**
     * Add working days to a date (excluding weekends).
     */
    public function addWorkingDays(Carbon $date, int $days): Carbon
    {
        $targetDate = $date->copy();
        $addedDays = 0;

        while ($addedDays < $days) {
            $targetDate->addDay();
            if ($targetDate->isWeekday()) {
                $addedDays++;
            }
        }

        return $targetDate;
    }

    /**
     * Check if document is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->target_date &&
               now()->gt($this->target_date) &&
               !in_array($this->status, ['IFC', 'IFI']);
    }

    /**
     * Get days overdue (working days only).
     */
    public function getDaysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $workingDays = 0;
        $current = $this->target_date->copy();

        while ($current->lt(now())) {
            $current->addDay();
            if ($current->isWeekday()) {
                $workingDays++;
            }
        }

        return $workingDays;
    }

    /**
     * Get status description.
     */
    public function getStatusDescription(): string
    {
        return match($this->status) {
            'NS' => 'Not Submitted Yet',
            'IFR' => 'Issued for Review',
            'RIFR' => 'Re-Issued for Review',
            'IFA' => 'Issued for Approval',
            'RIFA' => 'Re-Issued for Approval',
            'IFC' => 'Issued for Construction',
            'RIFC' => 'Re-Issued for Construction',
            'IFI' => 'Issued for Information',
            default => $this->status,
        };
    }

    /**
     * Get the expected revision for the status.
     */
    public function getExpectedRevision(): string
    {
        return match($this->status) {
            'NS' => 'NS',
            'IFR' => 'A',
            'RIFR' => 'A1, A2, A3...',
            'IFA' => 'B',
            'RIFA' => 'C, D, E...',
            'IFC' => '0',
            'RIFC' => 'A',
            'IFI' => 'Information',
            default => $this->revision,
        };
    }

    /**
     * Scope to get overdue documents.
     */
    public function scopeOverdue($query)
    {
        return $query->where('target_date', '<', now())
                    ->whereNotIn('status', ['IFC', 'IFI']);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to search by document number.
     */
    public function scopeDocumentNumber($query, $number)
    {
        return $query->where('document_number', 'like', "%{$number}%");
    }

    /**
     * Scope to search by document title.
     */
    public function scopeDocumentTitle($query, $title)
    {
        return $query->where('document_title', 'like', "%{$title}%");
    }
}
