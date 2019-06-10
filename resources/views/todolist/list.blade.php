@extends('layouts.app')

@section('title', 'Todo Lists')

@section('styles')
    <link href="{{ asset('css/list/list.css') }}" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="{{ asset('js/todo/todo.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="header header-filter list-header" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="title list-title">Todo Lists</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="main main-raised">
        <div class="container">
            <div class="section">
                @foreach ($todoLists as $list)
                    <div clas="row" data-row-list-id="{{ $list->id }}">
                        <div class="card">
                            <div class="row card-header list-name">
                                <div class="col-md-10" data-js-target="show-tasks" data-list-id="{{ $list->id }}">
                                    <h5 class="card-title">
                                    <button type="button" rel="tooltip" title="Show/Hide Tasks" class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-angle-down" data-ja-target="show-content-{{ $list->id }}"></i>
                                    </button>
                                    {{ $list->title }}</h5>
                                </div>
                                <div class="col-md-2 text-right">
                                    <button type="button" rel="tooltip" title="Edit list" class="btn btn-info btn-simple btn-xs" data-js-target="edit-list" data-list-id="{{ $list->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-simple btn-xs" data-js-target="delete-list" data-list-id="{{ $list->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="collapse" id="tasks-{{$list->id}}">
                                <div class="card-body" data-container-id="{{ $list->id }}">
                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <h6 class="card-header card-subtitle mb-2 text-muted">On-going tasks</h6>
                                        </div>
                                     </div>

                                    <div class="ongoing-tasks-container"></div>

                                    <div class="collapse" data-js-target="new-task-{{$list->id}}">
                                        <div class="row" data-js-target="new-task-area">
                                            <div class="col-md-10">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="material-icons">list_alt</i></span>
                                                        <input type="text" class="form-control" name="taskDescription" placeholder="Task Description" data-js-target="task-description-{{ $list->id }}"/>
                                                    </div>
                                            </div>
                                            <div class="col-md-2 padding-top-20">
                                                <button type="button" rel="tooltip" title="Save Task" class="btn btn-success btn-simple btn-xs" data-js-target="save-task" data-list-id="{{ $list->id }}">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Cancel" class="btn btn-danger btn-simple btn-xs" data-js-target="cancel-task" data-list-id="{{ $list->id }}">
                                                    <i class="fa fa-window-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" rel="tooltip" title="Add New Task" class="btn btn-info btn-info btn-xs" data-js-target="add-new-task" data-list-id="{{ $list->id }}">
                                                Add Task
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <h6 class="card-header card-subtitle mb-2 text-muted">Finished tasks</h6>
                                        </div>
                                    </div>
                                    <div class="done-tasks-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="collapse" data-js-target="new-list">
                    <div class="row" data-js-target="new-list-area">
                        <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">list</i></span>
                                    <input type="text" class="form-control" name="listTitle" placeholder="List Name" data-js-target="list-description"/>
                                </div>
                        </div>
                        <div class="col-md-2 padding-top-20">
                            <button type="button" rel="tooltip" title="Save Task" class="btn btn-success btn-simple btn-xs" data-js-target="save-list">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" rel="tooltip" title="Cancel" class="btn btn-danger btn-simple btn-xs" data-js-target="cancel-list">
                                <i class="fa fa-window-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" rel="tooltip" title="Add New List" class="btn btn-info btn-primary btn-xs" data-js-target="add-new-list">
                            Add New List
                        </button>
                    </div>
                </div>
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
