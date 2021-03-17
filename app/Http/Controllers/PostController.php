<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'status'=> ['required'],
            'item.name'=>['required'],
            'item.category'=>['required'],
            'item.location'=>['required'],
            'item.picture'=>['required'],
        ]);

        

       $item = Item::create([
        'name' => $request->input('item.name'),
        'category' => $request->input('item.category'),
        'location' => $request->input('item.location'),
        'picture' => $request->input('item.picture'),
       ]);
    

        auth()->user()->post()->create([
            'title' => request('title'),
            'description' => request('description'),
            'type' => request('type'),
            'status'=> request('status'),
            'item_id'=> $item->id,
        ]);

        return response('Post created successfully');

        
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
