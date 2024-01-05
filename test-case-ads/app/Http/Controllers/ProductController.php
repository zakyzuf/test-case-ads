<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAsset;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductAssetResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function indexByPriceDescending()
    {
        $products = Product::with('assets')->orderByDesc('price')->get();
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $data = $request->validated();

        $slugIsUnique = Product::where('slug', $data['slug'])
            ->where('id', '!=', $product->id)
            ->doesntExist();

        if (!$slugIsUnique) {
            return response()->json([
                'message' => 'The slug has already been taken.',
                'errors' => [
                    'slug' => ['The slug has already been taken.']
                ]
            ], 422);
        }

        $product->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price'],
        ]);

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

    // public function addAssets(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'images' => 'required|array',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     foreach ($request->file('images') as $image) {
    //         $pathToUploadedFile = $image->store('product_assets');

    //         $asset = new ProductAsset(['image' => $pathToUploadedFile]);
    //         $product->assets()->save($asset);
    //     }

    //     return response()->json(['message' => 'Assets added successfully']);
    // }

    // public function addAssets(Request $request, Product $product)
    // {
    //     // $assetsData = [];

    //     // foreach ($request->file('image') as $image) {
    //     //     $pathToUploadedFile = $image->store('product_assets');
    //     //     $assetsData[] = ['image' => $pathToUploadedFile];
    //     // }

    //     // $product->assets()->createMany($assetsData);

    //     // foreach ($request->file('image') as $image) {
    //     //     $pathToUploadedFile = $image->store('product_assets');

    //     //     $asset = new ProductAsset(['image' => $pathToUploadedFile]);
    //     //     $product->assets()->save($asset);
    //     // }

    //     // return response()->json(['message' => 'Assets added successfully']);

    //     foreach ($request->file('image') as $image) {
    //         $pathToUploadedFile = $image->store('product_assets');

    //         $asset = new ProductAsset(['image' => $pathToUploadedFile]);

    //         try {
    //             $product->assets()->save($asset);
    //         } catch (\Exception $e) {
    //             // Log the error for debugging
    //             Log::error('Error saving asset: ' . $e->getMessage());
    //         }
    //     }

    // }


    public function addAssets(Request $request, Product $product)
    {
        // foreach ($request->file('image') as $image) {
        //     try {
        //         $pathToUploadedFile = $image->store('product_assets');

        //         $asset = new ProductAsset(['image' => $pathToUploadedFile]);
        //         $product->assets()->save($asset);

        //         return new ProductAssetResource($asset); // Transform and add the resource to the collection
        //     } catch (\Exception $e) {
        //         Log::error('Error uploading file: ' . $e->getMessage());
        //     }
        // }

        // return response()->json(['message' => 'Assets added successfully']);
        $image = $request->file('image');
        $pathToUploadedFile = $image->store('product_assets');
        $asset = new ProductAsset([
            'image' => $pathToUploadedFile,
        ]);

        $product->assets()->save($asset);

        return response()->json(['message' => 'Asset added successfully']);
    }



    public function removeAsset(ProductAsset $asset)
    {
        Storage::delete($asset->image);

        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
