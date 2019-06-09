@extends('layouts.app')

@section('body-class', 'signup-page')

@section('content')
<div class="header header-filter">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="card card-signup">
                    <div class="header header-primary text-center">
                        <h4>Restricted Content</h4>
                    </div>
                    <div class="content">
                        You need to have an user and be logged in to access this page

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="{{ url('/login' ) }}" class="btn btn-default">
                                    Login
                                </a>
                                <a href="{{ url('/register' ) }}" class="btn btn-default">
                                    Register
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
