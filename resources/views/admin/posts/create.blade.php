@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Create <area shape="default" coords="" href="#" alt=""> Post</div>

        <div class="card-body">

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

              <label for="title">Title</label>
              <input type="text" class="form-control" name="title" value="">

            </div>

            <div class="form-group">

              <label for="content">Content</label>

              <textarea id="content" name="content" class="form-control" cols="5" rows="5"></textarea >

            </div>

            <div class="form-group">

              <label for="category">Select a Category</label>

              <select class="form-control" name="category_id" id="category">

                 @foreach($categories as $category)

                  <option value="{{ $category->id }}">{{ $category->category }}</option>

                 @endforeach

              </select>

            </div>

            <div class="form-group">

              <label for="featured">Featured Image</label>

              <input id="featured" type="file" name="featured" class="form-control" value="">

            </div>

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Create Post</button>

              </div>

            </div>

        </form>

        </div>
    </div>

@endsection

@section('css')

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">

@endsection

@section('js')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>

@endsection
