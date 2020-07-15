@extends('layouts.app')

@section('content')

  @include('admin.includes.errors')

  <div class="card">

      <div class="card-header">Deleted Posts</div>

      <div class="card-body">

        <table class="table table-hover">

          <thead>

            <th>Image</th>
            <th>Title</th>
            <th>Edit</th>
            <th>Trash</th>

          </thead>

          <tbody>

            @if($posts->count() > 0)

              @foreach($posts as $post)

                <tr>

                  <td>

                    <img src="{{ $post->featured }}" alt="{{ $post->title }}" width="90px" height="90px">

                  </td>

                  <td>

                    {{ $post->title}}

                  </td>

                  <td>

                    <a href="{{ route('post.edit', ['id' => $post->id]) }}">
                    <i class="fa fa-edit fa-lg"></i>

                    </a>

                  </td>

                  <td>

                    <a href="{{ route('post.delete', ['id' => $post->id]) }}">
                    <i class="fa fa-trash fa-lg"></i>

                  </td>

                </tr>

              @endforeach

            @else

              <tr>

                <th colspan="5" class="text-center">No Published Posts</th>

              </tr>

            @endif

          </tbody>

        </table>

        <ul class="list-group">

          <li class="list-group-item">

            <a href="{{ route('post.create') }}">Create new Post</a>

          </li>

          <li class="list-group-item">

            <a href="{{ route('posts.trashed') }}">Deleted Posts</a>

          </li>

        </ul>

      </div>

    </div>

@endsection
