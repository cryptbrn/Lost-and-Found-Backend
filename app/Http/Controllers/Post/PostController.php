<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                        'title' => ['required'],
                        'description' => ['required'],
                        'type' => ['required'],
                        'status'=> ['required'],
                        'item.name'=>['required'],
                        'item.category'=>['required'],
                        'item.location'=>['required'],
                        'item.picture'=>['required'],
                    ]);
        
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>$validator->errors()->first(),
            ]);
        }

        try{
            $input = $request->all();
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

            return response()->json([
                'success'=>true,
                'message'=>'Post created succesfully',
            ]);   
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
    }

    

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $post = Post::with('item')->get();
        if($post!=null){
            return response()->json([
                'success'=>true,
                'post'=>$post
            ]);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>'Post not found'
            ]);
        }
        
        
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyId($id)
    {
        $post = Post::with('item')->find($id);
        if($post!=null){
            return response()->json([
                'success'=>true,
                'post'=>$post
            ]);
        }
        else {
            return response()->json([
                'success'=>false,
                'message'=>'Post not found'
            ]);
        }

        
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
        try{
            $post = Post::find($id);
            $item_id = Item::where('post_id','=',$id)->value('id');
            $item = Item::find($item_id);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->type = $request->type;
            $item->name = $request->item['name'];
            $item->category = $request->item['category'];
            $item->location = $request->item['location'];
            if($request->hasFile('item.picture')){
                $file = $request->file('item.picture');
                $extenstion = $request['item']['picture']->extension();
                $picture_name = time().'.'.$extenstion;
                $file->move('storage/item_picture',$picture_name);
                $item->picture = $picture_name;
            }
    
            $post->update();
            $item->update();

            return response()->json([
                'success'=>true,
                'message'=>'Post updated'
            ]);
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
        
    }

    public function updateStatus(Request $request, $id)
    {
        try{
            $post = Post::find($id);
            $post->status = $request->status;
            $post->update();

            return response()->json([
                'success'=>true,
                'message'=>'Status updated'
            ]);
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $post = Post::find($id);
            if($post!=null){
                $post->is_deleted = true;
                $post->update();
                return response()->json([
                    'success'=>true,
                    'message'=>'Post deleted successfully'
                ]);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Post not found'
                ]);
            }
            
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
        
    }
}
