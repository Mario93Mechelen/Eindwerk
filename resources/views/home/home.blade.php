@extends('layouts.master')

@section('content')

    <div class="aroundme_page">

        <!-- te deleten section eenmaal pagina klaar -->
        <section class="content aroundme">

            <!-- nu placeholders, later loopen we hier de users uit de omgeving uit en vullen we de juiste zaken in  -->
            @if(isset($distance))
                @foreach($distance as $d)
                    @php
                        $crossing = \App\User::where('id',$d['id'])->first();
                    @endphp
                <div class="aroundme_item main_item" data-id="{{$crossing->id}}">
                    <img class="aroundme_item_image" src="{{$crossing->avatar}}">
                    <div class="aroundme_item_right aroundme_item_name">{{$crossing->first_name." ".$crossing->last_name}}</div>
                    <div class="aroundme_item_right aroundme_item_detail">
                        <div class="aroundme_item_school">student at NYU</div>
                        <div class="aroundme_item_age">{{$crossing->birthday ? \Carbon\Carbon::parse($crossing->birthday)->diffInYears(\Carbon\Carbon::now())." years" : "unknown age"}}</div>
                        <div class="aroundme_item_country">{{$crossing->myLocation->city ? $crossing->myLocation->city : "no current location"}}</div>
                    </div>
                    <p>{{$d['kms']}} kms away from you</p>
                    <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>

                </div>
                @endforeach
            @else
            @endif

        </section>

        <div class="map-top">

            <div class="map-top-img"></div>

            <div class="search-bar">

                <div class="searchContainer">
                    <i class="fa fa-search searchIcon"></i>
                    <input class="searchBox" type="search" name="search" placeholder="search for location">
                    <input type="submit" value="search filters" class="searchButton">
                </div>

            </div>

        </div>

        <h2 class="content_title">People around me</h2>

        <div class="crossings-indicator-wrapper">
            <a href="#" class="crossings-indicator">
                <div class="crossing_icon"></div>
                <p>you crossed some new people</p>
            </a>
        </div>




        <!-- grid & list views -->
        <section>

            <div class="container">
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

                <!-- list & grid view  -->
                <div id="aroundme_overview" class="row list-group">

                    <!-- item -->
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt="" />
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">0.2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt="" />
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">0.2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt="" />
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">0.2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </section>

    </div>

    @endsection

@section('scripts')

    <!-- toggle list & grid view -->
    <script>

        $(document).ready(function() {
            $('#products .item').addClass('list-view');
            $('#list').click(function(event){event.preventDefault();$('.item').addClass('item-list col-xs-12 col-md-6').removeClass('item-grid col-xs-6 col-md-3');$('#list').addClass('toggle-active');$('#grid').removeClass('toggle-active');});
            $('#grid').click(function(event){event.preventDefault();$('.item').addClass('item-grid col-xs-6 col-md-3').removeClass('item-list col-xs-12 col-md-6');$('#list').removeClass('toggle-active');$('#grid').addClass('toggle-active');});
            $('#list').click(function() {

            });
        });

    </script>

    <script>
        var longitude;
        var latitude;

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            console.log(latitude+":"+longitude)
            storeLocation(latitude, longitude);
        }

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
        }

        function initMap(){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(positionToMap);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
        }

        getLocation();
        window.setInterval(getLocation, 300000);

        function storeLocation(latitude,longitude){
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('LocationController@store')}}",
                data:{
                    'longitude': longitude,
                    'latitude': latitude,
                }
            }).done(function(response){
                if(response.code==200) {
                    if(response.res != "no results found") {
                        console.log(response.res.results[0].address_components[2].long_name);
                        $('.location_city').html(response.res.results[0].address_components[2].long_name);
                    }else{
                        $('.location_city').html("seems like we couldn't find your location");
                    }
                }
            });
        }
    </script>
    <script>
        $('.aroundme_item').on('click', function(){
            var id = $(this).data('id');
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('ConversationController@store')}}",
                data:{
                    'id': id,
                }
            }).done(function(response){
                if(response.code==200) {
                    console.log('conversation '+response.conversation_id+' created');
                    window.location.replace('/conversation/'+response.conversation_id);
                }
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>

    @endsection