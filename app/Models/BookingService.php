<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class BookingService extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'booking_services';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'order_id',
        'service_id',
        'check_in',
        'cost',
        'ratio',
        'qty',
        'note',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function totalCost()
    {
        return $this->cost * $this->ratio * $this->qty;
    }

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'room_status_id');
    }
    
    // Define the slug options for the 'slug' column
    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->order_id.$this->service_id.$this->id);
        return SlugOptions::create()
        ->saveSlugsTo('slug')
        ->usingSeparator($idHash);
    }
}
