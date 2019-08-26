$(function(){
    $(document).on('click', '#refund_parcel, #close_package', function(){
        //if not have data parcel => alert
        var parcels = $('tr[id^="parcel_code_"]');
        if (typeof parcels == 'undefined' || parcels.length == 0) {
            $('#button_none_parcel').click();
            return false;
        }
        $('#parcel_form').submit();
    });
    $("#parcel_code").select2();
    $('#parcel_code').on('select2:select', function (e) {
        var data = dataFromSelect(e);
        if (data === false) {
            return false;
        }
        genParcel(data);
        var old_num = $('#number_parcel').html();
        $('#number_parcel').html(parseInt(old_num) + 1);
    });
    $('#parcel_code').on('select2:unselect', function (e) {
        var data = dataFromSelect(e);
        if (data === false) {
            return false;
        }
        removeParcel(data);
        var old_num = $('#number_parcel').html();
        $('#number_parcel').html(parseInt(old_num) - 1);
    });
    function dataFromSelect(e)
    {
        var data = e.params.data;
        if (typeof data.element == 'undefined' || typeof data.element.dataset == 'undefined') {
            return false;
        }
        data = data.element.dataset;
        var code = typeof data.code != 'undefined' ? data.code : '';
        if (code == '') {
            return false;
        }
        return data;
    }
    function removeParcel(data)
    {
        var code = typeof data.code != 'undefined' ? data.code : '';
        if (code == '') {
            return false;
        }
        var isExist = isExistParcel(code);
        if (isExist === false) {
            return false;
        }
        $('tr[id="parcel_code_'+code+'"]').remove();
    }
    function genParcel(data)
    {
        var code = typeof data.code != 'undefined' ? data.code : '';
        if (code == '') {
            return false;
        }
        var isExist = isExistParcel(code);
        if (isExist !== false) {
            return false;
        }
        var html = genRow(code, data);
        $('#parcels_body').append(html);
    }
    function isExistParcel(code)
    {
        var code = $('#parcels_body').find('tr[id="parcel_code_'+code+'"]');
        if (typeof code == 'undefined' || typeof code.length == 'undefined' || code.length == 0) {
            return false;
        }
        return true;
    }
    function genRow(code, info)
    {
        var id = typeof info.id != 'undefined' ? info.id : '';
        var bill_code = typeof info.bill_code != 'undefined' ? info.bill_code : '';
        var type_transfer = typeof info.type_transfer != 'undefined' ? info.type_transfer : '';
        var type = typeof info.type != 'undefined' ? info.type : '';
        var address = typeof info.address != 'undefined' ? info.address : '';
        var note = typeof info.note != 'undefined' ? info.note : '';
        var result = '<tr id="parcel_code_'+code+'">';
        result += '<th scope="row">'+code;
        result += '<input type="hidden" name="parcel[id][]" value="'+id+'">';
        result += '<input type="hidden" name="parcel[code][]" value="'+code+'">';
        result += '</th>';
        result += '<td>'+bill_code+'</td>';
        result += '<td>'+type_transfer+'</td>';
        result += '<td>'+type+'</td>';
        result += '<td>'+address+'</td>';
        result += '<td>'+note+'</td>';
        result += '</tr>';
        return result;
    }
});