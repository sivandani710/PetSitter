$(function() {

    $("#location-input").autocomplete({
        source: "include/search-location.inc.php",
        select: function( event, ui ) {
            event.preventDefault();
            $("#location").val(ui.item.value);
                        $("#location-id").val(ui.item.id);
                        $("#location-input").val(ui.item.value);
        },
        change: function (event, ui) {
            if (ui.item == null || ui.item == undefined) {
                                $("#location").val("");
                                $("#location-id").val("");
                $("#location-input").val("");
                $("#location-input").attr("disabled", false);
            } else {
                $("#location-input").attr("disabled", true);
            }
        }
    });
        
    $('#remove-location').click(function (e) {
    e.preventDefault();
        $("#location").val("");
        $("#location-id").val("");
        $("#location-input").val("");
        $("#location-input").attr("disabled", false);
    });

});