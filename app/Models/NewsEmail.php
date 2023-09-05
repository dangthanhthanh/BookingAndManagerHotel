<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;
class NewsEmail extends Model
{
    use HasFactory,HasSlug;

    protected $table = 'news_emails';// Set the table name for the model
    public $timestamps = true;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'email',
        'hash_token',
        'email_verified_at',
    ];
    public function getSlugOptions(): SlugOptions

    {
        $separator = '%+%'; 
        $idHash = Str::slug(hash('md5', $this->id));
        return SlugOptions::create()
            ->generateSlugsFrom($idHash)
            ->saveSlugsTo('slug')
            ->usingSeparator($separator);
    }
}
