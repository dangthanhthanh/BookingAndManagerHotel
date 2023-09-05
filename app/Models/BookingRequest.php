<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class BookingRequest extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'booking_requests';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'customer_id',
        'room_category_id',
        'check_out',
        'check_in',
        'num_person',
        'num_child',
        'request',
        'note',
        'status_history',//json
        'status_id',//id forien_key
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'check_in',
        'check_out',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function status(){
        return $this->belongsTo(StatusContact::class,'status_id');
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }

    public function getSlugOptions(): SlugOptions

    {
        $separator = '%+%'; 
        $idHash = Str::slug(hash('md5', $this->id));
        return SlugOptions::create()
            ->generateSlugsFrom($idHash)
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
