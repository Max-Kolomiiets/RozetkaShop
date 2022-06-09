<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Database\Seeders\ProductsSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadProductsJson(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimetypes:application/json'
        ]);

        if ($validator->fails()) {

            $response['status'] = 'Failed! Something went wrong';
            $response['code'] = -1;
        } else {
            if ($request->file('file')) {

                $path = $request->file('file')->store('public/files');

                $productsSeeder = new ProductsSeeder();
                $productsSeeder->run($path);

                Storage::delete($path);

                $response['status'] = 'Products have been uploaded!';
                $response['code'] = 1;
            } else {
                $response['status'] = 'Failed! Something went wrong';
                $response['code'] = -1;
            }
        }

        return response()->json($response);
    }

    public function uploadImagesAndJsonFile(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), [
            'images' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'file' => 'required|file|mimetypes:application/json'
        ]);

        if ($validator->fails()) {
            $response['status'] = 'Failed! Something went wrong';
            $response['code'] = -1;
            return response()->json($response);
        }

        if ($request->TotalImages > 0 && $request->jsonFile != null) {

            $folderName = Str::random(30);

            for ($x = 0; $x < $request->TotalImages; $x++) {
                if ($request->hasFile('images' . $x)) {
                    $file = $request->file('images' . $x);
                    $path = $file->store('public/images/' . $folderName);
                }
            }

            $path = $request->file('jsonFile')->store('public/files');

            $productsSeeder = new ProductsSeeder();
            $productsSeeder->run($path, $folderName);

            Storage::delete($path);

            $response['status'] = 'Products with images have been uploaded!';
            $response['code'] = 1;

            return response()->json($response);
        }

        return response()->json($response);
    }
}
