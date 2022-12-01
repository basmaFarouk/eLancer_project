<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\CreateCategoryJob;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        $this->authorize('view-any',Category::class);
    //    if(!Gate::allows('categories.view')){
    //         abort(403);
    //    }
        // $data=DB::table('categories')->get();
        $modules=['users','categories','projects'];
        $data = Category::leftjoin('categories as parents','parents.id','=','categories.parent_id')
        ->select('categories.*','parents.name as parent_name')->paginate(3);
        // dd($data);
        return view('categories.index',["data"=>$data,'title'=>'Show','modules'=>$modules]);
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

        if($request->hasFile('category_image')){

            $FinalName = uniqid().'.'.$request->category_image->extension();
            if($request->category_image->move(public_path('/category'),$FinalName)){
                $request['category_image']=$FinalName;

             }
        }
        $request['slug']=Str::slug($request->name) ;
        // dispatch(new CreateCategoryJob($request->all()));
        $category =Category::create($request->all());
        session()->flash('message','Category Created');
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
       // $this->authorize('view-any',$category);

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
        if($request->hasFile('category_image')){

            $FinalName = uniqid().'.'.$request->category_image->extension();
            if($request->category_image->move(public_path('/category'),$FinalName)){
                $clean['image']=$FinalName;
                if($category->image){
                    unlink(public_path('/category/'.$category->image));
                }
             }
        }
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

    public function trash(){
        //Category::withTrashed();
       $data= Category::onlyTrashed()->paginate();

        return view('categories.trashed',["data"=>$data,'title'=>'Deleted Categories']);
    }

    //Restore Function
    public function restore(Request $request,$id){

        $category= Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.trash');
    }

    //Force Delte Function
    public function forceDelete($id){
        $category= Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('categories.trash');
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
