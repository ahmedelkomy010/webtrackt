<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'question' => 'array',
            'answer' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function localized(string $field, string $locale = 'ar'): string
    {
        return $this->{$field}[$locale] ?? $this->{$field}['ar'] ?? '';
    }
}
