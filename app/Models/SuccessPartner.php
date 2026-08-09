<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuccessPartner extends Model
{
    protected $fillable = [
        'logo',
        'name',
        'url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function localizedName(string $locale = 'ar'): string
    {
        return $this->name[$locale] ?? $this->name['ar'] ?? $this->name['en'] ?? '';
    }
}
