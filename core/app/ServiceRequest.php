<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = ['fname', 'lname', 'username','user_id', 'email', 'fields', 'status', 'mobile','user_agent','ip_address'];
}