<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return response()->json($properties, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'address' => 'required|string|max:500',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'square_feet' => 'required|integer|min:0',
            'status' => 'sometimes|string|in:available,rented',
        ]);

        $property = Property::create($validatedData);
        return response()->json($property, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($property, Response::HTTP_OK);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'address' => 'sometimes|required|string|max:500',
            'bedrooms' => 'sometimes|required|integer|min:0',
            'bathrooms' => 'sometimes|required|integer|min:0',
            'square_feet' => 'sometimes|required|integer|min:0',
            'status' => 'sometimes|string|in:available,rented',
            'images.*' => 'nullable|file|image|max:2048', // Validate images
        ]);

        if ($request->hasFile('images')) {
            $validatedData['images'] = array_map(function ($image) {
                return $image->store('properties', 'public');
            }, $request->file('images'));
        }

        $property->update($validatedData);
        return response()->json($property, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);    

        if (!$property) {
            return response()->json(['message' => 'Property not found'], Response::HTTP_NOT_FOUND);
        }

        $property->delete();
        return response()->json(['message' => 'Property deleted successfully'], Response::HTTP_OK);
    }
}
