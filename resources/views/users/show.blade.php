@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p>Title: {{$user->login}}</p></div>

                    <div class="panel-body">
                        <p>Email: {{$user->email}}</p>
                        <p>Name: {{$user->name}}</p>
                        <p>Surname: {{$user->surname}}</p>
                        <p>Role: {{$myRole}}</p>
                        @can('update-user', $user)
                            <a class="btn btn-small btn-success" href="{{ route('edit_user', $user->id) }}">Edit
                                profile</a>
                        @endcan
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

