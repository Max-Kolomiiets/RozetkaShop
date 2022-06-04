<?php

namespace App\Http\Controllers;

use Database\Seeders\ProductsSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
}
