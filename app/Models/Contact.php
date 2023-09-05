<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;
class Contact extends Model
{
    use HasFactory,HasSlug;
    protected $table = 'contacts'; //table_name

    public $timestamps = true;
    protected $fillable = [ // Define the columns that can be mass-assigned
        'name',
        'email',
        'phone',
        'messenger',
        'note',
        'status_id',
        'status_history',
    ];

    public function status(){
        return $this->belongsTo(StatusContact::class,'status_id');
    }

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
