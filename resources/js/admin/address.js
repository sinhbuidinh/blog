var please_choose_district = 'Chọn quận/huyện';
var please_choose_ward = 'Chọn xã/phường';

$(document).on('change', '#province', function(){
    var select_province = $(this).find(":selected");
    var url = select_province.data('districts');
    if (typeof url == 'undefined') {
        return false;
    }
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
        error: function(){
            alert('district error');
        }
    });
});
function displayAddress(province, district, ward)
{
    province = typeof province !== 'undefined' ? province : '';
    district = typeof district !== 'undefined' ? district : '';
    ward     = typeof ward !== 'undefined' ? ward : '';
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
    var districts = '<select name="district" class="full_width form-control" id="district">';
    districts += optionDistrict(please_choose_district, '', '');
    $.each(data, function(key, value) {
        var name = value.name_with_type;
        var code = value.code;
        var display = value.name_with_type;
        var url = '/ajax/get_wards/' + code;
        districts += optionDistrict(name, code, url, display);
    });
    districts += '</select>';
    $('#district').remove();
    $('#div_districts').append(districts);
}
function optionDistrict(name, code, url, display)
{
    return '<option value="'+code+'" data-display="'+display+'" data-wards="'+url+'">'+name+'</option>';
}
$(document).on('change', '#district', function(){
    var select_district = $(this).find(":selected");
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
        error: function(){
            alert('ward error');
        }
    });
});
function genWards(data)
{
    if (typeof data != 'object' || Object.keys(data).length <= 0) {
        return false;
    }
    var wards = '<select name="ward" class="full_width form-control" id="ward">';
    wards += optionWard(please_choose_ward, '', '');
    $.each(data, function(key, value) {
        var name = value.name_with_type;
        var code = value.code;
        var display = value.name_with_type;
        wards += optionWard(name, code, display);
    });
    wards += '</select>';
    $('#ward').remove();
    $('#div_wards').append(wards);
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