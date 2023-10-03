<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts'; //table_name

    public $timestamps = true;
    protected $fillable = [ // Define the columns that can be mass-assigned
        'id',
        'name',
        'email',
        'subject',
        'messenger',
        'email_verified_at',
        'email_verified_token',
    ];
}
