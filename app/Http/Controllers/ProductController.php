<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorageProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function groupedProducts()
    {
        $products = StorageProduct::all();

        $groupedProducts = $products->groupBy(function ($item) {
            return $item->category ?: 'Unsorted';
        });

        return response()->json($groupedProducts);
    }

    public function getProducts()
    {
        $allData = StorageProduct::all();

        // $allData now contains all records from the specified table

        return response()->json($allData);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'sometimes|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'count' => 'sometimes|nullable|integer'
            ]);

            $existingProduct = StorageProduct::where('name', $validatedData['name'])->first();

            if($existingProduct){
                $count = $validatedData['count'] ?? false;
                if($count){
                    $existingProduct->increment('count', $count);
                }else{
                    $existingProduct->increment('count');
                }
                return response()->json(['message' => 'Product count incremented', 'product' => $existingProduct]);
            }

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

    public function setCategory(Request $request, $productID){
        // Validate the request data if needed
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        // Find the product by ID
        $product = StorageProduct::findOrFail($productID);

        // Update the 'category' field with the new value
        $product->update(['category' => $request->input('category')]);

        // Optionally, you can return a response
        return response()->json(['message' => 'Category updated successfully', 'product' => $product]);
    }
}
