$(function () {
    $('.txtDateTime').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'vi',
        startDate: '2014-10-10',
        format: 'Y-m-d',
        dateonly: false,
        showHour: false,
        closeOnDateSelect: true,
        showMinute: false,
        timepicker: false,
        onChangeDateTime: function(dp, $input) {
        }
    });
});
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
String.prototype.replaceAll = function(str1, str2, ignore)
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}