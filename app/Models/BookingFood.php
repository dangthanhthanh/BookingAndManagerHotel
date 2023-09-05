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
