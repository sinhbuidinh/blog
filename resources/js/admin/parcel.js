function formatNumber(string)
{
    string = removeFormat(string);
    // return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    var parts = string.toString().split(".");
    if (isNotSelected(parts[0], true)) {
        return 0;
    }
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
function removeFormat(number)
{
    if (typeof number == 'undefined' || number == null) {
        return 0;
    }
    var result = number.toString().replace(/,/g, '');
    return isNaN(parseFloat(result)) ? 0 : parseFloat(result);
}
function formatNumberObject(obj)
{
    var old_val = obj.val();
    obj.val(formatNumber(old_val));
}
$(function(){
    $('.datepicker').datepicker({
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
            $('.datepicker').val(datetext);
        }
    });
    var guest = $('#guest_id').find(':selected');
    displayGuestInfo(guest);
    calculateTotal();
});
$(document).on('paste cut keyup change', '#weight', function(e){
    var weight = $(this).val();
    if (isNotSelected(weight, 0)) {
        return false;
    }
    $('#real_weight').val(weight);
});
$(document).on('paste cut keyup change', '#service_type, #parcel_type, #long, #wide, #height', function(e){
    if ($('#parcel_type').val() != $('#parcel_type_pack').val()) {
        return false;
    }
    var long, wide, height, type, weight, real, transfer_define;
    long   = $('#long').val();
    wide   = $('#wide').val();
    height = $('#height').val();
    if (isNotSelected(long, true)
        || isNotSelected(wide, true)
        || isNotSelected(height, true)
    ) {
        return false;
    }
    type   = $('#service_type').val();
    if (type == $('#service_type_quick').val()) {
        transfer_define = $('#fast_transfer_weight').val();
    } else if (type == $('#service_type_trans').val()) {
        transfer_define = $('#delivery_transfer_weight').val();
    } else {
        return false;
    }
    if (isNotSelected(transfer_define, true)) {
        return false;
    }
    weight = real = (long * wide * height) / transfer_define;
    $('#weight').val(weight);
    $('#real_weight').val(real);
});
$(document).on('paste cut keyup change', '#total_service, #value_declare, #price, #refund, #forward, #price_vat, #cod, #support_remote, #support_gas', function(e){
    formatNumberObject($(this));
});
$(document).on('paste cut keyup change', '#total_service, #value_declare, #price, #refund, #forward, #vat, #price_vat, #cod, #support_remote_rate, #support_remote, #support_gas_rate, #support_gas, #total', function(e){
    calculateTotal();
});
$(document).on('paste cut keyup change', '#province, #district, #ward, #guest_id, #service_type, #parcel_type, #weight, #real_weight', function(e){
    var province      = $('#province').val();
    var district      = $('#district').val();
    var ward          = $('#ward').val();
    var guest         = $('#guest_id').val();
    var service_type  = $('#service_type').val();
    var type          = $('#parcel_type').val();
    var weight        = $('#weight').val();
    var real_weight   = $('#real_weight').val();
    if (isNotSelected(province)
        || isNotSelected(district)
        || isNotSelected(guest)
        || isNotSelected(service_type)
        || isNotSelected(type)
        || isNotSelected(weight)
        || isNotSelected(real_weight)
    ) {
        // console.log('not enough params');
        return false;
    }
    // console.log('re-calculate price');
    $('#price').removeClass('is-invalid');
    var data = {
        province: province,
        district: district,
        ward: ward,
        guest: guest,
        service_type: service_type,
        type: type,
        weight: weight,
        real_weight: real_weight
    };
    calPrice(data);
});
function calGas()
{
    var price   = getPrice('#price');
    var refund  = getPrice('#refund');
    var forward = getPrice('#forward');
    var remote  = getPrice('#support_remote');
    var total   = parseFloat(price) + parseFloat(refund) 
    + parseFloat(forward) + parseFloat(remote);
    var rate = $('#support_gas_rate').val();
    var gas = parseFloat(total * rate) / 100;
    $('#support_gas').val(formatNumber(gas));
    return gas;
}
function calRemote()
{
    var price = getPrice('#price');
    var is_cal_remote = $('#cal_remote').val();
    if (price == 0 || is_cal_remote == 0) {
        $('#support_remote').val('');
        return 0;
    }
    var rate   = $('#support_remote_rate').val();
    var remote = parseFloat(price * rate) / 100;
    $('#support_remote').val(formatNumber(remote));
    return remote;
}
function calVat()
{
    var percent = $('#vat').val();
    var service = getPrice('#total_service');
    var price   = getPrice('#price');
    var gas     = getPrice('#support_gas');
    var remote  = getPrice('#support_remote');
    var vat     = parseFloat(price) + parseFloat(service) + parseFloat(gas) + parseFloat(remote);
    vat         = parseFloat(vat * percent)/100;
    $('#price_vat').val(formatNumber(vat));
    return vat;
}
function calTotal()
{
    var price   = removeFormat(getPrice('#price'));
    var service = removeFormat(getPrice('#total_service'));
    var refund  = removeFormat(getPrice('#refund'));
    var forward = removeFormat(getPrice('#forward'));
    var vat     = removeFormat(getPrice('#price_vat'));
    var cod     = removeFormat(getPrice('#cod'));
    var gas     = removeFormat(getPrice('#support_gas'));
    var remote  = removeFormat(getPrice('#support_remote'));
    var total   = parseFloat(price) + parseFloat(service) + parseFloat(refund) 
    + parseFloat(forward) + parseFloat(vat) + parseFloat(cod)
    + parseFloat(gas) + parseFloat(remote);
    $('#total').val(formatNumber(total));
    return total;
}
function calPrice(input_obj)
{
    //ajax cal
    $.ajax({
        type: "POST",
        url: $('#url_get_price').val(),
        data: input_obj,
        dataType: 'json',
        success: function(data){
            $('#price').val(data.total_format);
            $('#cal_remote').val(0);
            if (typeof data.cal_remote != 'undefined') {
                $('#cal_remote').val(1);
            }
            calculateTotal();
        },
        error: function(xhr, status, error){
            console.log('url_get_price error: ' + error);
        }
    });
}
function isNotSelected(value, checkzero)
{
    var checkzero = typeof checkzero != 'undefined' ? true : false;
    if (checkzero === true && value == 0) {
        return true;
    }
    if (typeof value == 'undefined' || value == '') {
        return true;
    }
    return false;
}
function getPrice(selector, format)
{
    var format = typeof format != 'undefined' ? true : false;
    var price = $(selector).val() != '' ? $(selector).val() : 0;
    if (format === true) {
        return price;
    }
    return removeFormat(price);
}
$(document).on('click', '#add_services', function(){
    calculateTotal();
});
function calculateTotal()
{
    calService();
    calVat();
    calRemote();
    calGas();
    calTotal();
}
function calService()
{
    var inputs = $('tr.service_id_choose input[name="service_id[]"]:checked');
    var display = [];
    var services = [];
    var total = 0;
    if (inputs.length <= 0) {
        $('#services_display').val('');
        $('#services').val('');
        $("#total_service").val(0);
        closePopup();
        return 0;
    }

    var price = $('#price').val() != '' ? removeFormat($('#price').val()) : 0;
    var declare = $('#value_declare').val() != '' ? removeFormat($('#value_declare').val()) : 0;
    var service_price_percent = price;
    if (!isNotSelected(declare, true)) {
        service_price_percent = declare;
    }
    inputs.each(function(index){
        var math = $(this).data('math');
        var key = $(this).data('key');
        var atleast = typeof $(this).data('atleast') != 'undefined' ? $(this).data('atleast') : '';
        var limit = typeof $(this).data('limit') != 'undefined' ? $(this).data('limit') : '';
        var name = $(this).data('name');
        var value = $(this).val();
        //append price by math
        services.push({
            "key": key,
            "name": name,
            "math": math,
            "value": value,
        });
        display.push(name);
        if (math == '*') {
            service_price = parseFloat(service_price_percent * value);
        } else {
            service_price = parseFloat(value);
        }
        // check limit
        if (atleast != '' && service_price < parseFloat(atleast)) {
            service_price = atleast;
        }
        if (limit != '' && service_price > parseFloat(limit)) {
            service_price = limit;
        }
        total += service_price;
    });
    $('#services_display').val(display.join(', '));
    $('#services').val(JSON.stringify(services));
    $("#total_service").val(formatNumber(total));
    closePopup();
    return total;
}
//function add service & price
function closePopup(selector)
{
    selector = typeof selector !== 'undefined' ? selector : '#services_list_model';
    $(selector).find('.modal-header button.close').click();
}
$(document).on('change', '#guest_id', function(){
    var guest = $(this).find(':selected');
    if (typeof guest != 'undefined' && typeof guest.data('code') != 'undefined') {
        $('#guest_id').removeClass('is-invalid');
    }
    displayGuestInfo(guest);
});
function displayGuestInfo(guest)
{
    var company_name = typeof guest.data('company_name') != 'undefined' ? guest.data('company_name') : '';
    var company_province = typeof guest.data('province_name') != 'undefined' ? guest.data('province_name') : '';
    var company_district = typeof guest.data('district_name') != 'undefined' ? guest.data('district_name') : '';
    var company_ward = typeof guest.data('ward_name') != 'undefined' ? guest.data('ward_name') : '';
    var company_address = typeof guest.data('address') != 'undefined' ? guest.data('address') : '';
    var guest_code = typeof guest.data('code') != 'undefined' ? guest.data('code') : '';
    $('#company_name').val(company_name);
    $('#company_province').val(company_province);
    $('#company_district').val(company_district);
    $('#company_ward').val(company_ward);
    $('#company_address').val(company_address);
    $('#guest_code').val(guest_code);
}
$(document).on('click', '#back_index', function(){
    var location = $(this).data('location');
    window.location.href = location;
});
$(document).on('click', '#create_parcel', function(){
    $(this).attr("disabled", true);
    $(this).html('Sending, please wait...');
    $('#parcel_form').submit();
});
$(document).on('click', 'tr.service_id_choose', function(){
    var id = $(this).find('input[name="service_id[]"]');
    if (id.attr('checked') == 'checked') {
        id.attr('checked', false);
        $(this).removeClass('table-success');
    } else {
        id.attr('checked', true);
        $(this).addClass('table-success');
    }
});