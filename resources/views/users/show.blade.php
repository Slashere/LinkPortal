@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <h2>User:</h2>

                <div class="panel panel-default">
                    <div class="panel-heading"><p>Title: {{$user->login}}</p></div>

                    <div class="panel-body">
                        <p>Email: {{$user->email}}</p>
                        <p>Name: {{$user->name}}</p>
                        <p>Surname: {{$user->surname}}</p>
                        <p>Role: {{$user->role->name}}</p>
                        @can('update-user', $user)
                            <a class="btn btn-small btn-success" href="{{ route('edit_user', $user->id) }}">Edit
                                profile</a>
                        @endcan
                    </div>

                </div>
                <h2>User links:</h2>
                @foreach ($links as $link)
                    <div class="panel panel-default">
                        <div class="panel-heading"><a
                                    href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a></div>
                        <div class="panel-body">
                            <p>Link: {{$link->link}}</p>
                            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
                            <p>Description: {{$link->description}}</p>
                            @can('update-link', $link)
                                <p>Private: {{$link->private}}</p>
                            @endcan
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
                {{ $links->links() }}
            </div>
        </div>
    </div>
@endsection

