<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class BookingRoom extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'booking_rooms';// Set the table name for the model
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'id',
        'slug',
        'order_id',
        'room_id',
        'room_status_id',
        'check_in',
        'check_out',
        'number_per',
        'cost',
        'ratio',
        'cus_request',
        'note',
    ];
    protected $dates = [
        'check_in',
        'check_out',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    public function status()
    {
        return $this->hasOne(RoomStatus::class, 'id', 'room_status_id');
    }
    
    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->order_id.$this->room_id.$this->id);
        return SlugOptions::create()
        ->saveSlugsTo('slug')
        ->usingSeparator($idHash);
    }
}
