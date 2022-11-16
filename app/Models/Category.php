<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =['name','description','slug','parent_id'];
    protected $perPage = 2;

    protected $hidden=[  //For API
        'created_at','updated_at'
    ];

    #Every Category has many projects
    public function projects(){
        return $this->hasMany(Project::class,'category_id','id');
    }

    public function children(){
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id')
        ->withDefault(['name'=>'No Parent']);
    }

    public function getImagePhotoAttribute(){
        if($this->image){
            return asset('category/'.$this->image);
        }
        return asset('category/tasweeq.jpg');
    }

}
