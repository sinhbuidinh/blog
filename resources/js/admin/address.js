var please_choose_district = 'Chọn quận/huyện';
var please_choose_ward = 'Chọn xã/phường';

$(function(){
    $('select.search').select2();
});
$(document).on('change', '#province', function(){
    var select_province = $(this).find(":selected");
    actionProvince(select_province);
});
function actionProvince(select_province)
{
    select_province = typeof select_province !== 'undefined' ? select_province : $('#province').find(':selected');
    if (typeof select_province.data('districts') == 'undefined') {
        return false;
    }
    var error_before = $('#div_provinces').find('.common_form_error');
    if (typeof error_before != 'undefined' && error_before.length > 0) {
        error_before.remove();
        $('#province').removeClass('is-invalid');
        removeErrorAddrBefore();
    }
    var url = select_province.data('districts');
    province_name = select_province.data('display');
    displayAddress(province_name);
    $.ajax({
        type: "POST",
        url: url,
        data: {},
        dataType: 'json',
        success: function(data){
            genDistricts(data);
        },
        error: function(xhr, status, error){
            alert('district error: ' + error);
        }
    });
}
function removeErrorAddrBefore()
{
    var error_before = $('#div_address').find('.common_form_error');
    if (typeof error_before != 'undefined' && error_before.length > 0) {
        error_before.remove();
        $('#address').removeClass('is-invalid');
    }
}
function displayAddress(province, district, ward)
{
    province = typeof province !== 'undefined' ? province : '';
    district = typeof district !== 'undefined' ? district : '';
    ward     = typeof ward     !== 'undefined' ? ward     : '';
    var result = '';
    if (ward != '') {
        if (result != '') {
            result += ', ';
        }
        result += ward;
    }
    if (district != '') {
        if (result != '') {
            result += ', ';
        }
        result += district;
    }
    if (province != '') {
        if (result != '') {
            result += ', ';
        }
        result += province;
    }
    $('#address').val(result);
    return result;
}
function genDistricts(data)
{
    if (typeof data != 'object' || Object.keys(data).length <= 0) {
        return false;
    }
    var error_before = $('#div_districts').find('.common_form_error');
    if (typeof error_before != 'undefined' && error_before.length > 0) {
        error_before.remove();
        $('#district').removeClass('is-invalid');
        removeErrorAddrBefore();
    }
    var districts = '<select name="district" class="full_width form-control search" id="district">';
    districts += optionDistrict(please_choose_district, '', '');
    $.each(data, function(key, value) {
        var name = value.name_with_type;
        var code = value.code;
        var display = value.name_with_type;
        var url = '/ajax/get_wards/' + code;
        districts += optionDistrict(name, code, url, display);
    });
    districts += '</select>';
    // $('#district').remove();
    $('#div_districts').html('');
    $('#div_districts').find('div.common_form_error').remove();
    $('#div_districts').append(districts);
    $('#district').select2();
}
function optionDistrict(name, code, url, display)
{
    return '<option value="'+code+'" data-display="'+display+'" data-wards="'+url+'">'+name+'</option>';
}
$(document).on('change', '#district', function(){
    var select_district = $(this).find(":selected");
    actionDistrict(select_district);
});
function actionDistrict(select_district)
{
    var url = select_district.data('wards');
    if (typeof url == 'undefined') {
        return false;
    }
    district_name = select_district.data('display');
    select_province = $('#province').find(':selected');
    province_name = select_province.data('display');
    displayAddress(province_name, district_name);
    $.ajax({
        type: "POST",
        url: url,
        data: {},
        dataType: 'json',
        success: function(data){
            genWards(data);
        },
        error: function(xhr, status, error){
            alert('ward error: ' + error);
        }
    });
}
function genWards(data)
{
    if (typeof data != 'object' || Object.keys(data).length <= 0) {
        return false;
    }
    var error_before = $('#div_wards').find('.common_form_error');
    if (typeof error_before != 'undefined' && error_before.length > 0) {
        error_before.remove();
        $('#ward').removeClass('is-invalid');
        removeErrorAddrBefore();
    }
    var wards = '<select name="ward" class="full_width form-control search" id="ward">';
    wards += optionWard(please_choose_ward, '', '');
    $.each(data, function(key, value) {
        var name = value.name_with_type;
        var code = value.code;
        var display = value.name_with_type;
        wards += optionWard(name, code, display);
    });
    wards += '</select>';
    // $('#ward').remove();
    $('#div_wards').html('');
    $('#div_wards').append(wards);
    $('#ward').select2();
}
function optionWard(name, code, display)
{
    return '<option value="'+code+'" data-display="'+display+'">'+name+'</option>';
}
$(document).on('change', '#ward', function(){
    var select_ward = $(this).find(":selected");
    ward_name = select_ward.data('display');
    select_province = $('#province').find(':selected');
    province_name = select_province.data('display');
    select_district = $('#district').find(':selected');
    district_name = select_district.data('display');
    displayAddress(province_name, district_name, ward_name);
});