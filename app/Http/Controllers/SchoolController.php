<?php

namespace App\Http\Controllers;
use App\Http\Resources\CompareResource;
use App\Http\Resources\DetailsResource;
use App\Http\Resources\SchoolResource;
use App\Models\School;
use App\Models\Location;
use App\Models\SchoolType;
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
    'school_type_id'=>'required|exists:school_types,id',
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

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('schools', 'public');
        $valid['image'] = $imagePath; 
    }

    //confirm Creation:
    $school= School::create([
    'name'=>$valid['name'],
    'description'=>$valid['description'],
    'phone'=>$valid['phone'],
    'website'=>$valid['website'],
    'school_type_id'=>$valid['school_type_id'],
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
    // return a single school with all related data
    public function show(string $id)
    {
        $school=school::with(['schoolType',
        'locations',
        'tuition_fees',
        'reviews.user'])
        ->withAvg('reviews','rating')
        ->findOrFail($id);
        return new DetailsResource($school);
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
    'school_type_id'=>'sometimes|exists:school_type_id',
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

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('schools', 'public');
        $valid['image'] = $imagePath;
    }

    //confirm Updation for school table:
    $school->update($valid);

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
    public function filter(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->input('per_page', 10);

        $query = School::query()
            ->withAvg('reviews', 'rating')
            ->with('schoolType');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('school_type')) {
            $schoolType = $request->school_type;

            $query->whereHas('schoolType', function ($q) use ($schoolType) {
                if (is_numeric($schoolType)) {
                    $q->where('id', $schoolType);
                } else {
                    $q->where('name', $schoolType);
                }
            });
        }



        if ($request->filled('locations')) {
            $location = $request->locations;

            $query->whereHas('locations', function ($q) use ($location) {
                $q->where('city', 'like', '%' . $location . '%');
            });

        }
        $schools = $query->paginate($perPage)->appends($request->query());
        return response()->json([
            'data' => SchoolResource::collection($schools->items()),
            'links' => [
                'first' => $schools->url(1),
                'last' => $schools->url($schools->lastPage()),
                'prev' => $schools->previousPageUrl(),
                'next' => $schools->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $schools->currentPage(),
                'last_page' => $schools->lastPage(),
                'per_page' => $schools->perPage(),
                'total' => $schools->total(),
            ],
        ]);
    }
    // compare two schools based on thier general information
    public function compare(Request $request){
        $request->validate([
            'first_school_id'=>'required|exists:schools,id',
            'second_school_id'=>'required|exists:schools,id|different:first_school_id'

        ]);
        $first_school=School::with([
            'schoolType',
            'locations',
            'tuition_fees',
        ])
        ->withAvg('reviews','rating')
        ->findOrFail($request->first_school_id);
        $second_school=School::with([
            'schoolType',
            'locations',
            'tuition_fees',
        ])
        ->withAvg('reviews','rating')
        ->findOrFail($request->second_school_id);
        return response()->json([
            'first_school'=>new CompareResource($first_school),
            'second_school'=>new CompareResource($second_school),
        ],200);

    }

}
