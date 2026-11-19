<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = ['user_id', 'course_id', 'certificate_no', 'verification_code', 'issued_at', 'issued_by', 'status', 'pdf_path'];

    protected $casts = ['issued_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function hasUploadedPdf(): bool
    {
        return filled($this->pdf_path) && is_file(public_path($this->pdf_path));
    }

    public function pdfPublicPath(): ?string
    {
        return $this->hasUploadedPdf() ? public_path($this->pdf_path) : null;
    }
}
