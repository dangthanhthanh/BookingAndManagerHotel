<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'orders'; //table_name

    protected $primaryKey = 'id'; // Set the primary key column of the table

    protected $keyType = 'string';// Define the columns that can be mass-assigned

    public $timestamps = true;
    
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'customer_id',
    ];

    protected $dates = ['deleted_at']; // date

    public function bookingRoom(){
        return $this->hasMany(BookingRoom::class, 'order_id');
    }
    public function bookingFood(){
        return $this->hasMany(BookingFood::class, 'order_id');
    }
    public function bookingService(){
        return $this->hasMany(BookingService::class, 'order_id');
    }

    // Define Slug configuration
    public function getSlugOptions(): SlugOptions
    {
        $hash = md5($this->customer_id.$this->id.'order'); 
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($hash);
    }
}
