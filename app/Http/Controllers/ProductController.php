<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    # Display a listing of all products.
    public function index()
    {
        return Product::latest()->get();
    }

    # Store a newly created product in storage.
    public function store(Request $request)
    {
        # Validate the fields 
        $fields = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        # Handle file upload if present
        if($request -> hasFile('image')) {

            # store the file in storage folder
            $fields['image'] = $request->file('image')->store('products', 'public');
        }
        return Product::create($fields);
    }

    # Display the specified product.
    public function show(string $id)
    {
        return Product::find($id);
    }

    # Update the specified product in storage.
    public function update(Request $request, string $id)
    {
        # Get the product first
        $product = Product::findOrFail($id);

         # Validate the fields 
        $fields = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'sometimes|required|string',
            'slug' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
        ]);

        # Handle new image upload
        if ($request->hasFile('image')) {

            # Delete old image if it exist
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            # Save new image
            $fields['image'] = $request->file('image')->store('products', 'public');
        }

        # Update the product
        $product->update($fields);

        # Return the updated product 
        return $product;
    }

    # Remove the specified product from storage.
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        # Delete image from the disk
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    # Search for a product
    public function search(string $name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
