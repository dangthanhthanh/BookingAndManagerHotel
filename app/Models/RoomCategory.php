<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RoomCategory extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'room_categories'; //table_name
    public $timestamps = true;
    protected $fillable = [ // Define the columns that can be mass-assigned
        'id',
        'slug',
        'name',
        'image_id',
        'short_description',
        'description',
        'cost',
        'image_id',
    ];

    protected $casts = [ // convert data type
        'active' => 'boolean',
    ];

    protected $dates = ['deleted_at']; // date

    // configuration definition
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function room()//state
    {
        return $this->hasMany(Room::class, 'category_id', 'id');
    }

    public function availableRooms($start, $end){
        return $this->room()->get()->filter(function ($room) use ($start, $end) {
            return $room->isAvailable($start, $end);
        });
    }
    public function countAvailable($start, $end)
    {
        return $this->availableRooms($start, $end)->count();
    }
    // Define Slug configuration
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
}
