function editExistsDate(dateId){
    $form = $("#date" + dateId + '-form');
    $form.removeClass('hidden');
    $readonly = $("#date" + dateId + '-readonly');
    $readonly.addClass('hidden');

    $fromDate = $("#from-date" + dateId);
    $fromhour = $("#from-hour" + dateId);
    $toDate = $("#to-date" + dateId);
    $toHour = $("#to-hour" + dateId);

    $inputDatePicker = $("#date" + dateId + '-input');
    $inputDatePicker.daterangepicker({
        timePicker: true,
        startDate: moment($fromDate[0].value + ' ' + $fromhour[0].value, 'DD/MM/YYYY HH:mm'),
        endDate: moment($toDate[0].value + ' ' + $toHour[0].value, 'DD/MM/YYYY HH:mm'),
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
    });
}

function cancelExistsDate(dateId){
    $form = $("#date" + dateId + '-form');
    $form.addClass('hidden');
    $readonly = $("#date" + dateId + '-readonly');
    $readonly.removeClass('hidden');
}

$(document).ready(function() {
    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
    });
});