@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Edit <area shape="default" coords="" href="#" alt=""> Rides</div>

        <div class="card-body">

        <form action="{{ route('parkride.update', [ 'id' => $parkride->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

              <label for="parkid">Park ID</label>
              <input type="text" class="form-control" name="parkid" value="{{ $parkride->parkid }}">

            </div>

            <div class="form-group">

              <label for="ridename">Ride Name</label>
              <input type="text" class="form-control" name="ridename" value="{{ $parkride->ridename }}">

            </div>

            <div class="form-group">

              <label for="rideduration">Duration</label>
              <input type="text" class="form-control" name="rideduration" value="{{ $parkride->rideduration }}">

            </div>

            <div class="form-group">

              <label for="rideopened">Opened</label>
              <input type="text" class="form-control" name="rideopened" value="{{ $parkride->rideopened }}">

            </div>

            <div class="form-group">

              <label for="ridespeed">Speed</label>
              <input type="text" class="form-control" name="ridespeed" value="{{ $parkride->ridespeed }}">

            </div>

            <div class="form-group">

              <label for="ridelevel">Level</label>
              <input type="text" class="form-control" name="ridelevel" value="{{ $parkride->ridelevel }}">

            </div>

            <div class="form-group">

              <label for="ridelength">Length</label>
              <input type="text" class="form-control" name="ridelength" value="{{ $parkride->ridelength }}">

            </div>

            <div class="form-group">

              <label for="ridehgtreq">Height Requirement</label>
              <input type="text" class="form-control" name="ridehgtreq" value="{{ $parkride->ridehgtreq }}">

            </div>

            <div class="form-group">

              <label for="ridetype">Ride Type</label>
              <input type="text" class="form-control" name="ridetype" value="{{ $parkride->ridetype }}">

            </div>

            <div class="form-group">

              <label for="rideurl">Ride URL</label>
              <input type="text" class="form-control" name="rideurl" value="{{ $parkride->rideurl }}">

            </div>

            <div class="form-group">

              <label for="ridemanu">Manufacturer</label>
              <input type="text" class="form-control" name="ridemanu" value="{{ $parkride->ridemanu }}">

            </div>

            <div class="form-group">

              <label for="parkareae">Park Area</label>
              <input type="text" class="form-control" name="parkarea" value="{{ $parkride->parkarea }}">

            </div>

            <div class="form-group">

              <label for="rideoccup">Occupancy</label>
              <input type="text" class="form-control" name="rideoccup" value="{{ $parkride->rideoccup }}">

            </div>

            <div class="form-group">

              <label for="ridehgt">Ride Height</label>
              <input type="text" class="form-control" name="ridehgt" value="{{ $parkride->ridehgt }}">

            </div>

            <div class="form-group">

              <label for="ridevehtype">Vehicle Type</label>
              <input type="text" class="form-control" name="ridevehtype" value="{{ $parkride->ridevehtype }}">

            </div>

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Update Ride</button>

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
