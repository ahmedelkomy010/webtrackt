<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'company',
        'rating',
        'comment',
        'is_approved',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'comment' => 'array',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function localizedComment(string $locale = 'ar'): string
    {
        $data = $this->comment ?? [];

        return $data[$locale] ?? $data['ar'] ?? $data['en'] ?? '';
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
