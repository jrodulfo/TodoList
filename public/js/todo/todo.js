/**
 * Javascript file that holds functionality for "lists" view
 */
var todo = new function () {
    // Variable used to hold a row task on editing
    this.editingTask = '';
    // HTML template for task edition
    this.taskEditRow =  '    <div class="col-md-10">'+
                        '            <div class="input-group">'+
                        '                <span class="input-group-addon"><i class="material-icons">list_alt</i></span>'+
                        '                <input type="text" class="form-control" name="taskDescription" placeholder="Task Description" data-js-target="task-description-{taskId}" value="{description}"/>'+
                        '            </div>'+
                        '    </div>'+
                        '    <div class="col-md-2">'+
                        '        <button type="button" rel="tooltip" title="Update Task" class="btn btn-success btn-simple btn-xs" data-js-target="update-task" data-task-id="{taskId}">'+
                        '            <i class="fa fa-save"></i>'+
                        '        </button>'+
                        '        <button type="button" rel="tooltip" title="Cancel" class="btn btn-danger btn-simple btn-xs" data-js-target="cancel-edit-task" data-task-id="{taskId}">'+
                        '            <i class="fa fa-window-close"></i>'+
                        '        </button>'+
                        '    </div>';
    // HTML template used for restoring task after cancel edition
    this.taskRow=   '<div class="row">'+
                    '    <div class="col-md-12">'+
                    '        {description}'+
                    '    </div>'+
                    '</div>';
    // HTML template for tasks in "Done" status
    this.doneTasksRow = '<div class="row" data-js-target="task-row-{taskId}" data-task-id="{taskId}">'+
                        '    <div class="col-md-10">'+
                        '        <h5>&nbsp;&nbsp;{description}</h5>'+
                        '    </div>'+
                        '    <div class="col-md-2 text-right">'+
                        '        <button type="button" rel="tooltip" title="Delete task" class="btn btn-danger btn-simple btn-xs" data-js-target="delete-task" data-task-id="{taskId}">'+
                        '            <i class="fa fa-times"></i>'+
                        '        </button>'+
                        '    </div>'+
                        '</div>';
    // HTML template used for restoring task after cancel edition
    this.taskDescription =  '        <span class="label label-default move-task" rel="tooltip" title="Move task down" data-js-target="task-down" data-task-id="{taskId}">'+
                            '            <i class="fa fa-angle-down" ></i>'+
                            '        </span>'+
                            '        &nbsp;'+
                            '        <span class="label label-default move-task" rel="tooltip" title="Move task up" data-js-target="task-up" data-task-id="{taskId}">'+
                            '            <i class="fa fa-angle-up" ></i>'+
                            '        </span>'+
                            '        &nbsp;&nbsp;{description}';
    // HTML template for tasks in 'On Going' status
    this.ongoingTasksRow =  '<div class="row" data-js-target="task-row-{taskId}" data-task-id="{taskId}">'+
                            '    <div class="col-md-10">'+
                            '    <h5>'+
                            '        <span class="label label-default move-task" rel="tooltip" title="Move task down" data-js-target="task-down" data-task-id="{taskId}">'+
                            '            <i class="fa fa-angle-down" ></i>'+
                            '        </span>'+
                            '        &nbsp;'+
                            '        <span class="label label-default move-task" rel="tooltip" title="Move task up" data-js-target="task-up" data-task-id="{taskId}">'+
                            '            <i class="fa fa-angle-up" ></i>'+
                            '        </span>'+
                            '        &nbsp;&nbsp;{description}'+
                            '    </h5>'+
                            '    </div>'+
                            '    <div class="col-md-2 text-right">'+
                            '       <button type="button" rel="tooltip" title="Edit task" class="btn btn-info btn-simple btn-xs" data-js-target="edit-task" data-task-id="{taskId}">'+
                            '          <i class="fa fa-edit"></i>'+
                            '        </button>'+
                            '        <button type="button" rel="tooltip" title="Mark as done" class="btn btn-success btn-simple btn-xs" data-js-target="complete-task" data-task-id="{taskId}" data-list-id="{listId}">'+
                            '            <i class="fa fa-check"></i>'+
                            '        </button>'+
                            '        <button type="button" rel="tooltip" title="Delete task" class="btn btn-danger btn-simple btn-xs" data-js-target="delete-task" data-task-id="{taskId}">'+
                            '            <i class="fa fa-times"></i>'+
                            '        </button>'+
                            '    </div>'+
                            '</div>';
    // Deletes a Todo List      
    this.deleteList = function (event) {
        var listId = $(event.currentTarget).data("list-id");
        BootstrapDialog.confirm('Deleting a Todo List will also delete all tasks associated with it, are you sure?', function(result){
            if (result) {
                var dest="/todolist/delete/" + listId;
                $.ajax({
                    url: dest,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: window.Laravel.csrfToken
                    }
                }).done(function (data) {
                    if (data.status == 'success') {
                        BootstrapDialog.alert({
                            title: 'Success',
                            message: 'Todo List was successfully deleted',
                            type: BootstrapDialog.TYPE_PRIMARY, 
                            closable: true, 
                            draggable: true, 
                            buttonLabel: 'OK', 
                            callback: function(result) {
                                $("[data-row-list-id='"+listId+"']").remove();
                            }
                        });
                    }else{
                        BootstrapDialog.alert({
                            title: 'Warning',
                            message: data.message,
                            type: BootstrapDialog.TYPE_PRIMARY, 
                            closable: true, 
                            draggable: true, 
                            buttonLabel: 'OK'
                        });
                    }
                });
            }
        });
    }

    // Gets tasks and renders them
    this.showTasks = function(event) {
        var listId = $(event.currentTarget).data("list-id");
        var panel = $("#tasks-" + listId);
        
        if (panel.is(":visible")) {
            $("#tasks-" + listId).collapse("hide");
            $("[data-js-target='show-content-" + listId + "']").addClass("fa-angle-down");
            $("[data-js-target='show-content-" + listId + "']").removeClass("fa-angle-up");
        } else {
            var dest = "/todolist/tasks/" + listId;
            $.ajax({
                url: dest,
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: window.Laravel.csrfToken
                }
            }).done(function (data) {
                var container = $($("[data-container-id='" + listId + "']")[0]);
                var ongoingContainer = $(container.find(".ongoing-tasks-container")[0]);
                var doneContainer = $(container.find(".done-tasks-container")[0]);

                ongoingContainer.html('');
                var ongoingTasks = data.data[0].ongoing;
                $.each(ongoingTasks, function(index, task) {
                    var row = todo.ongoingTasksRow.replace(/{description}/g, task.description).replace(/{taskId}/g, task.id).replace(/{listId}/g, listId);
                    ongoingContainer.append($($.parseHTML(row)));
                });

                doneContainer.html('');
                var doneTasks = data.data[0].done;
                $.each(doneTasks, function(index, task) {
                    var row = todo.doneTasksRow.replace(/{description}/g, task.description).replace(/{taskId}/g, task.id);
                    doneContainer.append($($.parseHTML(row)));
                });
    
                todo.setDynamicEvents();
            });
            $("#tasks-" + listId).collapse("show");
            $("[data-js-target='show-content-" + listId + "']").removeClass("fa-angle-down");
            $("[data-js-target='show-content-" + listId + "']").addClass("fa-angle-up");
        }
    }

    // Mark task as 'Done'
    this.completeTask = function(event) {
        todo.cancelAllEdits();
        var taskId = $(event.currentTarget).data("task-id");
        var listId = $(event.currentTarget).data("listId");
        $.ajax({
            url: '/todolist/tasks/complete/'+taskId,
            method: 'POST',
            dataType: 'json',
            data: {
                _token: window.Laravel.csrfToken
            }
        }).done(function (data) {
            if (data.status === "success") {
                var container = $($("[data-container-id='" + listId + "']")[0]);
                var doneContainer = $(container.find(".done-tasks-container")[0]);
                var doneTask=$("[data-js-target='task-row-"+taskId+"']");
                $("[data-js-target='complete-task'][data-task-id='" + taskId + "']").remove();
                $("[data-js-target='task-down'][data-task-id='" + taskId + "']").remove();
                $("[data-js-target='task-up'][data-task-id='" + taskId + "']").remove();
                $("[data-js-target='edit-task'][data-task-id='" + taskId + "']").remove();
                // Remove extra spaces left after removing buttons
                var taskDescription="&nbsp;&nbsp;"+doneTask.find("h5").html().replace(/&nbsp;/g,'').trim();
                doneTask.find("h5").html(taskDescription);
                doneTask.appendTo(doneContainer);
            }else{
                BootstrapDialog.alert({
                    title: 'Warning',
                    message: data.message,
                    type: BootstrapDialog.TYPE_PRIMARY, 
                    closable: true, 
                    draggable: true, 
                    buttonLabel: 'OK'
                });
            }
        });
    }

    // Deletes a task
    this.deleteTask = function(event) {
        todo.cancelAllEdits();
        BootstrapDialog.confirm('This will delete the task, are you sure?', function(result){
            if (result) {
                var taskId = $(event.currentTarget).data("task-id");
                $.ajax({
                    url: '/todolist/tasks/delete/'+taskId,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: window.Laravel.csrfToken
                    }
                }).done(function (data) {
                    if (data.status === "success") {
                        $("[data-js-target='task-row-"+taskId+"']").remove();
                    }else{
                        BootstrapDialog.alert({
                            title: 'Warning',
                            message: data.message,
                            type: BootstrapDialog.TYPE_PRIMARY, 
                            closable: true, 
                            draggable: true, 
                            buttonLabel: 'OK'
                        });
                    }
                });
            }
        });
    }
    // Renders the task edit row
    this.editTask = function(event) {
        todo.cancelAllEdits();
        var taskId = $(event.currentTarget).data("task-id");
        var currentRow = $($("[data-js-target='task-row-" + taskId + "']")[0]);
        var currentDescription = currentRow.find("h5").text().trim();
        var row = todo.taskEditRow.replace(/{description}/g, currentDescription).replace(/{taskId}/g, taskId);

        todo.editingTask = currentRow.html();
        currentRow.html('');
        currentRow.html(row);
        todo.setDynamicEvents();
    }
    // Cancels a task edition, restoring original task row
    this.cancelEditTask = function(event) {
        var taskId = $(event.currentTarget).data("task-id");
        var currentRow = $($("[data-js-target='task-row-" + taskId + "']")[0]);
        currentRow.html('');
        currentRow.html(todo.editingTask);
        todo.editingTask = '';
        todo.setDynamicEvents();
    }
    // Saves changes done in edit mode of a task
    this.updateTask = function(event) {
        var taskId = $(event.currentTarget).data("task-id");
        var description = $("[data-js-target='task-description-" + taskId + "']").val();

        $.ajax({
            url: '/todolist/tasks/updateDescription',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: window.Laravel.csrfToken,
                taskDescription: description,
                taskId: taskId
            }
        }).done(function (data) {
            if (data.status === "success") {
                var currentRow = $($("[data-js-target='task-row-" + taskId + "']")[0]);
                currentRow.html('');
                currentRow.html(todo.editingTask);
                currentRow.find("h5").html(todo.taskDescription.replace(/{description}/g, description).replace(/{taskId}/g, taskId));

                todo.editingTask = '';
                todo.setDynamicEvents();
            }else{
                BootstrapDialog.alert({
                    title: 'Warning',
                    message: data.message,
                    type: BootstrapDialog.TYPE_PRIMARY, 
                    closable: true, 
                    draggable: true, 
                    buttonLabel: 'OK'
                });
            }
        });
    }
    // Shows the Add new task row
    this.addTask = function(event) {
        var listId = $(event.currentTarget).data("list-id");

        $("[data-js-target='new-task-" + listId).collapse("show");
    }
    // Hides and clears data on add new task row
    this.cancelTask = function(event) {
        var listId = $(event.currentTarget).data("list-id");

        $("[data-js-target='new-task-input-"+ listId +"']").val('');
        $("[data-js-target='new-task-"+ listId +"']").collapse("hide");
    }
    // Creates a new task based on data input on the new task row
    this.saveTask = function(event) {
        var listId = $(event.currentTarget).data("list-id");
        var taskDescription=$("[data-js-target='task-description-"+ listId +"']").val();

        $.ajax({
            url: '/todolist/tasks/add',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: window.Laravel.csrfToken,
                listId: listId,
                taskDescription: taskDescription
            }
        }).done(function (data) {
            if (data.status === 'success'){
                var container = $($("[data-container-id='" + listId + "']")[0]);
                var ongoingContainer = $(container.find(".ongoing-tasks-container")[0]);

                var task = data.data;
                var row = todo.ongoingTasksRow.replace(/{description}/g, task.description).replace(/{taskId}/g, task.id).replace(/{listId}/g, task.todolist_id);
                ongoingContainer.append($($.parseHTML(row)));
                $("[data-js-target='task-description-"+ listId +"']").val('');
                todo.setDynamicEvents();
            }else{
                BootstrapDialog.alert({
                    title: 'Warning',
                    message: data.message,
                    type: BootstrapDialog.TYPE_PRIMARY, 
                    closable: true, 
                    draggable: true, 
                    buttonLabel: 'OK'
                });
            }
        });
    }
    // Shows the Add Todo List row
    this.addList = function(event) {
        $("[data-js-target='new-list']").collapse("show");
    }
    // Hides the Add Todo List row, and clears any data it has
    this.cancelList = function(event) {
        $("[data-js-target='list-description']").val('');
        $("[data-js-target='new-list']").collapse("hide");        
    }
    // Saves a new list based on data in the Add Todo List row
    this.saveList = function(event) {
        var listDescription=$("[data-js-target='list-description']").val();

        $.ajax({
            url: '/todolist/list/new',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: window.Laravel.csrfToken,
                title: listDescription
            }
        }).done(function (data) {
            if (data.status === 'success'){
                location.reload();
            }else{
                BootstrapDialog.alert({
                    title: 'Warning',
                    message: data.message,
                    type: BootstrapDialog.TYPE_PRIMARY, 
                    closable: true, 
                    draggable: true, 
                    buttonLabel: 'OK', 
                    callback: function(result) {
                    }
                });
            }
        });
        todo.setDynamicEvents();
    }
    // Exchanges task position with the task before it
    this.taskUp = function(event) {
        todo.cancelAllEdits();
        var taskId = $(event.currentTarget).data("task-id");
        var selectedRow = $("[data-js-target='task-row-" + taskId + "']");
        var container = selectedRow.parent();
        var rows = container.find(".row");
        var currentRowTarget = "task-row-" + taskId;

        // Cicle trough all the rows to find the position of the current one
        var position = 0;
        $.each(rows, function(index, row) {
            if ($(row).data("js-target") === currentRowTarget) {
                position = index;
            }
        });

        // Now check if it is not at the top of the list
        if (position > 0) {
            // Get previous row
            var previousRow = $(rows[position-1]);
            var newRow=$(selectedRow[0].outerHTML);
            var taskId2 = previousRow.data("task-id")
            selectedRow.remove();
            newRow.insertBefore(previousRow);
            todo.exchangeTasksOrder(taskId, taskId2);
        }
        todo.setDynamicEvents();

    }
    // Exchanges task position with the task after it
    this.taskDown = function(event) {
        todo.cancelAllEdits();
        var taskId = $(event.currentTarget).data("task-id");
        var selectedRow = $("[data-js-target='task-row-" + taskId + "']");
        var container = selectedRow.parent();
        var rows = container.find(".row");
        var currentRowTarget = "task-row-" + taskId;
        var taskId2 = undefined;

        // Cicle trough all the rows to find the position of the current one
        var position = 0;
        $.each(rows, function(index, row) {
            if ($(row).data("js-target") === currentRowTarget) {
                position = index;
            }
        });

        // Now check if it is not at the top of the list
        if (position < (rows.length-1)) {
            // Get previous row
            var nextRow = $(rows[position+1]);
            var newRow = $(selectedRow[0].outerHTML);
            var taskId2 = nextRow.data("task-id")
            selectedRow.remove();
            newRow.insertAfter(nextRow);
            todo.exchangeTasksOrder(taskId, taskId2);
        }
        todo.setDynamicEvents();
    }
    // Executes the order change for 2 tasks
    this.exchangeTasksOrder = function(taskId1, taskId2) {
        $.ajax({
            url: '/todolist/tasks/exchangeOrder',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: window.Laravel.csrfToken,
                taskId1: taskId1,
                taskId2: taskId2
            }
        }).done(function (data) {
            if (!data.status === 'success'){
                BootstrapDialog.alert({
                    title: 'Warning',
                    message: data.message,
                    type: BootstrapDialog.TYPE_PRIMARY, 
                    closable: true, 
                    draggable: true, 
                    buttonLabel: 'OK', 
                });
            }
        });
    }
    // Sets global events
    this.setEvents = function() {
        // First remove current events
        $("[data-js-target='show-tasks']").off("click.todo");
        $("[data-js-target='delete-list']").off("click.deleteList");
        $("[data-js-target='add-new-task']").off("click.addTask");
        $("[data-js-target='cancel-task']").off("click.cancelTask");
        $("[data-js-target='save-task'").off("click.saveTask");
        $("[data-js-target='add-new-list'").off("click.addList");
        $("[data-js-target='save-list'").off("click.saveList");
        $("[data-js-target='cancel-list'").off("click.cancelList");

        // Now set events
        $("[data-js-target='show-tasks']").on("click.todo", todo.showTasks);
        $("[data-js-target='delete-list']").on("click.deleteList", todo.deleteList);
        $("[data-js-target='add-new-task']").on("click.addTask", todo.addTask);
        $("[data-js-target='cancel-task']").on("click.cancelTask", todo.cancelTask);
        $("[data-js-target='save-task'").on("click.saveTask", todo.saveTask);
        $("[data-js-target='add-new-list'").on("click.addList", todo.addList);
        $("[data-js-target='save-list'").on("click.saveList", todo.saveList);
        $("[data-js-target='cancel-list'").on("click.cancelList", todo.cancelList);

        $( document ).ajaxError(function() {
            BootstrapDialog.alert({
                title: 'Warning',
                message: 'Internal error has happened, page will be reloaded',
                type: BootstrapDialog.TYPE_PRIMARY, 
                closable: true, 
                draggable: true, 
                buttonLabel: 'OK', 
                callback: function(result) {
                    location.reload();
                }
            });
        });
    }
    // Sets events for dynamically created elements
    this.setDynamicEvents = function() {
        // First remove current events
        $("[data-js-target='complete-task']").off("click.completeTask");
        $("[data-js-target='delete-task']").off("click.deleteTask");
        $("[data-js-target='edit-task']").off("click.editTask");
        $("[data-js-target='cancel-task']").off("click.cancelTask");
        $("[data-js-target='save-task']").off("click.saveTask");
        $("[data-js-target='cancel-edit-task']").off("click.cancelEditTask");
        $("[data-js-target='update-task']").off("click.updateTask");
        $("[data-js-target='task-up']").off("click.taskUp");
        $("[data-js-target='task-down']").off("click.taskDown");
        
        // Now set events
        $("[data-js-target='complete-task']").on("click.completeTask", todo.completeTask);
        $("[data-js-target='delete-task']").on("click.deleteTask", todo.deleteTask);
        $("[data-js-target='edit-task']").on("click.editTask", todo.editTask);
        $("[data-js-target='cancel-edit-task']").on("click.cancelEditTask", todo.cancelEditTask);
        $("[data-js-target='cancel-task']").on("click.cancelTask", todo.cancelTask);
        $("[data-js-target='save-task']").on("click.saveTask", todo.saveTask);
        $("[data-js-target='update-task']").on("click.updateTask", todo.updateTask);
        $("[data-js-target='task-up']").on("click.taskUp", todo.taskUp);
        $("[data-js-target='task-down']").on("click.taskDown", todo.taskDown);
    }
    // Hides and clears both edit rows (Add new task and Add new todo list)
    this.cancelAllEdits = function() {
        $('[data-js-target="cancel-task"]').click();
        $('[data-js-target="cancel-edit-task"]').click();
    }
}
// Initializes events after page load
$( window ).load(function() {
    todo.setEvents();
});