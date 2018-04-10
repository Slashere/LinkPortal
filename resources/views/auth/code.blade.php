@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">You need to confirm your account.<br> Check you email or push the button to re-request activation code!
    {!! Form::open(['action' => ['VerifyUserController@updateExpiredTime', $user->id], 'method' => 'post']) !!}
    {{ Form::submit('Send code', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
