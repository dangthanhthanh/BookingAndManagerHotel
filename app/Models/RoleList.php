<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleList extends Model
{
    use HasFactory;

    protected $table = 'role_lists';// Set the table name for the model
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'user_id',
        'role_id',
        'created_at',
    ];
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function role()
    {
        return $this->belongsTo(role::class, 'role_id');
    }
}
