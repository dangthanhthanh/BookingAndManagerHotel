<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class NewsEmail extends Model
{
    use HasFactory;

    protected $table = 'news_emails';// Set the table name for the model
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'id',
        'email',
        'email_verified_token',
        'email_verified_at',
    ];
}
