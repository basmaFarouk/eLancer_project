<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable=['name','slug'];
    public $timestamps=false;

    public function users(){
        return $this->belongsToMany(
            User::class,
            'freelancer_skill',
            'skill_id',
            'user_id',
            'id',
            'id',
        );
    }
}
