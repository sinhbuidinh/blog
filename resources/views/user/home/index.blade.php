<!doctype html>
<html lang="en">
<head>
    <title>{{ trans('label.page_name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" class="next-head">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kn247/search.css') }}">
    <style type="text/css">
        .carousel-item img {
            height: 300px;
        }
        @media only screen and (max-width: 600px) {
            .carousel-item img {
                height: 166px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- START slider -->
        <h2>Carousel Example</h2>
        @include('user.layouts.kn247.slider', [
            'sliders' => $headers
        ])
        <!-- END slider -->

        <div class="row col-md-12">
            <h1 class="mb-4">Index page</h1>
            <div class="col-md-12">
                @include('user.layouts.kn247.parcel-find')
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('#search_keyword').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    window.location.href = $('#url_search').val() + '/' + $(this).val();
                }
                event.stopPropagation();
            });
            $('.check').on('click', function(){
                var search = $('#search_keyword').val();
                if (typeof search !== undefined) {
                    window.location.href = $('#url_search').val() + '/' + $(this).val();
                }
            });
        });
    </script>
</body>
</html>
