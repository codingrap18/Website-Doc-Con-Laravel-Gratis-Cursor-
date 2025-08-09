<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransmittalLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'transmittal_number',
        'date',
        'vendor_name',
        'description',
        'document_ids',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'document_ids' => 'array',
        ];
    }

    /**
     * Get the user who created the transmittal letter.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the documents included in this transmittal letter.
     */
    public function documents()
    {
        return Document::whereIn('id', $this->document_ids ?? []);
    }

    /**
     * Generate next transmittal number.
     */
    public static function generateTransmittalNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');

        $prefix = "TL-{$year}{$month}-";

        $lastTransmittal = static::where('transmittal_number', 'like', $prefix . '%')
            ->orderBy('transmittal_number', 'desc')
            ->first();

        if ($lastTransmittal) {
            $lastNumber = (int) substr($lastTransmittal->transmittal_number, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get total number of documents in this transmittal.
     */
    public function getDocumentCount(): int
    {
        return count($this->document_ids ?? []);
    }

    /**
     * Add document to transmittal.
     */
    public function addDocument(int $documentId): void
    {
        $documentIds = $this->document_ids ?? [];
        if (!in_array($documentId, $documentIds)) {
            $documentIds[] = $documentId;
            $this->update(['document_ids' => $documentIds]);
        }
    }

    /**
     * Remove document from transmittal.
     */
    public function removeDocument(int $documentId): void
    {
        $documentIds = $this->document_ids ?? [];
        $documentIds = array_filter($documentIds, fn($id) => $id !== $documentId);
        $this->update(['document_ids' => array_values($documentIds)]);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to search by vendor name.
     */
    public function scopeVendorName($query, $vendorName)
    {
        return $query->where('vendor_name', 'like', "%{$vendorName}%");
    }
}
