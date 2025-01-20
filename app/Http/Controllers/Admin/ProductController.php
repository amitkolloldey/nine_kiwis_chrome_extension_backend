<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Get all products with their associated categories
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // Fetch all categories for the product creation form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create the product
        Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath, // Store image path
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    // Display the specified resource.
    // public function show(string $id)
    // {
    //     $product = Product::findOrFail($id);
    //     return view('products.show', compact('product'));
    // }

    // Show the form for editing the specified resource.
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        // Update the product
        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath, // Update image if new
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
