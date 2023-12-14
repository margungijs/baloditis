<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorageProduct;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function getProducts()
    {
        $allData = StorageProduct::all();

        // $allData now contains all records from the specified table

        return response()->json($allData);
    }
    public function store(Request $request)
    {
        \Log::info('Received request data:', $request->all());
        try {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

            // Create a new product using Eloquent
            $product = StorageProduct::create($validatedData);

            // Optionally, you can redirect or return a response
            return response()->json(['message' => 'Product created', 'product' => $product], 201);
        }catch (ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            $detailedErrors = [];

            foreach ($errors->getMessages() as $field => $messages) {
                $detailedErrors[] = ['field' => $field, 'message' => $messages[0]];
            }

            return response()->json(['error' => 'Validation failed', 'messages' => $detailedErrors], 422);
        }
    }
    public function update(Request $request, $id)
    {
        $product = StorageProduct::findOrFail($id);
        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully']);
    }
}
