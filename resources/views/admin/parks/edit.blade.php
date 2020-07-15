@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Edit <area shape="default" coords="" href="#" alt=""> Post</div>

        <div class="card-body">

        <form action="{{ route('park.update', [ 'id' => $park->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

              <label for="parkname">Park Name</label>
              <input type="text" class="form-control" name="parkname" value="{{ $park->parkname }}">

            </div>

            <div class="form-group">
              
              <label for="parkphone">Park Phone</label>
              <input type="text" class="form-control" name="parkphone" value="{{ $park->parkphone }}">

            </div>

            <div class="form-group">
              
              <label for="parkaddress1">Park Address</label>
              <input type="text" class="form-control" name="parkaddress1" value="{{ $park->parkaddress1 }}">

            </div>

            <div class="form-group">
              
              <label for="parkcity">Park City</label>
              <input type="text" class="form-control" name="parkcity" value="{{ $park->parkcity }}">

            </div>

            <div class="form-group">
              
              <label for="parkstate">Park State</label>
              <input type="text" class="form-control" name="parkstate" value="{{ $park->parkstate }}">

            </div>

             <div class="form-group">
              
              <label for="parkzip">Park ZIP</label>
              <input type="text" class="form-control" name="parkzip" value="{{ $park->parkzip }}">

            </div>

            <div class="form-group">
              
              <label for="parkwikilink">Park WikiLink</label>
              <input type="text" class="form-control" name="parkwikilink" value="{{ $park->parkwikilink }}">

            </div>

            <div class="form-group">
              
              <label for="parkurl">Park URL</label>
              <input type="text" class="form-control" name="parkurl" value="{{ $park->parkurl }}">

            </div>

            <div class="form-group">
              
              <label for="parklat">Park Latitude</label>
              <input type="text" class="form-control" name="parklat" value="{{ $park->parklat }}">

            </div>

            <div class="form-group">
              
              <label for="parklon">Park Longitude</label>
              <input type="text" class="form-control" name="parklon" value="{{ $park->parklon }}">

            </div>

             <div class="form-group">
              
              <label for="parkpic">Park Pic URL</label>
              <input type="text" class="form-control" name="parkpic" value="{{ $park->parkpic }}">

            </div>

             <div class="form-group">
              
              <label for="countryid">Park Country</label>
              <input type="text" class="form-control" name="countryid" value="{{ $park->countryid }}">
              
            </div>

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Update Park</button>

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
