<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionsResource;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $region = Region::paginate(30); 
        return RegionsResource::collection($region);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $region = new Region();
        $region->name = $request['name'];
        $region->slug = Str::slug($request['name']);
        $region->country = $request['country'];
        $region->status_id = $request['status_id'];
        $region->user_id = $request['user_id'];
        $region->save();

        return new RegionsResource($region);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $region = Region::findOrFail($id);
        $region->name = $request['editname'];
        $region->slug = Str::slug($request['editname']);
        $region->city_id = $request['editcity_id'];
        $region->status_id = $request['editstatus_id'];
        $region->user_id = $request['user_id'];
        $region->save();

        return new RegionsResource($region);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id); 
        $region->delete(); 
        return new RegionsResource($region);
    }

    public function typestatus(Request $request){

        $region = Region::findOrFail($request['id']); 
        $region->status_id = $request['status_id']; 
        $region->save(); 

        return new RegionsResource($region);
    }

    public function filterbycountryid($filter){
        return RegionsResource::collection(Region::where('country_id',$filter)->where('status_id',3)->get());
    }
}




// php artisan make:controller Api\RegionsController --api 
// php artisan make:resource RegionsResource 