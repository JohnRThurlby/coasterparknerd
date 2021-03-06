@extends('layouts.app')

@section('content')

  @include('admin.includes.errors')

  <div class="card">

      <div class="card-header">Parks</div>

      <div class="card-body">

       <ul class="list-group">

          <li class="list-group-item">

            <a href="{{ route('park.create') }}">Create new Park</a>

          </li>
         
        </ul>

        <table class="table table-hover">

          <thead>

           
            <th>Park Name</th>
            <th>Edit</th>
            
          </thead>

          <tbody>

            @if($parks->count() > 0)

              @foreach($parks as $park)

                <tr>
                
                  <td>

                    {{ $park->parkname}}

                  </td>

                  <td>

                    <a href="{{ route('park.edit', ['id' => $park->id]) }}">
                    <i class="fa fa-edit fa-lg"></i>

                    </a>

                  </td>

                </tr>

              @endforeach

            @else

              <tr>

                <th colspan="5" class="text-center">No Parks</th>

              </tr>

            @endif

          </tbody>

        </table>

      </div>

    </div>

@endsection
