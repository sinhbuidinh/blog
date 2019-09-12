<!-- form search parcel -->
<div class="row col-md-12 row-search">
    <div class="row prefix"></div>
    <div class="row search mb-4">
        <div class="label">TRA CỨU<br>VẬN ĐƠN</div>
        <input type="text" id="search_keyword"
            name="search_keyword"
            value="{{ old('search_keyword') }}"
            placeholder="Tra cứu mã vận đơn">
        <div class="check">KIỂM TRA</div>
        <input type="hidden" id="url_search" value="{{ route('user.locate') }}">
    </div>
</div>