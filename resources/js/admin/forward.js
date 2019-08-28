$(function(){
    $("#parcel").select2();
    $(document).on('click', '#forward_parcel', function(){
        $(this).attr("disabled", true);
        $(this).html('Sending, please wait...');
        $('#forward_form').submit();
    });
    // //re-calculate price total
    // $(document).on('change', '#price, #refund, #forward, #vat, #price_vat, #cod, #support_remote_rate, #support_remote, #support_gas_rate, #support_gas, #total_service', function(){
    //     calTotal();
    // });
    $(document).on('change', '#parcel', function(){
        var option = $(this).find('option:selected');
        parsePriceFromParcel(option);
        calTotal();
    });
    $(document).on('change', '#province, #district, #ward, #parcel', function(){
        var province = $('#province').val();
        var district = $('#district').val();
        var ward     = $('#ward').val();
        var service  = $('#type_transfer').val();
        var type     = $('#type').val();
        var weight   = $('#weight').val();
        if (isNotSelected(province)
            || isNotSelected(district)
            || isNotSelected(service)
            || isNotSelected(type)
            || isNotSelected(weight)
        ) {
            return false;
        }
        $('#price').removeClass('is-invalid');
        var data = {
            service_type: service,
            type: type,
            weight: weight,
            province: province,
            district: district,
            ward: ward,
        };
        calPrice(data);
    });
    function parsePriceFromParcel(option)
    {
        $('#price').val(option.data('price'));
        $('#refund').val(option.data('refund'));
        $('#forward').val(option.data('forward'));
        $('#cod').val(option.data('cod'));
        $('#vat').val(option.data('vat'));
        $('#price_vat_old').val(option.data('price_vat'));
        $('#support_gas_old').val(option.data('support_gas'));
        $('#support_remote_old').val(option.data('support_remote'));
        $('#price_vat').val(option.data('price_vat'));
        $('#support_gas').val(option.data('support_gas'));
        $('#support_remote').val(option.data('support_remote'));
        $('#total_service').val(option.data('total_service'));
        $('#type_transfer').val(option.data('type_transfer'));
        $('#type').val(option.data('type'));
        $('#weight').val(option.data('weight'));
        var is_cal_remote = (parseFloat(getPrice('#support_remote_old')) > 0) ? 1 : 0;
        $('#cal_remote').val(is_cal_remote);
        $('#total').val(option.data('total'));
    }
    function hasAddressForward()
    {
        //cal-total
        var province = $('#province').val();
        var district = $('#district').val();
        if (!province && !district) {
            return false;
        }
        return true;
    }
    function calTotal()
    {
        if (hasAddressForward() === false) {
            return false;
        }
        calRemote();
        calGas();
        calVat();
        calAmount();
    }
    function calRemote()
    {
        // change destination forward 
        // => re-calculate remote by new price forward & plus old remote
        var remote_before = getPrice('#support_remote_old');
        var forward = getPrice('#forward');
        var is_cal_remote = $('#cal_remote').val();
        if (forward == 0 || is_cal_remote == 0) {
            $('#support_remote').val(formatNumber(remote_before));
            return 0;
        }
        var rate   = $('#support_remote_rate').val();
        var remote = (parseFloat(forward * rate) / 100) + remote_before;
        $('#support_remote').val(formatNumber(remote));
        return remote;
    }
    function calGas()
    {
        // change destination forward => re-calculate gas
        // gas cal by price + refund + forward + remote
        // => no need plus old gas
        var price   = getPrice('#price');
        var refund  = getPrice('#refund');
        var remote  = getPrice('#support_remote');
        var forward = getPrice('#forward');
        //all price effect gas
        var total = parseFloat(price) + parseFloat(refund) 
        + parseFloat(forward) + parseFloat(remote);
        var rate = $('#support_gas_rate').val();
        var gas = (parseFloat(total * rate) / 100);
        $('#support_gas').val(formatNumber(gas));
        return gas;
    }
    function calVat()
    {
        // vat be calculate by price + service + gas + remote
        // change destination => effect to gas & remote
        // => re-calculate no need plus old data
        // var vat_before = getPrice('#price_vat_old');
        var vat = 0;
        var percent = $('#vat').val();
        var service = getPrice('#total_service');
        var price   = getPrice('#price');
        var gas     = getPrice('#support_gas');
        var remote  = getPrice('#support_remote');
        vat = parseFloat(price) + parseFloat(service) 
        + parseFloat(gas) + parseFloat(remote);
        vat = (parseFloat(vat * percent)/100);
        // vat = vat + vat_before;
        $('#price_vat').val(formatNumber(vat));
        return vat;
    }
    function calAmount()
    {
        var price   = getPrice('#price');
        var service = getPrice('#total_service');
        var refund  = getPrice('#refund');
        var forward = getPrice('#forward');
        var vat     = getPrice('#price_vat');
        var cod     = getPrice('#cod');
        var gas     = getPrice('#support_gas');
        var remote  = getPrice('#support_remote');
        var total   = parseFloat(price) + parseFloat(service) + parseFloat(refund) 
        + parseFloat(forward) + parseFloat(vat) + parseFloat(cod)
        + parseFloat(gas) + parseFloat(remote);
        $('#total').val(formatNumber(total));
        return total;
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
    function formatNumber(string)
    {
        string = removeFormat(string);
        // return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var parts = string.toString().split(".");
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
    function calPrice(input_obj)
    {
        var action = $('#url_get_price').val();
        if (typeof action == 'undefined' || action == '') {
            return false;
        }
        //ajax cal
        $.ajax({
            type: "POST",
            url: action,
            data: input_obj,
            dataType: 'json',
            success: function(data){
                $('#forward').val(data.total_format);
                $('#cal_remote').val(0);
                if (typeof data.cal_remote != 'undefined') {
                    $('#cal_remote').val(1);
                }
                calTotal();
            },
            error: function(xhr, status, error){
                console.log('url_get_price error: ' + error);
            }
        });
    }
    function isNotSelected(value)
    {
        if (typeof value == 'undefined' || value == '') {
            return true;
        }
        return false;
    }
});