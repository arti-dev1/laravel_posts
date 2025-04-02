<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $data['posts'] = Post::all();
        return $this->sendResponce($data, 'All Post Data');
    }

    public function store(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()->all()
            ], 401);

            sendError('Validation Error', $validateUser->errors()->all());
        }

        $img = $request->file('image');
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads', $imageName);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName
        ]);

        return $this->sendResponce($post, 'Post Created Successfully');
    }

    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return $this->sendResponce($post, 'Your single Post');
    }

    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'sometimes|mimes:png,jpg,jpeg,gif'
            ]
        );

        if ($validateUser->fails()) {
            sendError('Validation Error', $validateUser->errors()->all());
        }

        $post = Post::where('id', $id)->first();
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $path = public_path() . '/uploads/';
        if ($request->hasFile('image')) {
            if (!empty($post->image) && file_exists($path . $post->image)) {
                unlink($path . $post->image);
            }
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $img->move($path, $imageName);
        } else {
            $imageName = $post->image;
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName
        ]);

        return $this->sendResponce($post, 'Post Updated Successfully');

    }

    public function destroy(string $id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $filePath = public_path() . '/uploads/' . $post->image;
        if (file_exists($filePath) && !empty($post->image)) {
            unlink($filePath);
        }

        Post::where('id', $id)->delete();
        return $this->sendResponce($post, 'Your post has been removed');

    }
}
