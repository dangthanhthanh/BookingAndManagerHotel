<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Role extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $table = 'roles';// Set the table name for the model
    protected $primaryKey = 'id'; // Set the primary key column of the table
    public $timestamps = false;
    protected $fillable = [// Define the columns that can be mass-assigned
        'slug',
        'name',
    ];
    protected $dates = ['deleted_at']; // date
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function staff()
    {
        return $this->hasMany(RoleList::class, 'role_id', 'id');
    }
    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->name.$this->id);
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($idHash);
    }
}
