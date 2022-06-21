<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail //when the person make register >>send to him verification email
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
    ];

    #User has one freelancer Profile
    public function freelancer(){
        return $this->hasOne(Freelancer::class,'user_id','id')
        ->withDefault(); //عشان لو يوزر معندهوش بروفايل ميعملش ايرور
    }

    #Every user has many projects
    public function projects(){
        return $this->hasMany(Project::class,'user_id','id');
    }

    //Accessor Method
    //$user->profile_photo_url
    public function getProfilePhotoUrlAttribute(){
        if($this->freelancer->profile_photo_path){
            return asset('profile/'.$this->freelancer->profile_photo_path);
        }
        return asset('profile/default.jpeg');
    }

    //$this->name
    public function getNameAttribute($value){
        return Str::title($value);
        // return ucfirst($this->attributes['name']);
    }

    //Mutators
    public function setNameAttribute($value){
        $this->attributes['name']=Str::upper($value);
        //هتتخزن في الداتا بيز ان الاسم كله كابيتال 
    }
}
