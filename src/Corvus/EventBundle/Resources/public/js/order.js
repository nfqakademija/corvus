/**
 * Created by Liudas on 2015-12-07.
 */
var ROUNDING = 30 * 60 * 1000; /*ms*/
start = moment();
start = moment(Math.ceil((+start) / ROUNDING) * ROUNDING);
jQuery(document).ready(function() {
    $(":checkbox").on("change", function() {
        var that = this;
        $(this).parent().parent().css("background-color", function() {
            return that.checked ? "#ff4d4d" : "";
        });
    });
    $('#time_input').datetimepicker({
        locale: 'en',
        format: 'YYYY-MM-DD HH:mm',
        minDate: start,
        stepping: 30
    });
});