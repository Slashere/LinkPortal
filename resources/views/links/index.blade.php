@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @can('create-link')
                <a class="btn btn-small btn-success" href="{{ route('create_link') }}">Create Link</a>
            @endcan
            <div class="col-md-8 col-md-offset-2">
                <h2>My links:</h2>
            @foreach ($allMyLinks as $link)
                    <div class="panel panel-default">
                        <div class="panel-heading"><a
                                    href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a>
                        </div>
                        <div class="panel-body">
                            @if ($link->image != NULL)
                                <img src='{{'/images/'. $link->image }}' height="200" width="300" style="background-size: cover;"/>
                            @endif
                            <p>Link: {{$link->link}}</p>
                            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
                            <p>Description: {{$link->description}}</p>
                            <p>Private: {{$link->private}}</p>
                            @can('update-link', $link)
                                <a class="btn btn-small btn-success" href="{{ route('edit_link', $link->id) }}">Edit
                                    this
                                    Link</a>
                            @endcan
                            @can('delete-link', $link)
                            <!-- Delete should be a button -->
                                {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['delete_link', $link->id],
                                        'onsubmit' => "return confirm('Are you sure you want to delete?')",
                                    ]) !!}
                                {!! Form::submit('Delete',['class' => 'btn btn-small btn-danger']) !!}
                                {!! Form::close() !!}
                            <!-- End Delete button -->
                            @endcan
                        </div>


                    </div>

                @endforeach
                    {{ $allMyLinks->links() }}
            </div>
        </div>
    </div>
@endsection

