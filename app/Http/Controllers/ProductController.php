<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Optional filters
        if ($request->has('type')) {
            $query->where('product_type', $request->type);
        }

        if ($request->has('manufacturer_id')) {
            $query->where('manufacturer_id', $request->manufacturer_id);
        }

        if ($request->has('city')) {
            $query->where('merge_buy_city', $request->city);
        }

        $products = $query->get();

        return response()->json(['data' => $products], 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'minimum_order_quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'manufacturer_id' => 'required|integer|exists:manufacturers,id',
            'product_type' => 'required|in:bulk,merge',
            // Merge buy specific fields
            'merge_buy_quantity' => 'nullable|integer|min:1',
            'merge_buy_city' => 'nullable|string|max:255',
            'participants' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Calculate merge_buy_price and merge_buy_limit
        if ($data['product_type'] === 'merge' && isset($data['participants']) && $data['participants'] > 0) {
            $data['merge_buy_price'] = $data['price'] / $data['participants'];
            if (isset($data['merge_buy_quantity'])) {
                $data['merge_buy_limit'] = $data['merge_buy_quantity'] / $data['participants'];
            }
        }

        // Create the product
        $product = Product::create($data);

        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }

    /**
     * Add a participant to a merge buy product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function addParticipant(Request $request, $productId)
    {
        $product = Product::where('id', $productId)
            ->where('product_type', 'merge')
            ->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'logistics_details' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $participant = $product->participants()->create($validatedData);

        return response()->json(['message' => 'Participant added successfully', 'data' => $participant], 201);
    }

    /**
     * View participants for a specific product.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function viewParticipants($productId)
    {
        $product = Product::where('id', $productId)
            ->where('product_type', 'merge')
            ->firstOrFail();

        $participants = $product->participants;

        return response()->json(['data' => $participants], 200);
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(['data' => $product], 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'minimum_order_quantity' => 'sometimes|required|integer|min:1',
            'available_quantity' => 'sometimes|required|integer|min:0',
            'manufacturer_id' => 'sometimes|required|integer|exists:manufacturers,id',
            'product_type' => 'sometimes|required|in:bulk,merge',
            // Merge buy specific fields
            'merge_buy_quantity' => 'nullable|integer|min:1',
            'merge_buy_city' => 'nullable|string|max:255',
            'participants' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Recalculate merge_buy_price and merge_buy_limit if necessary
        if (isset($data['product_type']) && $data['product_type'] === 'merge' && isset($data['participants']) && $data['participants'] > 0) {
            $data['merge_buy_price'] = $data['price'] / $data['participants'];
            if (isset($data['merge_buy_quantity'])) {
                $data['merge_buy_limit'] = $data['merge_buy_quantity'] / $data['participants'];
            }
        }

        // Update the product
        $product->update($data);

        return response()->json(['message' => 'Product updated successfully', 'data' => $product], 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
