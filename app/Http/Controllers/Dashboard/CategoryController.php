<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        $request = request();

        $categories= Category::with('parent')

//        leftJoin('categories as parents','parents.id','=','categories.parent_id')
//            ->select([
//                'categories.*',
//                'parents.name as parent_name'
//            ])
            ->select('categories.*')
            ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
//            ->withCount([
//                'products'=>function ($query) {
//                    $query->where('status','=','active');
//                }
//            ])
            ->filter($request->query())
            ->latest()
            ->paginate(4); //return collection object

        //$categories=Category::active()->paginate();

        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('categories.create')) {
            abort(403);
        }
        $parents=Category::all();
        $category=new Category();
        return view('dashboard.categories.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');
        $request->validate(Category::rules(),[
            'required'=>'This filed is required',
            'unique'=>'This name is already exists',
        ]);
        //Request merge
        $request->merge([
            'slug'=>Str::slug($request->post('name'))
        ]);
        $data=$request->except('image');
        $data['image'] = $this->uploadImage($request);
        $category=Category::create($data);

        return redirect()->route('dashboard.categories.index' )->with('success','Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }
        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('categories.update');
        $category=Category::findorfail($id);

        //SELECT * FROM categories WHERE id <> $id
        //AND(parent_id IS NULL OR parent_id <> $id)

        $parents=Category::where('id','<>',$id)
            ->where(function ($query) use($id){
                $query->wherenull('parent_id')
                    ->orwhere('parent_id','<>',$id);
            })

            ->get();

        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //$request->validate(Category::rules($id));


        $category=Category::find($id);

        $old_image= $category->image;

        $data=$request->except('image');

        $new_image= $this->uploadImage($request);
        if ($new_image){
            $data['image']=$new_image;
        }
        $category->update( $data);

//        if ($old_image && $new_image){
//            Storage::disk('public')->delete('$old_image');
//        }


        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Gate::authorize('categories.delete');
        //$category=Category::findorfail($id);
        $category->delete();


        //Category::destroy($id);

        return redirect()->route('dashboard.categories.index')
            ->with('success','Category Delete');
    }

    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')){
            return;
        }

            $file=$request->file('image');
            $path=$file->store('uploads',['disk'=>'public']);
           return $path;

    }
    public function trash()
    {
        $categories=Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }

    public function restore(Request $request ,$id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success','Category restored');
    }
    public function forceDelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success','Category deleted forever');
    }

}
