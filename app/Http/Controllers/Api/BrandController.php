<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->header('CF-IPCountry', null);

        if ($country) {
            $brands = Brand::where('country_code', $country)->get();
            if ($brands->isEmpty()) {
                $brands = Brand::all();
            }
        } else {
            $brands = Brand::all();
        }

        return response()->json($brands);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'brand_name' => 'required|string',
            'brand_image' => 'required|string',
            'rating' => 'required|integer',
            'country_code' => 'nullable|string|size:2',
        ]);

        $brand = Brand::create($validated);
        return response()->json($brand, 201);
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'brand_name' => 'required|string',
            'brand_image' => 'required|string',
            'rating' => 'required|integer',
            'country_code' => 'nullable|string|size:2',
        ]);

        $brand->update($validated);
        return response()->json($brand);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(null, 204);
    }
}
