<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use DataTables;

class CategoryController extends Controller
{

    public function index(Request $request){

        $categories = Categories::select('id', 'name', 'type');

        if($request->ajax()){
            return DataTables::of($categories)
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" class="btn-sm btn btn-info editButton" data-id="'.$row->id.'">Edit</a>
                        <a href="javascript:void(0)" class="btn-sm btn btn-danger delButton" data-id="'.$row->id.'">Delete</a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);

        }
    }

    public function create(){
        return view('category.create');
    }

    public function store(Request $request){

        if($request->category_id !== null){
           
            $category = Categories::find($request->category_id);
            if(! $category){
                abort(404);
            }

            $category->update([
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return response()->json([
                'success' => 'category update successfully',
            ]);

        } else{

            $request->validate([
                'name' => 'required|min:2|max:36',
                'type' => 'required',
            ]);
    
            Categories::create([
                'name' => $request->name,
                'type' => $request->type,
            ]);
    
            return response()->json([
                'success' => 'category create successfully',
            ],201 );

        }


    }

    public function edit($id){
        $categories =  Categories::find($id);
        if(! $categories){
            abort(404);
        }

        return $categories;
    }

    public function destroy($id){
        $categories =  Categories::find($id);
        if(! $categories){
            abort(404);
        }

        $categories->delete();

        return response()->json([
            'success' => 'category delete successfully',
        ], 201);

    }

    
}
