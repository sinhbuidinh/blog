function genDatepicker(selector)
{
    $(selector).datepicker({
        todayHighlight: true,
        dateFormat: 'dd-mm-yy',
        startDate: '-0d',
        onSelect: function(datetext) {
            var d = new Date(); // for now
            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h;
            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m;
            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s;
            datetext = datetext + " " + h + ":" + m + ":" + s;
            $(selector).val(datetext);
        }
    });
}
