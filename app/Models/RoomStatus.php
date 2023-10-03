<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RoomStatus extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'room_statuses'; //table_name

    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
    ];
    protected $dates = ['deleted_at']; // date
    public function room()
    {
        return $this->hasMany(BookingRoom::class, 'room_status_id', 'id');
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
