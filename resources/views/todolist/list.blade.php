@extends('layouts.app')

@section('title', 'Todo Lists')

@section('body-class', 'landing-page')

@section('styles')
    <link href="{{ asset('css/list/list.css') }}" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="{{ asset('js/todo/todo.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="header header-filter">
        
    </div>

    <div class="main main-raised">
        <div class="container">
            <div class="section">
                <h2 class="title text-center">{{ Auth::user()->name }}'s Todo Lists</h2>
                <form method="POST" action="{{ url('/todolist/new') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}"/>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" href="{{ url('/todolist/new') }}" class="btn btn-primary btn-round">New List</button>
                        </div>
                    </div>    
                </form>
                @foreach ($todoLists as $list)
                <div clas="row">
                    <div class="card">
                        <div class="row card-header">
                            <div class="col-md-10" data-js-target="show-tasks" data-list-id="{{ $list->id }}">
                             <!--data-toggle="collapse" data-target="#tasks-{{$list->id}}" aria-expanded="false" aria-controls="tasks-{{$list->id}}">-->
                                <h5 class="card-title">&nbsp;&nbsp;{{ $list->title }}</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" rel="tooltip" title="Edit" class="btn btn-success btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-simple btn-xs" 
                                onclick="todo.deleteList('{{ $list->id }}')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="tasks-{{$list->id}}">
                            <div class="card-body">
                                <div class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</div>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="http://www.creative-tim.com">
                            Creative Tim
                        </a>
                    </li>
                    <li>
                        <a href="http://presentation.creative-tim.com">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="http://blog.creative-tim.com">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="http://www.creative-tim.com/license">
                            Licenses
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright pull-right">
                &copy; 2016, made with <i class="fa fa-heart heart"></i> by Creative Tim
            </div>
        </div>
    </footer>
@endsection
