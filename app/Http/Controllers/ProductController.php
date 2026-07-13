<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    # Display a listing of all products.
    public function index()
    {
        return Product::all();
    }

    # Store a newly created product in storage.
    public function store(Request $request)
    {
        # Validate the fields 
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);

        return Product::create($request->all());
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
        $product = Product::find($id);

        # Update it
        $product->update($request->all());

        # Return the updated product 
        return $product;
    }

    # Remove the specified product from storage.
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }

    # Search for a product
    public function search(string $name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
