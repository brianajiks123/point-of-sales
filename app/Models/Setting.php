<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'address',
        'phone',
        'note_type',
        'path_logo',
        'path_card_member',
    ];
}
