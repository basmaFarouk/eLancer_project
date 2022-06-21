<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    const TYPE_FIXED='fixed';
    const TYPE_HOURLY='hourly';
    protected $fillable=['title','category_id','user_id','description','budget','status','type','attachments'];
    protected $casts=[
        'budget'=>'float',
        'attachments'=>'json',
    ];

    //projects belongs to one user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

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

    public static function types(){
        return [
            self::TYPE_FIXED=>'Fixed',
            self::TYPE_HOURLY=>'Hourly',
        ];
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
