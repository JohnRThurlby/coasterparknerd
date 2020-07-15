@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Update Category: {{ $category->category }}</div>

        <div class="card-body">

        <form action="{{ route('category.update', [ 'id' => $category->id]) }}" method="POST">

            @csrf

            <div class="form-group">

              <label for="category">Category</label>
              <input type="text" class="form-control" value="{{ $category->category }}" name="category">

            </div>

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Update Category</button>

              </div>

            </div>

        </form>

        </div>
    </div>

@endsection
