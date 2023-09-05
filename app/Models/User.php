<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'slug',
        'provider_name',
        'provider_id',
        'avatar_id',
        'user_name',
        'password',
        'gender',
        'email',
        'cccd',
        'phone',
        'active',
        'address',
    ];

    protected $dates = ['deleted_at']; // date
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'cccd',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];
    public function avatar()
    {
        return $this->belongsTo(Image::class, 'avatar_id');
    }

    public function roleLists()
    {
        return $this->hasMany(RoleList::class, 'staff_id');
    }

    public function isManager()
    {
        return $this->roles->contains('name', 'manager');
    }

    public function isBloger()
    {
        return $this->roles->contains('name', 'bloger');
    }

    public function isCashier()
    {
        return $this->roles->contains('name', 'cashier');
    }

    public function isCustomer()
    {
        return $this->roles->isEmpty();;
    }

    public function isStaff()
    {
        return $this->roles->contains('name', 'staff');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'customer_id', 'order_id');
    }

    //slugable
    public function getSlugOptions(): SlugOptions
    {
        $hashUserId = md5($this->id.$this->user_name ?? 'none user name'); 
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($hashUserId);
    }
}
