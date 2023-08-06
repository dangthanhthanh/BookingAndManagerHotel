<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'name',
        'address',
        'phone_number',
        'description',
    ];
}
