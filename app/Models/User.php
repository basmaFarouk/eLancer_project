<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

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
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'two_factor_secret',
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

    #Every user has many proposals
    public function proposals(){
        return $this->hasMany(Proposal::class,'freelancer_id','id');
    }

    #Every user has many contracts
    public function contracts(){
        return $this->hasMany(Contract::class,'freelancer_id','id');
    }

    //Many to Many between proposal projects and users
    public function proposedProjects(){
        return $this->belongsToMany(Project::class,
        'proposals', //الجدول الوسيط
        'freelancer_id',
        'project_id',
        'id',
        'id')->withPivot([
            'id','cost','description','duration','duration_unit','status'
        ]);
    }


    public function contractedProjects(){
        return $this->belongsToMany(Project::class,
        'contracts', //الجدول الوسيط
        'freelancer_id',
        'project_id',
        'id',
        'id')->withPivot([
            'proposal_id','cost','type','duration_unit','start_on','end_on','completed_on','hours','status'
        ]);
    }

    public function skills(){
        return $this->belongsToMany(
            Skill::class,
            'freelancer_skill',
            'user_id',
            'skill_id',
            'id',
            'id',
        );
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'role_user');
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

    // public function routeNotificationForMail($notification=null){
    //     return $this->email_address;
    // }

    public function routeNotificationForVonage($notification)
    {
        return $this->mobile_number;
    }

    public function routeNotificationForNepras(){
        return $this->mobile_number;
    }

    // public function receivesBroadcastNotificationsOn()
    // {
    //     return 'users.'.$this->id;
    // }


        /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'],$fcm_token=null)
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'fcm_token'=>$fcm_token,
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    //For Policies
    public function hasAbility($ability){

            foreach($this->roles ?? [] as $role){
                //if(in_array('categories.view',$role->abilities)){
                if(in_array($ability,$role->abilities)){
                    return true;
                }
            }
            //return false
            return true;

    }
}
