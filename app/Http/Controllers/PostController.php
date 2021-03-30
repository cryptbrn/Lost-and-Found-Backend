<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Post;

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
        if($request->user()==null){
            $success = false;
            $message = "autentikasi gagal";
        }
        else{
            $success = true;
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
    

            $input = $request->all();
            $inputItem = $input['item']; 
        
            $post = auth()->user()->posts()->create([
                    'title' => $input['title'], 
                    'description' => $input['description'],
                    'type' => $input['type'],
                    'status'=> $input['status'],
                    ]);

            $item = new Item;
            $item->name = $input['item']['name'];
            $item->post_id = $post->id;
            $item->category = $input['item']['category'];
            $item->location = $input['item']['location'];
        
            if($request->hasFile('item.picture')){
                $file = $request->file('item.picture');
                $extenstion = $request['item']['picture']->extension();
                $picture_name = time().'.'.$extenstion;
                $file->move('storage/item_picture',$picture_name);
                $item->picture = $picture_name;
            }else{
                $item->picture ='';
            }
            $item->save();

            // $item = Item::create([
            //     'name' => $request->input('item.name'),
            //     'post_id'=>$post->id,
            //     'category' => $request->input('item.category'),
            //     'location' => $request->input('item.location'),
            //     'picture' => $request->input('item.picture'),
       
            //     if($input->item->hasFile('item.picture')){
            //         $file = $request->file('item.picture');
            //         $extenstion = $file->getClientOriginalExtension();
            //         $picture_name = time().'.'.$extenstion;
            //         $file->move('storage/item_picture',$picture_name);
            //         $item->foto_pupuk = $picture_name;
            //     }else{
            //         return $request;
            //         $pupuk->foto_pupuk ='';
            //     }
            //     $pupuk->save();
            // ]);

            

            $message = "Post created succesfully";
        }


        return response()->json([
            'success'=>$success,
            'message'=>$message,
        ]);
    }

    

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $post = Post::with('item')->get();
        return response()->json([
            'success'=>true,
            'post'=>$post
        ]);
        
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyId($id)
    {
        $post = Post::find($id);
        $post->item = Item::find($id);

        return response()->json([
            'success'=>true,
            'post'=>$post
        ]);
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
