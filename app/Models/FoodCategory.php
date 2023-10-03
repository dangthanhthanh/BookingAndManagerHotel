<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FoodCategory extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'food_categories';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'name',
    ];

    protected $dates = ['deleted_at'];
    
    public function food()
    {
        return $this->hasMany(Food::class, 'category_id', 'id');
    }
    // Define the slug options for the 'slug' column
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
}
