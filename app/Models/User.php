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
        'email_verified_token',
        'email_verified_at',
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
        return $this->hasOne(Image::class, 'id','avatar_id');
    }

    public function roleLists()
    {
        return $this->hasMany(RoleList::class, 'user_id');
    }

    public function roles()
    {
        return $this->roleLists->pluck('role_id')->toArray();
    }

    public function checkRole(string $role){
        $id = Role::where('name',$role)->first()->id;
        if(in_array($id,$this->roles())){
            return true;
        }
        return false;
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->checkRole('manager');
    }
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isBloger()
    {
        return $this->checkRole('bloger');
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isCashier()
    {
        return $this->checkRole('cashier');
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->checkRole('customer');
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isStaff()
    {
        return $this->checkRole('staff');
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->checkRole('admin');
    }
     /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isVerificated()
    {
        return $this->email_verified_at !== null;
    }

    public function getSlugOptions(): SlugOptions
    {
        $idHash = hash('md5', $this->user_name.$this->id);
        return SlugOptions::create()
            ->saveSlugsTo('slug')
            ->usingSeparator($idHash);
    }
}
