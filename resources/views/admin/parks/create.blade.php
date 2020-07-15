@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Create <area shape="default" coords="" href="#" alt=""> Park</div>

        <div class="card-body">

        <form action="{{ route('park.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

              <label for="parkname">Park Name</label>
              <input type="text" class="form-control" name="parkname" value="">

            </div>

           

            <div class="form-group">

              <label for="country">Select a Country</label>

              <select class="form-control" name="country_id" id="country">

                 @foreach($countries as $country)

                  <option value="{{ $country->id }}">{{ $country->country }}</option>

                 @endforeach

              </select>

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
