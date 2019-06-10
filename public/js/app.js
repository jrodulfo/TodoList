/*
    General use javascript (this one is used in all views)
*/
var todoApp = new function() {
    this.dropUser = function() {
        BootstrapDialog.confirm('This will delete all user data, including lists and tasks, are you sure?', function(result){
            if (result) {
                $("#drop-user-form").submit();
            }
        });
       
    }
}