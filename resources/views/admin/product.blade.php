@extends('admin.layouts.app')

@section('title')
    posts
@endsection

@php
    $page = 'posts';
@endphp

@section('mainpart')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title">All Products</h3>
                <button class="btn btn-primary" data-toggle="modal" data-target="#AddpostModal">Add Product</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $key => $post)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $post->product_name }}</td>
                            <td>{{ $post->category_id }}</td>
                            <td>{{ $post->price}}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="mr-1 btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="{{ '#Edit' . $post->id . 'postModal' }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="delete btn btn-danger btn-sm"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>


                        <!-- post edit Modal-->
                        <div class="modal " id="{{ 'Edit' . $post->id . 'postModal' }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $post->product_name }}</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('post.update', $post->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="put">
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label for="post_name">Product Name</label>
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    value="{{ $post->title }}">
                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="post_name">Slug</label>
                                                <input type="text"
                                                    class="form-control @error('subtitle') is-invalid @enderror"
                                                    name="subtitle" value="{{ $post->slug }}">
                                                @error('subtitle')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="post_name">Product Category</label>
                                                <select name="category_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if ($category->id == $post->category_id) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="post_name">Price</label>
                                                <textarea class="summernote form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ $post->price }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="post_name">Product Image</label>
                                                <input type="file" class="form-control-file" name="image">
                                                <input type="hidden" name="old_thumb" value="{{ $post->image }}">
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-light" type="button" data-dismiss="modal">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Update Product</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- post add Modal-->
    <div class="modal " id="AddpostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="post_name">Product Name</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                name="title" value="{{ old('title') }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post_name">Slug</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                name="subtitle" value="{{ old('subtitle') }}">

                        </div>

                        <div class="form-group">
                            <label for="post_name">Price</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror"
                                name="subtitle" value="{{ old('price') }}">

                        </div>

                        <div class="form-group">
                            <label for="post_name">Post Category</label>
                            <select name="category_id" class="form-control">
                                <option selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="post_name">Post Thumbnail</label>
                            <input type="file" class="form-control-file" name="thumbnail">
                        </div>

                        <label for="status" class="form-check-label">
                            <input type="checkbox" value="1" name="status" id="status"> Public
                        </label>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" type="button" data-dismiss="modal">Cancel</a>
                        <button class="btn btn-primary" type="submit">Add post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
