<?php

namespace App\Http\Controllers;

use App\Models\Ajax_curd;
use Illuminate\Http\Request;

class AjaxCurdController extends Controller
{
    public function ajax_create(){
        return view('Ajax_curd.create');
    }

    public function ajax_stored(Request $request){
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'price_percentage' => 'required|numeric|min:0',
            'total' => 'required',
            'date' => 'required',
        ]);

        $addData = new Ajax_curd();

        $addData->name = $request->name;
        $addData->price = $request->price;
        $addData->price_percentage = $request->price_percentage;
        $addData->total = $request->total;
        $addData->date = $request->date;

        return response()->json([
            'success' => 'DATA INSERT SUCCESSFULLY',
        ]);

    }


}
