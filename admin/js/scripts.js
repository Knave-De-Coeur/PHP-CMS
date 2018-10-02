var div_box = "<div id='load-screen'><div id='loading'></div></div>";

$('body').prepend(div_box);

$(document).ready(function() {


    $("#load-screen").delay(700).fadeOut(600, function () {
        $(this).remove();
    });

    $('#selectAllBoxes').change(function () {
        if (this.checked) {
            $('.checkboxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkboxes').each(function () {
                this.checked = false;
            });
        }
    });

    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
});

function loadUsersOnline() {
    $.get("includes/admin_functions.php?onlineusers=result", function (data) {
        $(".usersonline").text(data);
    });
}

setInterval(function () {

    loadUsersOnline();

}, 500);

