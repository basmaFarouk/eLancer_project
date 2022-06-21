<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $rules =[
        'name'=>['required','string','min:3','filter',
        // function($attribute,$value,$fail){
        //     if($value=='god'){
        //         $fail('this word isnt allowed');
        //     }
        // }
    ],
        'parent_id' =>['nullable','int','exists:categories,id'],
        'description' =>['required','string'],
        'image'=>['nullable','image','mimes:png,jpg']

    ];
   protected $messages= [
        'name.required' => 'this  :attribute field is mandatory',
        'description.required' => 'description is required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data=DB::table('categories')->get();
        $data = Category::leftjoin('categories as parents','parents.id','=','categories.parent_id')
        ->select('categories.*','parents.name as parent_name')->paginate(3);
        // dd($data);
        return view('categories.index',["data"=>$data,'title'=>'Show']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data=Category::all();
        $category=new Category;
        return view('categories.create',['data'=>$data,'category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->rules(),$this->messages);
        // $validator = Validator::make($request->all(),$rules,$messages);
        // if($validator->fails()){
        //     //dd($validator->errors()); //بتطلعلي الايررور مسدج
        //     //dd($validator->failed()); //مش هتطلعلي الايرور مسدج ولكن هتطلعلي ايه الرول اللي سببت الايرور ده
        //     return redirect()->back()->withErrors($validator);
        // }

        //DB::table('categories')->insert([]);
        // $category = new Category;
        // $category->name=$request->name;
        // $category->description=$request->description;
        // $category->slug=Str::slug($request->name) ;
        // $category->parent_id=$request->parent_id;
        // $category->save();
        $request['slug']=Str::slug($request->name) ;
        $category =Category::create($request->all());
        // session()->flash('message','raw inserted');
       return redirect()->route('categories.index')->with('message','raw inserted');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category=DB::table('categories')->where('id',$id)->first();
        // dd($category);
        if($category==null){
            abort(404);
        }
        return view('categories.show',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        // $category=Category::find($id);
        $data=Category::all();

        return view('categories.edit',['category'=>$category,'data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $category=Category::findOrFail($id);
        $clean=$request->validate($this->rules(),$this->messages);

        // $category->name=$request->name;
        // $category->description=$request->input('description');
        // $category->slug=Str::slug($request->name) ;
        // $category->parent_id=$request->parent_id;
        // $category->save();
        // session()->flash('message','raw inserted');
        // dd($clean);
        $clean['slug']=Str::slug($request->name) ;
        Category::where('id',$id)->update($clean);
       return redirect()->route('categories.index')->with('message','raw updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::destroy($id);
        // $category->delete();
    //    return redirect('/categories');
    return redirect()->route('categories.index');


    }

    protected function rules(){
        $rules=$this->rules;
        // $rules['name'][]=function($attribute,$value,$fail){ //attribute = name |||
        //     if($value=='god'){
        //         $fail('This Word isnt Allowed');
        //     }
        // };  // it's only local

        // $rules['name'][]=new FilterRule(); //it's not local
        // $rules['name'][]='filter'; //it's not local

        return $rules;
    }
}
