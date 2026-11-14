<?php

namespace App\Modules\Theme\Models;

use App\Core\Models\BaseUuidModel;

class Theme extends BaseUuidModel
{
    protected $fillable = [
        'name',
        'primary_color',
        'accent_color',
        'call_to_action',
        'print_size',
        'preview_image_url',
        'style_config',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'style_config' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
