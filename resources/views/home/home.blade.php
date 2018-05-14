@extends('layouts.master')

@section('content')

    <div class="aroundme_page">

        <div class="map-top">

            <div class="map-top-img">
                <div id="map" style="position:absolute !important; height:290px;width:100%;"></div>
            </div>

            <div class="search-bar">

                <div class="searchContainer">
                    <div class="searchBox">
                        <i class="fa fa-search searchIcon"></i>
                        <input class="searchBox_inner" type="search" name="search" placeholder="search for users">
                    </div>

                    <input type="submit" value="" class="searchButton">
                    
                </div>

                <div class="searchButtonOptions hidden">
                    <div class="searchButtonOptionRadius">
                        <h6>radius</h6>
                        <div class="radiusSliderContainer">
                            <input type="range" min="1" max="10" value="5" class="slider radiusSlider" id="radiusSlider">
                        </div>
                        <div id="selectedRadius">2km</div>
                    </div>
                    <div class="searchButtonOptionInterests">
                        <h6>interests</h6>
                        <ul>
                            <li class="interest-item selected">chinese food</li>
                            <li class="interest-item selected">tennis</li>
                            <li class="interest-item">beer</li>
                            <li class="interest-item">foreign languages</li>
                            <li class="interest-item selected">movies</li>
                            <li class="interest-item">dance music</li>
                            <li class="interest-item">video games</li>
                        </ul>
                    </div>
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

                <!-- list & grid view  -->
                <div id="aroundme_overview" class="row list-group">

                    <!-- item -->
                    @if(isset($distance))
                    @foreach($distance as $d)
                    @php
                        $user = App\User::find($d['id']);
                    @endphp
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url($user->avatar ? $user->avatar : '')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">{{$user->first_name." ".$user->last_name}}</h4>
                                <p class="list-item-distance">{{$d['kms']}} km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                     @endforeach
                     @else
                        <p>We couldn't find users nearby, did you share your location with us?</p>
                     @endif


                </div>
            </div>

        </section>

    </div>

    @endsection

@section('scripts')



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