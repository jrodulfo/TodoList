var todo = new function () {
    this.deleteList = function (listId) {
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
                                location.reload();
                            }
                        });
                    }
                });

            }
        });
    }

    this.showTasks = function(event) {
        listId = $(event.currentTarget).data("list-id");


        // Expand the tasks area
        $("#tasks-" + listId).collapse("toggle");
    }

    this.setEvents = function() {
        $("[data-js-target='show-tasks']").on("click", todo.showTasks);
    }
}

$( window ).load(function() {
    todo.setEvents();
});