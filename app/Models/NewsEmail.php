<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEmail extends Model
{
    use HasFactory;

    protected $table = 'news_emails';// Set the table name for the model
    protected $primaryKey = 'email'; // Set the primary key column of the table
    public $incrementing = false;//off autoincrement
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'email',
        'hash_token',
        'verificated_at',
        'sent',
    ];
    protected $casts = [ // convert data type
        'sent' => 'boolean',
    ];
}
