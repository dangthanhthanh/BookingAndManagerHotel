<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Payment extends Model
{
    use HasFactory, HasSlug;
    protected $table = 'payments'; //table_name

    public $incrementing = false;//off autoincrement
    
    public $timestamps = true;

    protected $fillable = [ // Define the columns that can be mass-assigned
        'slug',
        'order_id',
        'payment_method_id',
        'payment_status_id',
    ];

    // configuration definition
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    
    // Define Slug configuration
    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->payment_method_id.$this->payment_status_id.$this->id);
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($idHash);
    }
}
