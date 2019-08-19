$(function(){
    $("#parcel_code").select2();
    $(document).on('click', '#forward_parcel', function(){
        $(this).attr("disabled", true);
        $(this).html('Sending, please wait...');
        $('#forward_form').submit();
    });
    $(document).on('change', '#parcel', function(){
        var option = $(this).find('option:selected');
        parsePriceFromParcel(option);
    });
    $(document).on('change', '#province, #district, #ward', function(){
        var province  = $('#province').val();
        var district  = $('#district').val();
        var ward      = $('#ward').val();
        var parcel_id = $('#parcel').val();
        if (isNotSelected(province)
            || isNotSelected(district)
        ) {
            return false;
        }
        $('#price').removeClass('is-invalid');
        var data = {
            parcel: parcel_id,
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
        $('#vat').val(option.data('vat'));
        $('#price_vat').val(option.data('price_vat'));
        $('#cod').val(option.data('cod'));
        $('#support_gas').val(option.data('support_gas'));
        $('#support_remote').val(option.data('support_remote'));
        $('#total_service').val(option.data('total_service'));
        //cal-total
        calTotal();
    }
    function calTotal()
    {
        calVat();
        calRemote();
        calGas();
        calAmount();
    }
    function calVat()
    {
        var vat_before = getPrice('#price_vat');
        var percent = $('#vat').val();
        var service = getPrice('#total_service');
        var price   = getPrice('#price');
        var gas     = getPrice('#support_gas');
        var remote  = getPrice('#support_remote');
        var vat     = parseFloat(price) + parseFloat(service) + parseFloat(gas) + parseFloat(remote);
        vat = (parseFloat(vat * percent)/100) + vat_before;
        $('#price_vat').val(formatNumber(vat));
        return vat;
    }
    function calRemote()
    {
        var remote_before = getPrice('#support_remote');
        var price = getPrice('#price');
        var is_cal_remote = $('#cal_remote').val();
        if (price == 0 || is_cal_remote == 0) {
            $('#support_remote').val(formatNumber(remote_before));
            return 0;
        }
        var rate   = $('#support_remote_rate').val();
        var remote = (parseFloat(price * rate) / 100) + remote_before;
        $('#support_remote').val(formatNumber(remote));
        return remote;
    }
    function calGas()
    {
        var gas_before = getPrice('#support_gas');
        var price   = getPrice('#price');
        var refund  = getPrice('#refund');
        var forward = getPrice('#forward');
        var remote  = getPrice('#support_remote');
        var total   = parseFloat(price) + parseFloat(refund) 
        + parseFloat(forward) + parseFloat(remote);
        var rate = $('#support_gas_rate').val();
        var gas = (parseFloat(total * rate) / 100) + gas_before;
        $('#support_gas').val(formatNumber(gas));
        return gas;
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
});