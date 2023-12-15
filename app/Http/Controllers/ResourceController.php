<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class ResourceController extends Controller
{
    public function index(Request $request){
        return Inertia::render('Resources', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category')->get(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request){

        // Se hacen las validaciones del request
       // $request->validate([
       //     'title' => ['required', 'max:255'],
       //     'category_id => ['required', 'exists:categories,id'],
       //     'url'=> ['required','url'],
       // ]);

        Resource::create([
            'title'=>$request->title,
            'link'=> $request->link,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'creator_id'=> $request->user()->id,
        ]);

    }

    public function search(Request $request){
        return Resource::query()
        ->when(!empty($request->search),function ($query) use ($request){
            return $query->where('title', 'like', "%$request->search%");
        })
        ->when(!empty($request->category),function ($query) use ($request){
            return $query->where('category_id', $request->category);
        })
        ->with('category')
        ->get();
    }



}
