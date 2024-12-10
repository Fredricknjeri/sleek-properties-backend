<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


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
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'address' => 'required|string|max:500',
                'bedrooms' => 'required|integer|min:0',
                'bathrooms' => 'required|integer|min:0',
                'square_feet' => 'required|integer|min:0',
                'status' => 'sometimes|string|in:available,rented,FOR SALE',
                'images' => 'nullable|array',
                'images.*' => 'nullable|string',
            ]);
    
            $property = Property::create($validatedData);
    
            return response()->json([
                'message' => 'Property created successfully',
                'property' => $property,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric',
                'address' => 'sometimes|required|string|max:500',
                'bedrooms' => 'sometimes|required|integer|min:0',
                'bathrooms' => 'sometimes|required|integer|min:0',
                'square_feet' => 'sometimes|required|integer|min:0',
                'status' => 'sometimes|string|in:available,rented,FOR SALE',
                'images' => 'nullable|array', // Validate the images array
                'images.*' => 'nullable|string', // Validate individual image URLs as strings
            ]);

                   // Only assign images if they exist
        if ($request->has('images')) {
            $validatedData['images'] = $request->input('images');
        }

        $property->update($validatedData);

        return response()->json([
            'message' => 'Property updated successfully',
            'property' => $property,
        ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
