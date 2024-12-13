<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    // Method to fetch all manufacturers
    public function index()
    {
        // Optionally paginate if you have a lot of manufacturers
        return Manufacturer::all();  // Or you can use paginate() if you need pagination, e.g., ->paginate(10);
    }

    /**
     * Create a product for a manufacturer.
     * Supports both Individual Bulk Buy and Merge Buy options.
     */
    public function createProduct(Request $request, $manufacturerId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'product_type' => 'required|string|in:bulk,merge', // Indicates the product type
            'minimum_order_quantity' => 'required_if:product_type,bulk|integer|min:1', // For bulk buy
            'available_quantity' => 'required|integer|min:1',
            'merge_buy_limit' => 'required_if:product_type,merge|integer|min:1', // For merge buy
            'merge_buy_price' => 'required_if:product_type,merge|numeric|min:0',
            'merge_buy_quantity' => 'required_if:product_type,merge|integer|min:1',
            'merge_buy_city' => 'nullable|string|max:255',
        ]);

        // Attach the product to the manufacturer
        $validatedData['manufacturer_id'] = $manufacturerId;

        $product = Product::create($validatedData);

        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }

    /**
     * Update product details.
     */
    public function updateProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'price' => 'sometimes|numeric|min:0',
            'product_type' => 'sometimes|string|in:bulk,merge',
            'minimum_order_quantity' => 'sometimes|integer|min:1',
            'available_quantity' => 'sometimes|integer|min:1',
            'merge_buy_limit' => 'sometimes|integer|min:1',
            'merge_buy_price' => 'sometimes|numeric|min:0',
            'merge_buy_quantity' => 'sometimes|integer|min:1',
            'merge_buy_city' => 'nullable|string|max:255',
        ]);

        // Verify the manufacturer owns the product (optional but recommended)
        if ($product->manufacturer_id !== $request->manufacturer_id) {
            return response()->json(['error' => 'Unauthorized operation for this product'], 403);
        }

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully', 'data' => $product], 200);
    }
}
