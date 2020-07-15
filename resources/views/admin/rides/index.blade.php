@extends('layouts.app')

@section('content')

  @include('admin.includes.errors')

  <div class="card">

      <div class="card-header">Rides</div>

      <div class="card-body">

        <ul class="list-group">

            <li class="list-group-item">

            <a href="{{ route('parkride.create') }}">Create new Ride</a>

            </li>
         
        </ul>

        <table class="table table-hover">

            <thead>

           
            <th>Ride Name</th>
            <th>Edit</th>
            
            </thead>

            <tbody>

            @if($parkrides->count() > 0)

                @foreach($parkrides as $parkride)

                <tr>
                
                    <td>

                      {{ $parkride->ridename}}

                    </td>

                    <td>

                      <a href="{{ route('parkride.edit', ['id' => $parkride->id]) }}">
                      <i class="fa fa-edit fa-lg"></i>

                      </a>
                            
                    </td>
                                   

                </tr>

                @endforeach

            @else

                <tr>

                <th colspan="5" class="text-center">No Rides</th>

                </tr>

            @endif

            </tbody>

        </table>

      </div>

    </div>

@endsection
