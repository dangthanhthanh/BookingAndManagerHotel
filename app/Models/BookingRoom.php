<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class BookingRoom extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'booking_rooms';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'order_id',
        'room_id',
        'room_status_id',
        'number_per',
        'cost',
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
        return $this->belongsTo(Room::class, 'food_id');
    }

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'room_status_id');
    }
    
    // Define the slug options for the 'slug' column
    public function getSlugOptions(): SlugOptions
    {
        $separator = '%+%'; 
        $idHash = $this->id ? Str::slug(hash('md5', $this->id)) : ''; // create slug from id
        return SlugOptions::create()
            ->generateSlugsFrom($idHash)
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
