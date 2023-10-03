<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'service_categories'; //table_name
    public $timestamps = false;
    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'name',
    ];
    protected $dates = ['deleted_at']; // date
    public function service()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
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
