@extends('layouts.app')

@section('content')

    @include('admin.includes.errors')

    <div class="card">
        <div class="card-header">Create <area shape="default" coords="" href="#" alt=""> Ride</div>

        <div class="card-body">

        <form action="{{ route('parkride.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

           <div class="form-group">

              <label for="parkid">Park ID</label>
              <input type="text" class="form-control" name="parkid" value="">

            </div>

            <div class="form-group">

              <label for="ridename">Ride Name</label>
              <input type="text" class="form-control" name="ridename" value="">

            </div>

            <div class="form-group">

              <label for="rideduration">Duration</label>
              <input type="text" class="form-control" name="rideduration" value="">

            </div>

            <div class="form-group">

              <label for="rideopened">Opened</label>
              <input type="text" class="form-control" name="rideopened" value="">

            </div>

            <div class="form-group">

              <label for="ridespeed">Speed</label>
              <input type="text" class="form-control" name="ridespeed" value="">

            </div>

            <div class="form-group">

              <label for="ridelevel">Level</label>
              <input type="text" class="form-control" name="ridelevel" value="">

            </div>

            <div class="form-group">

              <label for="ridelength">Length</label>
              <input type="text" class="form-control" name="ridelength" value="">

            </div>

            <div class="form-group">

              <label for="ridehgtreq">Height Requirement</label>
              <input type="text" class="form-control" name="ridehgtreq" value="">

            </div>

            <div class="form-group">

              <label for="ridetype">Ride Type</label>
              <input type="text" class="form-control" name="ridetype" value="">

            </div>

            <div class="form-group">

              <label for="rideurl">Ride URL</label>
              <input type="text" class="form-control" name="rideurl" value="">

            </div>

            <div class="form-group">

              <label for="ridemanu">Manufacture</label>
              <input type="text" class="form-control" name="ridemanu" value="">

            </div>

            <div class="form-group">

              <label for="parkareae">Park Area</label>
              <input type="text" class="form-control" name="parkarea" value="">

            </div>

            <div class="form-group">

              <label for="rideoccup">Occupancy</label>
              <input type="text" class="form-control" name="rideoccup" value="">

            </div>

            <div class="form-group">

              <label for="ridehgt">Ride Height</label>
              <input type="text" class="form-control" name="ridehgt" value="">

            </div>

            <div class="form-group">

              <label for="ridevehtype">Vehicle Type</label>
              <input type="text" class="form-control" name="ridevehtype" value="">

            </div> 

            <div class="form-group">

              <div class="text-center">

                <button type="submit" class="btn btn-success btn-small">Create Ride</button>

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
