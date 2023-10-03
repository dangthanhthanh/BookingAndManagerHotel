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

    protected $primaryKey = 'slug'; // Set the primary key column of the table

    protected $keyType = 'string';// Define the columns that can be mass-assigned

    public $incrementing = false;//off autoincrement
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'customer_id',
        'rate',
        'title',
        'description',
        'active',
    ];

    protected $casts = [ // convert data type
        'active' => 'boolean',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
}
