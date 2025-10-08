<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PackageInputOption extends Model
{
    protected $fillable = ['type', 'label', 'name', 'placeholder', 'required'];

    public function package_input() : BelongsTo
    {
        return $this->belongsTo(PackageInput::class);
    }
}
