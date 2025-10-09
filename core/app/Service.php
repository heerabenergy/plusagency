<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Service extends Model
{
  public $timestamps = false;

  public function scategory() : BelongsTo
  {
      return $this->belongsTo(Scategory::class);
  }

  public function portfolios() : HasMany
  {
    return $this->hasMany(Portfolio::class);
  }

  public function language() : BelongsTo
  {
    return $this->belongsTo(Language::class);
  }

  public function inputs() : HasMany
  {
    return $this->hasMany(ServiceInput::class);
  }
  public function requests() : HasMany{
    return $this->hasMany(ServiceRequest::class);
  }
}
