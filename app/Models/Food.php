<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Food extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'food'; //table_name
    public $incrementing = false;//off autoincrement
    
    public $timestamps = true;

    
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
        'short_description',
        'description',
        'cost',
        'image_id',
        'category_id',
        'active',
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

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id');
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
