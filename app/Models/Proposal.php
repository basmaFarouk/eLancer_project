<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=['freelancer_id','project_id','cost','description',
    'duration','duration_unit','status'];

    public function freelancer(){
        return $this->belongsTo(User::class,'freelancer_id','id');
    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function contract(){
        return  $this->hasOne(Contract::class,'proposal_id','id')->withDefault();
    }



    public static function units(){
        return [
            'day'=>'Day',
            'week'=>'Week',
            'month'=>'Month',
            'year'=>'Year'
        ];
    }
}
