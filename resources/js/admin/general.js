function genDatepicker(selector)
{
    $(selector).datepicker({
        todayHighlight: true,
        dateFormat: 'yy-mm-dd',
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
function formatNumber(string)
{
    // return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    var parts = string.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
function removeFormat(number)
{
    var result = number.replace(/,/g, '');
    return parseFloat(result);
}