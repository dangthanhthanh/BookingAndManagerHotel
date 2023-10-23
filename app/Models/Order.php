<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    protected $table = 'orders'; //table_name
    public $timestamps = true;
    
    protected $fillable = [ // Define the columns that can be mass-assigned
        'id',
        'slug',
        'customer_id',
    ];

    protected $dates = ['deleted_at']; // date

    public function bookingRoom(){
        return $this->hasMany(BookingRoom::class, 'order_id');
    }
    public function bookingFood(){
        return $this->hasMany(BookingFood::class, 'order_id');
    }
    public function bookingService(){
        return $this->hasMany(BookingService::class, 'order_id');
    }
    public function bookingEvent(){
        return $this->hasMany(BookingEvent::class, 'order_id');
    }
    public function totalBalance(){
        $total = 0;
        foreach ($this->bookingRoom as $item){
            $total += $item->totalCost();
        };
        foreach ($this->bookingFood as $item){
            $total += $item->totalCost();
        };
        foreach ($this->bookingService as $item){
            $total += $item->totalCost();
        };
        return $total;
    }
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class, 'order_id');
    }
    public function payment(){
        return $this->payments()->orderByDesc('created_at')->first();
    }
    public function status() : string
    {
        $lastPayment = $this->payment();
        return $lastPayment ? $lastPayment->status->name : 'unpaid';
    }
    // Define Slug configuration
    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->customer_id.$this->id);
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($idHash);
    }
}
