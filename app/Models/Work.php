<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
        'url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function localized(string $field, string $locale = 'ar'): string
    {
        return $this->{$field}[$locale] ?? $this->{$field}['ar'] ?? '';
    }
}
