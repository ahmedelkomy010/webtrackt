<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'value',
        'label',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'label' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function localizedLabel(string $locale = 'ar'): string
    {
        return $this->label[$locale] ?? $this->label['ar'] ?? '';
    }
}
