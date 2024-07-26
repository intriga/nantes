<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::orderBy('id', 'desc')->with('category')->get();
        // return response()->json($posts);

        $posts = Post::with('category')->orderBy('id', 'desc')->paginate(5);
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');

        if ($request->allFiles('image')) {     
            $fileName = $request->file('image')->hashName();
            $path = $request->file('image')->storeAs('images', $fileName, 'public');
            $post["image"] = '/'.$path;
        }
        //return response()->json("Uploaded successfully!");

        //dd($request->all());
        $post->save();
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->with('category') // Eager load the category relationship
            ->first();
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)
        ->with('category') // Eager load the category relationship
        ->first();
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->content = $request->input('content');

        $post->category_id = $request->input('category_id');

        $old_image = $post->old_image = $request->input('old_image');

        $image = $request->file('image'); // Access uploaded file
        // dd($request->all());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Delete the old image if it exists
            if (File::exists(public_path($old_image))) {
                File::delete(public_path($old_image));
            }
    
            $fileName = $image->hashName();
            $imagePath = '/images/' . $fileName;
            $image->move(public_path('images'), $fileName);
    
            $post->image = $imagePath;
        }
    
        $post->save();
    
        return back()->with('message', 'Post updated successfully!');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post->image) {
            $imagePath = public_path($post->image); // Get the absolute path to the image
    
            if (File::exists($imagePath)) {
                File::delete($imagePath); // Delete the file using Laravel's File facade
            }
    
            $post->delete();
        } else {
            $post->delete();
        }
    }
}
