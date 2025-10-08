<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PackageInput extends Model
{
    protected $fillable = ['language_id', 'type', 'label', 'name', 'placeholder', 'required', 'active'];

    public function input_options() : HasMany
    {
        return $this->hasMany(PackageInputOption::class);
    }

    public function language() : BelongsTo
    {
      return $this->belongsTo(Language::class);
    }
}
