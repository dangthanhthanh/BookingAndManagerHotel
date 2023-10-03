<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class BookingFood extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'booking_food';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'order_id',
        'food_id',
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

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->order_id.$this->food_id.$this->id);
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($idHash);
    }
}
