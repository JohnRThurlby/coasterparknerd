@extends('layouts.app')

@section('content')

  @include('admin.includes.errors')

  <div class="card">

      <div class="card-header">Categories</div>

      <div class="card-body">

        <table class="table table-hover">

          <thead>

            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>

          </thead>

          <tbody>

            @if($categories->count() > 0)

              @foreach($categories as $category)

                <tr>

                  <td>

                    {{ $category->category}}

                  </td>

                  <td>

                    <a href="{{ route('category.edit', ['id' => $category->id]) }}">
                    <i class="fa fa-edit fa-lg"></i>

                    </a>

                  </td>

                  <td>

                    <a href="{{ route('category.delete', ['id' => $category->id]) }}">
                    <i class="fa fa-trash fa-lg"></i>

                  </td>

                </tr>

              @endforeach

            @else

              <tr>

                <th colspan="5" class="text-center">No Categories</th>

              </tr>

            @endif

          </tbody>

        </table>

        <ul class="list-group">

          <li class="list-group-item">

            <a href="{{ route('category.create') }}">Create new category</a>

          </li>

        </ul>

      </div>

    </div>

@endsection
