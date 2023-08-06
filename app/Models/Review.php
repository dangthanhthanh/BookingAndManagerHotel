<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Review extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'reviews';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'customer_id',
        'rate',
        'name',
        'script',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Define the slug options for the 'slug' column
    public function getSlugOptions(): SlugOptions
    {
        $separator = '%+%'; 

        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
