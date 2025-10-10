<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ServiceInput extends Model
{
    protected $fillable = ['service_id', 'type', 'label', 'name', 'placeholder', 'required', 'active', 'order'];

    public function input_options() : HasMany
    {
        return $this->hasMany(ServiceInputOption::class);
    }

    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
