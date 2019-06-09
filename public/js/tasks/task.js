var Task = new function () {
    this.addTask = function () {
        var $area = $("#tasksArea");

        if ($area.length !== undefined) {
            // Add new task field
            var row=$('<div class="row">');
            row.append($('<div class="col-lg-4"></div>'));
            var col=$('<div class="col-sm-8"></div>');
                    
                    
            var newDiv = $('<div class="input-group">');
            newDiv.append($('<span class="input-group-addon"><i class="material-icons">list_alt</i></span>'));
            newDiv.append($('<input type="text" class="form-control" name="taskDescription[]" placeholder="New Task..."/>'));
            col.append(newDiv);
            row.append(col);
            //$area.append(newDiv);
            $area.append(row);
        }
    }

};


console.log(" ----------------------------------- task");