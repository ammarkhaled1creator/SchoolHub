<?php

namespace App\Http\Controllers;
use App\Models\School;
use App\Models\Location;
use App\Models\TuitionFees;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1-Make sure that request is fully sent
        $valid = $request -> validate([
    'name'=>'required|string|max:225',
    'description'=>'required|string',
    'phone'=>'required|string',
    'website'=>'required|url',
    'image'=>'image|mimes:jpeg,png',

    //Locations:
    'locations'=>'required|array|min:1',
    'locations.*.city'=>'required|string',
    'locations.*.address'=>'required|string',
    'locations.*.google_maps_link'=>'required|url',

    //tuition_fees
    'tuition_fees'=>'required|array|min:1',
    'tuition_fees.*.grade'=>'required|string',
    'tuition_fees.*.price'=>'required|numeric ',
    'tuition_fees.*.academic_year'=>'required|string',
    ]);

    //confirm Creation:
    $school= School::create([
    'name'=>$valid['name'],
    'description'=>$valid['description'],
    'phone'=>$valid['phone'],
    'website'=>$valid['website'],
    'image'=>$valid['image']
    ]);

    //insert locations, fees into their tables:
    $school->locations()->createMany($valid['locations']);
    $school->tuition_fees()->createMany($valid['tuition_fees']);

    //Return Response:
    return response() ->json([ 
        'message' => 'School Created Successfully !',
        'data'=> $valid ],
          201);
        
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
    //Look for school Id if it exists or not?
    $school=School::findOrFail($id);

    $valid = $request -> validate([
    'name'=>'sometimes|string|max:225',
    'description'=>'sometimes|string',
    'phone'=>'sometimes|string',
    'website'=>'sometimes|url',
    'image'=>'image|mimes:jpeg,png',

    //Locations:
    'locations'=>'sometimes|array|min:1',
    'locations.*.city'=>'required_with:locations|string',
    'locations.*.address'=>'required_with:locations|string',
    'locations.*.google_maps_link'=>'required_with:locations|url',

    //tuition_fees
    'tuition_fees'=>'sometimes|array|min:1',
    'tuition_fees.*.grade'=>'required_with:tuition_fees|string',
    'tuition_fees.*.price'=>'required_with:tuition_fees|numeric ',
    'tuition_fees.*.academic_year'=>'required_with:tuition_fees|string',
    ]);

    
   

    //confirm Updation for school table:
    $school->update($request->only(['name','description','phone','website','image']));

    //delete old data and insert all the new only if the sent request has location data:
    if($request->has('locations')){
    $school->locations()->delete();
    $school->locations()->createMany($valid['locations']);}

   //tuition_fees same as location
   if($request->has('tuition_fees')){
    $school->tuition_fees()->delete();
    $school->tuition_fees()->createMany($valid['tuition_fees']);}

    //Return Response:
    return response() ->json([ 
        'message' => 'School Updated Successfully !',
         'data'=> $school->load(['locations','tuition_fees']) ],
          200);
        
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //1.look for school
        $school=School::findOrFail($id);
        $school->delete();
        return response(null,204);

    }
}
