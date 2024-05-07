<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ajax_2;

class CreateController extends Controller
{
    public function create_view(){
        return view('ajax_2.create');
    }

    public function stored(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        ajax_2::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => 'Create Data Successfully',
        ]);
    }

    public function index(Request $request){

        $data = ajax_2::all();

        if(! $data){
            return response()->json([
                'error' => 'Create Data Successfully',
            ]);
        }
        return response()->json($data);
    }

    public function show_id($id){
        $data = ajax_2::find($id);

        if(! $data){
            return response()->json([
                'error' => 'Create Data Successfully',
            ]);
        }
        return response()->json($data);
    }
    
    public function update(Request $request, $id) {
        $data = ajax_2::find($id);
    
        if (! $data) {
            return response()->json([
                'error' => 'Data not found',
            ], 404);
        }
    
        $data->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        return response()->json([
            'success' => 'Data updated successfully',
        ]);
    }

    
    public function delete($id) {
        $data = ajax_2::find($id);
    
        if (! $data) {
            return response()->json([
                'error' => 'Data not found',
            ], 404);
        }
    
        $data->delete();
    
        return response()->json([
            'success' => 'Data deleted successfully',
        ]);
    }
    
}
