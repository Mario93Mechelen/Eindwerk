@extends('layouts.master')

@section('content')

    <div class="crossings_page">

        @include('partials.topmap_and_search')


        <h2 class="content_title">People I have crossed</h2>

        <div class="crossings-indicator-wrapper">
            <a href="#" class="crossings-indicator">
                <div class="crossing_icon"></div>
                <p>you crossed {{$crossingArr ? ((count($crossingArr) == 1) ? count($crossingArr).' person' : count($crossingArr).'people') : '0 people'}} the past month</p>
            </a>
        </div>

        <!-- grid & list views -->
        <section>

            <div class="container gridlist-container">
                <!-- toggle switch -->
                <div class="gridlist-toggle">
                    <strong>Display</strong>
                    <div class="btn-group">
                        <a href="#" id="list" class="btn btn-default btn-sm gridlist toggle-active"><span
                                    class="glyphicon
                        glyphicon-th-list">
                        </span><p>List</p></a> <a href="#" id="grid" class="btn btn-default btn-sm gridlist"><span
                                    class="glyphicon glyphicon-th"></span><p>Grid</p></a>
                    </div>
                </div>

             <div id="crossings_overview" class="row list-group">

                 @if($crossingArr)
                 @foreach($crossingArr as $crossing)
                    @if(!$crossing['user']->isBlocked($myUser->id)&&!$crossing['user']->blockedBy($myUser->id))
                        <div class="item item-list col-xs-12 col-md-6">
                            <a href="{{URL::action('ProfileController@show',$crossing['user'])}}">
                            <div class="item-content">
                                <img class="list-item-img" src="{{url($crossing['user']->avatar)}}" alt=""/>
                                <div class="caption">
                                    <h4 class="list-item-name">{{$crossing['user']->first_name.' '.$crossing['user']->last_name}}</h4>
                                    <p class="list-item-distance">{{($crossing['count'] == 1) ? $crossing['count'].' crossing' : $crossing['count'].' crossings'}}</p>
                                    <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endif
                 @endforeach
                 @endif


                </div>
            </div>
        </section>

    </div>

@endsection

@section('scripts')

    <script>
        $('.searchBox_inner').on('keyup', function(e){
            var name = $(this).val().toLowerCase();
            console.log(name);
            if(name != "" && e.keyCode!=8) {
                console.log('other keys are pressed');
                $('.list-item-name-home').each(function () {
                    console.log($(this).html());
                    if (!$(this).html().toLowerCase().includes(name)) {
                        $(this).parent().parent().parent().hide();
                    }
                });
            }else if(e.keyCode == 8){
                console.log('backspace pressed');
                $('.list-item-name-home').each(function () {
                    console.log($(this).html());
                    if ($(this).html().toLowerCase().includes(name)) {
                        $(this).parent().parent().parent().show();
                    }
                });
            }
        });
    </script>
    <script>
        <!-- show selected radius filter -->
        var slidingTimer;                //timer identifier
        var doneSlidingInterval = 1000;
        var distance = 5;
        function positionToMap(position) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                zoom: 15,
                zoomControl:false,
                scaleControl:false,
                mapTypeControl:false,
                streetViewControl:false,
                fullscreenControl:false

            });

            var cityCircle = new google.maps.Circle({
                strokeColor: '#0048d9',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#0048d9',
                fillOpacity: 0.35,
                map: map,
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                radius: distance*1000
            });
        }

        function initMap(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(positionToMap);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        $(document).ready(function() {

            $("#radiusSlider").change(function() {
                var rate  = $(this).val();
                if(rate == 1){
                    distance = 0.1;
                }else if(rate == 2){
                    distance = 0.25;
                }else if(rate == 3){
                    distance = 0.5;
                }else if(rate == 4){
                    distance = 1;
                }else if(rate == 5){
                    distance = 2;
                }else if(rate == 6){
                    distance = 3;
                }else if(rate == 7){
                    distance = 4;
                }else if(rate == 8){
                    distance = 5;
                }else if (rate == 9){
                    distance = 100;
                }

                $('#selectedRadius').html(distance+'km');
                console.log(distance);
                clearTimeout(slidingTimer);
                slidingTimer = setTimeout(doneSliding(distance), doneSlidingInterval);

                function doneSliding(distance){
                    initMap();
                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': "{{csrf_token()}}",

                        }

                    });
                    $.ajax({
                        method:"POST",
                        url:"{{URL::action('HomeController@filterDistance')}}",
                        data:{
                            'distance': distance,
                        }
                    }).done(function(response){
                        if(response.code==200) {

                        }
                    });
                }

            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>
@endsection