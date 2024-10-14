<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Log;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('id','asc')->paginate(10);
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('tags.index',['tags' => $tags,'statuses'=>$statuses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50|unique:tags,name',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $tag = new Tag();
        $tag->name = $request['name'];
        $tag->slug = Str::slug($request['name']);
        $tag->status_id = $request['status_id'];
        $tag->user_id = $user_id;

        $tag->save();

        return redirect(route('tags.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => 'required|max:50|unique:categories,name,'.$id,
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $tag = Tag::findOrFail($id);
        $tag->name = $request['name'];
        $tag->slug = Str::slug($request['name']);
        $tag->status_id = $request['status_id'];
        $tag->user_id = $user_id;

        $tag->save();

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $tag = Tag::findOrFail($request['id']);
        $tag->status_id = $request['status_id'];
        $tag->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $tag = Tag::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
