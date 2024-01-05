<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAsset;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('assets')->get();
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        $data = $request->validated();

        $product = Product::create([
            'category_id' => $data->input('category_id'),
            'name' => $data->input('name'),
            'slug' => $data->input('slug'),
            'price' => $data->input('price'),
        ]);

        foreach ($request->file('images') as $image) {
            $pathToUploadedFile = $image->store('product_assets');

            $asset = new ProductAsset(['image' => $pathToUploadedFile]);
            $product->assets()->save($asset);
        }

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        $product = Product::with('assets')->find($product->id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $data = $request->validated();

        $product->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'price' => $request->input('price'),
        ]);

        foreach ($request->file('images') as $image) {
            $pathToUploadedFile = $image->store('product_assets');

            $asset = new ProductAsset(['image' => $pathToUploadedFile]);
            $product->assets()->save($asset);
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->assets()->delete();

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function removeAsset(Product $product, ProductAsset $asset)
    {
        Storage::delete($asset->image);

        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
