<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'blogs'; //table_name

    protected $primaryKey = 'slug'; // Set the primary key column of the table

    protected $keyType = 'string';// Define the columns that can be mass-assigned

    public $incrementing = false;//off autoincrement
    
    public $timestamps = true;

    
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
        'image_id',
        'category_id',
        'short_description',
        'description',
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
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
    
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
