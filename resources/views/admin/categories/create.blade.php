@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Create Category</div>

        <div class="card-body">

        <form action="{{ route('category.store') }}" method="POST">

            @csrf

            <div class="form-group">

              <label for="category">Category</label>
              <input type="text" class="form-control" name="category" value="">

            </div>

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Create Category</button>

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
