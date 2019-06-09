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
                            type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                            closable: true, // <-- Default value is false
                            draggable: true, // <-- Default value is false
                            buttonLabel: 'OK', // <-- Default value is 'OK',
                            callback: function(result) {
                                location.reload();
                            }
                        });
                    }
                });

            }
        });
    }
}
