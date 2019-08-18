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
        //cal-total
        calTotal();
    }
    function calTotal()
    {
        //caltotal forward
    }
});