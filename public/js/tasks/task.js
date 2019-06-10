var Task = new function () {
    this.taskRow =  '<div class="row">'+
                    '   <div class="col-sm-4"></div>'+
                    '   <div class="col-sm-8">'+
                    '        <div class="input-group">'+
                    '            <span class="input-group-addon"><i class="material-icons">list_alt</i></span>'+
                    '           <input type="text" class="form-control" name="taskDescription[]" placeholder="New Task..."/>'+
                    '        </div>'+
                    '   </div>'+
                    '</div>';

    this.addTask = function () {
        var $area = $("#tasksArea");

        if ($area.length !== undefined) {
            // Add new task field
            $area.append($(Task.taskRow));
        }
    }
};
