<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $city = City::paginate(30); 
        return CitiesResource::collection($city);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $city = new City();
        $city->name = $request['name'];
        $city->slug = Str::slug($request['name']);
        $city->region_id = $request['region_id'];
        $city->status_id = $request['status_id'];
        $city->user_id = $request['user_id'];
        $city->save();

        return new CitiesResource($city);

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

        $city = City::findOrFail($id);
        $city->name = $request['editname'];
        $city->slug = Str::slug($request['editname']);
        $city->region_id = $request['editregion_id'];
        $city->status_id = $request['editstatus_id'];
        $city->user_id = $request['user_id'];
        $city->save();

        return new CitiesResource($city);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id); 
        $city->delete(); 
        return new CitiesResource($city);
    }

    public function typestatus(Request $request){

        $city = City::findOrFail($request['id']); 
        $city->status_id = $request['status_id']; 
        $city->save(); 

        return new CitiesResource($city);
    }

    public function filterbycountryid($filter){
        return CitiesResource::collection(City::where('country_id',$filter)->where('status_id',3)->get());
    }

    public function filterbyregionid($filter){
        return CitiesResource::collection(City::where('region_id',$filter)->where('status_id',3)->get());
    }
}



// php artisan make:controller Api\CitiesController --api 
// php artisan make:resource CitiesResource 