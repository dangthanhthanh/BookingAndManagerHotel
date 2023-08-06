<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'orders'; //table_name

    protected $primaryKey = 'slug'; // Set the primary key column of the table

    protected $keyType = 'string';// Define the columns that can be mass-assigned

    public $incrementing = false;//off autoincrement
    
    public $timestamps = true;

    
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'customer_id',
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
        $separator = '%+%'; 
        $idHash = $this->id ? Str::slug(hash('md5', $this->id)) : ''; // create slug from id
        return SlugOptions::create()
            ->generateSlugsFrom($idHash)
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
