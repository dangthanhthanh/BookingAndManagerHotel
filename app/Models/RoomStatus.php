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

    protected $primaryKey = 'slug'; // Set the primary key column of the table
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
    ];
    protected $dates = ['deleted_at']; // date
    
    // Define Slug configuration
    public function getSlugOptions(): SlugOptions
    {
        $separator = '%+%'; // Phân tách trong slug

        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
