$('input[type=file]').change(function(event) {
    $('#pic').val(event.target.files[0].name);
});