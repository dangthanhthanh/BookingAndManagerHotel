<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Room extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'rooms'; //table_name
    public $timestamps = true;

    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
        'image_id',
        'category_id',
        'cost',
        'bed',
        'capacity',
        'description',
        'active'
    ];

    protected $casts = [ // convert data type
        'active' => 'boolean',
    ];

    protected $dates = ['deleted_at']; // date

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function booking(){
        return $this->hasMany(BookingRoom::class);
    }

    public function isAvailable($start, $end)
    {   
        $bookingOverlap = $this->booking()
            ->where(function ($query) use ($start,$end){
                $query->where(function ($query) use ($start, $end) {
                    $query->whereBetween('check_in', [$start, $end])
                    ->orWhereBetween('check_out', [$start, $end]);
                })
                ->orWhere(function ($query) use ($start, $end) {
                    $query->where('check_in', '<=', $start)
                    ->where('check_out', '>=', $end);
                });
            })
            ->exists();
        return !$bookingOverlap;
    }
    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
}
