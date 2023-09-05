<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusContact extends Model
{
    use HasFactory;
    protected $table = 'status_contacts';
    protected $fillable = [ // Define the columns that can be mass-assigned
        'name',
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class, 'status_id', 'id');
    }
    public function bookingRequest()
    {
        return $this->hasMany(BookingRequest::class, 'status_id', 'id');
    }
}
