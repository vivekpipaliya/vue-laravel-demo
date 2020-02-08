<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'zip_code',
        'document'
    ];
}
