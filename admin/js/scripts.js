$(document).ready(function() {
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



