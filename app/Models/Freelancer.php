<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $primaryKey='user_id';
    protected $casts=['birthday'=>'date'];

    protected $fillable=['first_name','last_name','gender','description','country','birthday',
    'title','hourly_rate','profile_photo_path'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
