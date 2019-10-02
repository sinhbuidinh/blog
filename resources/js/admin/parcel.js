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
$(document).on('paste cut keyup change', '#total_service, #value_declare, #price, #refund, #forward, #price_vat, #cod, #support_remote, #support_gas, #package_price', function(e){
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
        calService();
        return false;
    }
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
    var list_services = $('#services').val();
    //check have package_in
    if (list_services != '') {
        var pack_in = $('tr.service_id_choose input[name="service_id[]"][data-key="package_in"]').val();
        pack_in = formatNumber(pack_in);
        $('#package_price').val(pack_in);
    }
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

    var weight = $('#weight').val();
    var main_price = $('#price').val() != '' ? removeFormat($('#price').val()) : 0;
    var declare = $('#value_declare').val() != '' ? removeFormat($('#value_declare').val()) : 0;
    var price_with_percent = main_price;
    if (!isNotSelected(declare, true)) {
        price_with_percent = declare;
    }
    inputs.each(function(index){
        var math = $(this).data('math');
        var key = $(this).data('key');
        var atleast = typeof $(this).data('atleast') != 'undefined' ? $(this).data('atleast') : '';
        var limit = typeof $(this).data('limit') != 'undefined' ? $(this).data('limit') : '';
        var range = typeof $(this).data('price_range') != 'undefined' ? $(this).data('price_range') : '';
        var name = $(this).data('name');
        var value = $(this).val();
        var package_price = 0;
        if (key == 'package_in') {
            package_price = $('#package_price').val();
            service_price = removeFormat(package_price);
            value = service_price;
        }
        //append price by math
        var cal_services = {
            "key": key,
            "name": name,
            "math": math,
            "value": value,
            "atleast": atleast,
            "limit": limit,
            "range": range,
            "price_with_percent": price_with_percent,
            "main_price": main_price,
        };
        if (key != 'package_in') {
            service_price = getPriceService(weight, cal_services);
        }
        services.push(cal_services);
        display.push(name);
        total += service_price;
    });
    $('#services_display').val(display.join(', '));
    $('#services').val(JSON.stringify(services));
    $("#total_service").val(formatNumber(total));
    closePopup();
    return total;
}
function getPriceService(weight, define)
{
    if (!define.hasOwnProperty('math')
        || !define.hasOwnProperty('value')
        || !define.hasOwnProperty('main_price')
        || !define.hasOwnProperty('price_with_percent')
    ) {
        return 0;
    }
    var range = define.range;
    if (range !== '') {
        return priceByDefine(weight, range);
    }
    // price calculate base on value_declare
    var math = define.math;
    var value = define.value;
    var service_price = parseFloat(value);
    if (math == '*') {
        var price = typeof define.price_with_percent != 'undefined' ? define.price_with_percent : define.main_price;
        service_price = parseFloat(price * value);
    }
    // check limit
    var atleast = define.atleast;
    if (atleast != '' && service_price < parseFloat(atleast)) {
        service_price = atleast;
    }
    var limit = define.limit;
    if (limit != '' && service_price > parseFloat(limit)) {
        service_price = limit;
    }
    return service_price;
}
function priceByDefine(weight, config)
{
    //check exist weight by
    var carat = typeof config.weight_by != 'undefined' ? config.weight_by : '';
    if (carat !== '' && carat === 'gram') {
        weight = weight * 1000;
    }
    //check define by area or not
    var define_area = typeof config.define != 'undefined' ? config.define : '';
    if (define_area !== '') {
        return priceByArea(weight, config);
    }

    //normal case services
    var base = typeof config.base != 'undefined' ? config.base : '';
    var price = 0;
    var calculated_weight = 0;
    if (base === '') {
        return price;
    }
    Object.keys(base).forEach(function(key) {
        price = base[key];
        var floor, ceil, rg;
        rg = key.split('-');
        floor = typeof rg[0] == 'undefined' ? '' : rg[0];
        ceil = typeof rg[1] == 'undefined' ? '' : rg[1];
        if (floor === '' || ceil === '') {
            return;
        }
        if (weight >= floor && (weight <= ceil || ceil === '~')) {
            calculated_weight += (weight - floor); 
            return;
        }
        calculated_weight += (ceil - floor);
    });
    var over = parseFloat(weight - calculated_weight);
    var above = typeof config.above != 'undefined' ? config.above : '';
    if (above === '' || over <= 0) {
        return price;
    }
    var every = typeof above.every != 'undefined' ? above.every : '';
    var config = typeof above.config != 'undefined' ? above.config : '';
    var over_weight = total_over = 0;
    if (config === '') {
        return price;
    }
    Object.keys(config).forEach(function(key) {
        var floor, ceil, rg;
        rg = key.split('-');
        floor = typeof rg[0] == 'undefined' ? '' : rg[0];
        ceil = typeof rg[1] == 'undefined' ? '' : rg[1];
        // find weight apply for price_range
        if (over >= floor && (over <= ceil || ceil === '~')) {
            over_weight = over - floor;
        } else {
            over_weight = ceil - floor;
        }
        // time over for apply price of range
        var times_over = Math.ceil(over_weight/every);
        total_over = (times_over * config[key]);
    });
    return parseFloat(price + total_over);
}
function priceByArea(weight, config)
{
    var define_area = typeof config.define != 'undefined' ? config.define : '';
    if (define_area === '') {
        return 0;
    }
    var area = areaByProvince(define_area);
    //find price with area
    var price = typeof config.price != 'undefined' ? config.price : '';
    if (price === '') {
        return 0;
    }
    var base = typeof price.base != 'undefined' ? price.base : '';
    if (base === '') {
        return 0;
    }
    var base_price = 0;
    var calculated_weight = 0;
    Object.keys(base).forEach(function(key) {
        base_price = base[key].hasOwnProperty(area) ? base[key][area] : 0;
        var floor, ceil, rg;
        rg = key.split('-');
        floor = typeof rg[0] == 'undefined' ? '' : rg[0];
        ceil = typeof rg[1] == 'undefined' ? '' : rg[1];
        if (floor === '' || ceil === '') {
            return;
        }
        if (weight >= floor && (weight <= ceil || ceil === '~')) {
            calculated_weight += (weight - floor); 
            return;
        }
        calculated_weight += (ceil - floor);
    });
    var over = parseFloat(weight - calculated_weight);
    var above = typeof price.above != 'undefined' ? price.above : '';
    if (above === '' || over <= 0) {
        return base_price;
    }
    var every = typeof above.every != 'undefined' ? above.every : '';
    var range = typeof above.range != 'undefined' ? above.range : '';
    var over_weight = 0;
    var total_over = 0;
    if (range === '') {
        return base_price;
    }
    Object.keys(range).forEach(function(key) {
        var floor, ceil, rg;
        rg = key.split('-');
        floor = typeof rg[0] == 'undefined' ? '' : rg[0];
        ceil = typeof rg[1] == 'undefined' ? '' : rg[1];
        // find weight apply for price_range
        if (over >= floor && (over <= ceil || ceil === '~')) {
            over_weight = over - floor;
        } else {
            over_weight = ceil - floor;
        }
        // time over for apply price of range
        var over_price = range[key].hasOwnProperty(area) ? range[key][area] : 0;
        var times_over = Math.ceil(over_weight/every);
        total_over = (times_over * over_price);
    });
    return parseFloat(base_price + total_over);
}
function areaByProvince(define_area)
{
    var province = typeof $('#province').val() != 'undefined' ? $('#province').val() : '';
    province = parseInt(province);
    var keys = Object.keys(define_area);
    var last = keys[keys.length-1];
    if (province === '') {
        return last;
    }
    area = last;
    for (var i = 0; i < keys.length; i++) {
        key = keys[i];
        var areas = define_area[key];
        if (areas.includes(province)) {
            area = key;
            break;
        }
    }
    return area;
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