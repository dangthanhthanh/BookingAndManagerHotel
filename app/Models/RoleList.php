<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleList extends Model
{
    use HasFactory;

    protected $table = 'role_lists';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'customer_id',
        'role_id',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
