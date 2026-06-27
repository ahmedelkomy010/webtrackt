<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUsItem extends Model
{
    protected $fillable = [
        'title',
        'description',
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
        $data = $this->{$field};

        return $data[$locale] ?? $data['ar'] ?? '';
    }
}
