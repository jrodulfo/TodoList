@extends('layouts.app')

@section('title', 'Add new list')

@section('body-class', 'landing-page')

@section('scripts')
    <script src="{{ asset('js/tasks/task.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="header header-filter"></div>

<div class="main main-raised">
    <div class="container">

        <div class="section">
            <h2 class="title text-center">Add new Todo List</h2>

            <form method="POST" action="{{ url('/todolist/new') }}">
                {{ csrf_field() }}
                <input type="hidden" name="userId" value="{{ Auth::user()->id }}"/>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">assignment</i>
                            </span>
                            <input type="text" class="form-control" name="title" placeholder="List Title..."/>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="material-icons">list_alt</i></span>
                            <input type="text" class="form-control" name="taskDescription[]" placeholder="New Task..."/>
                        </div>
                    </div>
                </div>

                <div id="tasksArea">
                </div>

                <div class="row">
                    <div class="col-lg-4 "></div>
                    <div class="col-sm-8 ">
                        <div class="input-group">
                            <a href="javascript:#" onclick="Task.addTask()">
                                <span class="label label-primary">New Task</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row text-right">
                    <div class="col-sm-12">
                        <a href="{{ url('/todolist/list') }}" class="btn btn-danger">Cancel</a>
                        <button class="btn btn-primay ">Create List</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
