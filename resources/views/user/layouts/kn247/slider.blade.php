@if(count($sliders) > 0)
<div id="carousel_slider" class="carousel slide row col-sm-12" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($sliders as $k => $info)
        <li data-target="#carousel_slider" data-slide-to="{{ $k }}"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($sliders as $k => $info)
        @php
            $active = (($k == 0) ? ' active' : '');
        @endphp
        <div class="carousel-item{{ $active }}">
            <img class="d-block w-100" src="{{ asset('images/'.data_get($info, 'img')) }}" alt="{{ data_get($info, 'alt') }}">
            <div class="carousel-caption d-none d-md-block">
                <h5>{{ data_get($info, 'title') }}</h5>
                <p>{{ data_get($info, 'caption') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carousel_slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel_slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
@endif