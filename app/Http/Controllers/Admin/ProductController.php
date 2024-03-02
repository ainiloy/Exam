<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        $objPost = new Product();

        $posts = $objPost->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', 'categories.name as category_name')
            ->orderby('products.id', 'desc')
            ->get();

        return view('admin.product', compact('categories', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'product_name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $cat_slug=Str::slug($request->category_name, '-');

        $data = [
            'product_name' => $request->product_name,
            'slug' => $cat_slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ];

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;


            $thumbnail = Image::make($file);
            $thumbnail->resize(600, 360)->save(public_path('post_thumbnails/' . $filename));

            $data['thumbnail'] = $filename;
        }

        Product::create($data);

        $notify = ['message' => 'Post created successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $request->validate([
            'product_name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $cat_slug=Str::slug($request->category_name, '-');

        $data = [
            'product_name' => $request->product_name,
            'slug' => $cat_slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($request->old_thumb) {
                File::delete(public_path('post_thumbnails/' . $request->old_thumb));
            }
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;


            $thumbnail = Image::make($file);
            $thumbnail->resize(600, 360)->save(public_path('post_thumbnails/' . $filename));

            $data['thumbnail'] = $filename;
        }

        Product::where('id', $id)->update($data);

        $notify = ['message' => 'Post updated successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Product::find($id);
        if ($post->thumbnail) {
            File::delete(public_path('post_thumbnails/' . $post->thumbnail));
        }
        $post->delete();

        $notify = ['message' => 'Post deleted successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }
}
