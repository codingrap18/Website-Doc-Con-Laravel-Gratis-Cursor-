<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the documents assigned to the user for review.
     */
    public function reviewDocuments()
    {
        return $this->hasMany(Document::class, 'latest_reviewer_id');
    }

    /**
     * Get the document reviews submitted by the user.
     */
    public function documentReviews()
    {
        return $this->hasMany(DocumentReview::class, 'reviewer_id');
    }

    /**
     * Get the transmittal letters created by the user.
     */
    public function transmittalLetters()
    {
        return $this->hasMany(TransmittalLetter::class, 'created_by');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is document controller.
     */
    public function isDocumentController(): bool
    {
        return $this->hasRole('document_controller');
    }

    /**
     * Check if user is reviewer.
     */
    public function isReviewer(): bool
    {
        return $this->hasRole('reviewer');
    }
}
