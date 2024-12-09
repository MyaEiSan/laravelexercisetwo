<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\TownshipsResource;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TownshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $city = Township::paginate(30); 
        return CitiesResource::collection($city);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $township = new Township();
        $township->name = $request['name'];
        $township->slug = Str::slug($request['name']);
        $township->region_id = $request['region_id'];
        $township->status_id = $request['status_id'];
        $township->user_id = $request['user_id'];
        $township->save();

        return new CitiesResource($township);

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

        $township = Township::findOrFail($id);
        $township->name = $request['editname'];
        $township->slug = Str::slug($request['editname']);
        $township->region_id = $request['editregion_id'];
        $township->status_id = $request['editstatus_id'];
        $township->user_id = $request['user_id'];
        $township->save();

        return new CitiesResource($township);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $township = Township::findOrFail($id); 
        $township->delete();
        return new TownshipsResource($township);
    }

    public function typestatus(Request $request){

        $township = Township::findOrFail($request['id']); 
        $township->status_id = $request['status_id']; 
        $township->save(); 

        return new TownshipsResource($township);
    }

    public function filterbycityid($filter){
        return TownshipsResource::collection(Township::where('city_id',$filter)->where('status_id',3)->get());
    }
}


// php artisan make:controller Api\TownshipsController --api