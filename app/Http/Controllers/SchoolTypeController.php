<?php

namespace App\Http\Controllers;

use App\Models\SchoolType;
use Illuminate\Http\Request;

class SchoolTypeController extends Controller
{
    // GET /api/school-types
    public function index()
    {
        return response()->json(SchoolType::select('id', 'name')->get());
    }

    // GET /api/school-types/{schoolType}
    public function show(SchoolType $schoolType)
    {
        return response()->json($schoolType);
    }

    // POST /api/school-types (Admin only)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:school_types,name',
        ]);

        $schoolType = SchoolType::create($data);

        return response()->json([
            'message' => 'School type created successfully.',
            'data' => $schoolType,
        ], 201);
    }

    // PUT /api/school-types/{schoolType} (Admin only)
    public function update(Request $request, SchoolType $schoolType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:school_types,name,' . $schoolType->id,
        ]);

        $schoolType->update($data);

        return response()->json([
            'message' => 'School type updated successfully.',
            'data' => $schoolType,
        ]);
    }

    // DELETE /api/school-types/{schoolType} (Admin only)
    public function destroy(SchoolType $schoolType)
    {
        $schoolType->delete();

        return response()->noContent();
    }
}
