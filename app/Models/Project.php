<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    const TYPE_FIXED='fixed';
    const TYPE_HOURLY='hourly';
    protected $fillable=['title','category_id','user_id','description','budget','status','type','attachments','project_photo'];
    protected $casts=[
        'budget'=>'float',
        'attachments'=>'json',
    ];

    protected $appends=[
        'type_name'
    ];

    //projects belongs to one user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    //projects belongs to one category
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class, //Related Model
            'project_tag', //the name of the pivot table
            'project_id', //foregin key for current model in pivot table
            'tag_id', //forgein key بتاع الجدول الوسيط
            'id',    //Current Model Key (P.K)
            'id'     //Related Model Key (P.k. Reltaed Model)
        );
    }

    //Every Project has many proposals
    public function proposals(){
        return  $this->hasMany(Proposal::class);
    }

    //Every Project has many contracts
    public function contracts(){
        return  $this->hasMany(Contract::class);
    }

    public function proposedFreelnacers(){
        return $this->belongsToMany(User::class,
        'proposals', //الجدول الوسيط
        'project_id',
        'freelancer_id',
        'id',
        'id')->withPivot([
            'id','project_id','cost','description','duration','duration_unit','status'
        ]);
    }

    //Projects -> Contract(project_id) -> Freelancer(contract_id) (user) $this->hasOneThrough(User::class)
    public function contractedFreelancer(){
        return $this->belongsToMany(User::class,
        'contracts', //الجدول الوسيط
        'project_id',
        'freelancer_id',
        'id',
        'id')->withPivot([
            'proposal_id','cost','type','duration_unit','start_on','end_on','completed_on','hours','status'
        ]);
    }

    public static function types(){
        return [
            self::TYPE_FIXED=>'Fixed',
            self::TYPE_HOURLY=>'Hourly',
        ];
    }

    //$project->type_name for Api
    public function getTypeNameAttribute(){
        return ucfirst($this->type);
    }

    public function getProjectPhotoUrlAttribute(){
        if($this->project_photo){
            return asset('project/'.$this->project_photo);
        }
        return asset('project/project.png');
    }

    // public function getProjectPhotoAttribute($value){
    //     if($value){
    //         return asset('project/'.$value);
    //     }
    //     return asset('project/project.png');
    // }

    //Global Scope
    // protected static function booted()
    // {
    //     static::addGlobalScope('active',function(Builder $builder){

    //         $builder->where('status','open');
    //     });
    // }

    public function scopeFilter(Builder $builder ,$filters=[]){

        $filters=array_merge([
            'type'=>null,
            'status'=>null,
            'budget_min'=>null,  //$filters will make override above those
            'budget_max'=>null,
        ],$filters);

        if($filters['type']){
            $builder->where('type',$filters['type']);
        }

        $builder->when($filters['status'],function($builder,$value){
            $builder->where('status',$value);
        });

        $builder->when($filters['budget_min'],function($builder,$value){
            $builder->where('budget','>=',$value);
        });

        $builder->when($filters['budget_max'],function($builder,$value){
            $builder->where('budget','<=',$value);
        });
    }

    //Ordering By Budget
    public function scopeHigh(Builder $builder){
        $builder->orderBy('budget','desc');
    }

    //Scope Function
    public function scopeClosed(Builder $builder){
        $builder->where('status','closed');
    }

    //Scope Function
    public function scopeOpen(Builder $builder)
    {
        $builder->where('status', 'open');
    }
    //Scope Function
    public function scopeHourly(Builder $builder)
    {
        $builder->where('type', 'hourly');
    }

    public function syncTags(array $tags){
        $tags_id=[];
        foreach($tags as $tag_name){
           $tag = Tag::firstOrCreate([
            'slug'=>Str::slug($tag_name)
           ],[
            'name'=>$tag_name
           ]);
           $tags_id[]=$tag->id;
        }

        $this->tags()->sync($tags_id); //نفس القيم اللي في الاراي تبقى نفس القيم اللي في التابل
    }



}
