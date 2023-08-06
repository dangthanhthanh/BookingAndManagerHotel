<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries'; //table_name
    public $timestamps = true;
    protected $fillable = [ // Define the columns that can be mass-assigned
        'image_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
