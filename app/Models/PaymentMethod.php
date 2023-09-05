<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PaymentMethod extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'payment_methods';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'name',
    ];
    public function payment()
    {
        return $this->hasMany(Payment::class, 'payment_method_id', 'id');
    }
    // Define the slug options for the 'slug' column
    public function getSlugOptions(): SlugOptions
    {
        $separator = '%+%'; 

        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
