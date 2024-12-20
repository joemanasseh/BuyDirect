<?php 

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    /**
     * Fetch all manufacturers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return response()->json(['data' => $manufacturers], 200);
    }

    /**
     * Create a product for a manufacturer, supporting both Bulk Buy and Merge Buy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $manufacturerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProduct(Request $request, $manufacturerId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'product_type' => 'required|string|in:bulk,merge',
            'minimum_order_quantity' => 'required_if:product_type,bulk|integer|min:1',
            'available_quantity' => 'required|integer|min:1',
            'merge_buy_limit' => 'required_if:product_type,merge|integer|min:1',
            'merge_buy_price' => 'required_if:product_type,merge|numeric|min:0',
            'merge_buy_quantity' => 'required_if:product_type,merge|integer|min:1',
            'merge_buy_city' => 'nullable|string|max:255',
        ]);

        $validatedData['manufacturer_id'] = $manufacturerId;
        $product = Product::create($validatedData);

        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }

    /**
     * Update a product for a manufacturer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
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

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully', 'data' => $product], 200);
    }

    /**
     * View participants of a merge-buy product.
     *
     * @param  int  $manufacturerId
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewParticipants($manufacturerId, $productId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);
        $product = Product::where('id', $productId)
            ->where('manufacturer_id', $manufacturer->id)
            ->where('product_type', 'merge')
            ->firstOrFail();

        $participants = $product->participants;

        return response()->json(['data' => $participants], 200);
    }

    /**
     * Add a participant to a merge-buy product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $manufacturerId
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addParticipant(Request $request, $manufacturerId, $productId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);
        $product = Product::where('id', $productId)
            ->where('manufacturer_id', $manufacturer->id)
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

        $participant = $product->participants()->create(array_merge($validatedData, [
            'manufacturer_id' => $manufacturerId,
        ]));

        return response()->json(['message' => 'Participant added successfully', 'data' => $participant], 201);
    }

    /**
     * Update the number of participants for a merge-buy product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $manufacturerId
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMergeBuyParticipants(Request $request, $manufacturerId, $productId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);
        $product = Product::where('id', $productId)
            ->where('manufacturer_id', $manufacturer->id)
            ->where('product_type', 'merge')
            ->firstOrFail();

        $validatedData = $request->validate([
            'merge_buy_participants' => 'required|integer|min:1',
        ]);

        $product->merge_buy_participants = $validatedData['merge_buy_participants'];
        $product->save();

        return response()->json(['message' => 'Merge buy participants updated successfully', 'data' => $product], 200);
    }
}
