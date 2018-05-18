@extends('layouts.master')

@section('content')

    <div class="settings_page">

        <div class="settings_page_content">

            <div class="general_settings">
                <h2 class="section_title">general settings</h2>

                <div class="distance_unit">
                    <ul>
                        <li class="active">kilometers</li>
                        <li>miles</li>
                    </ul>
                </div>

                <form class="settings_subsection general_email">
                    <h4 class="subsection_title">
                        <p>email</p>
                        <a href="">edit</a>
                    </h4>

                    <!-- email -->
                    <div class="settings_item">
                        <p class="item_label">email</p>
                        <input type="email" value="amber_heard@loveyou.com">
                    </div>
                </form>

                <form class="settings_subsection general_password">
                    <h4 class="subsection_title">
                        <p>password</p>
                        <a href="">edit</a>
                    </h4>

                    <!-- email -->
                    <div class="settings_item">
                        <p class="item_label">password</p>
                        <input type="password" value="yowdude">
                    </div>
                </form>

                <form class="settings_subsection general_social">

                    <!-- facebook -->
                    <div class="settings_item social_item">
                        <i class="fab fa-facebook"></i>
                        <p class="item_label">facebook</p>
                        <a href="">disconnect</a>
                    </div>

                    <!-- twitter -->
                    <div class="settings_item social_item">
                        <i class="fab fa-twitter"></i>
                        <p class="item_label">twitter</p>
                        <a href="">connect</a>
                    </div>

                    <!-- instagram -->
                    <div class="settings_item social_item">
                        <i class="fab fa-instagram"></i>
                        <p class="item_label">instagram</p>
                        <a href="">connect</a>
                    </div>

                </form>  <!-- einde social info -->

            </div>

            <div class="notification_settings">
                <h2 class="section_title">notification settings</h2>

            </div>

            <div class="privacy_settings">
                <h2 class="section_title">privacy settings</h2>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>
        $('.searchBox_inner').on('keyup', function(e){
            var name = $(this).val().toLowerCase();
            console.log(name);
            if(name != "" && e.keyCode!=8) {
                console.log('other keys are pressed');
                $('.list-item-name').each(function () {
                    console.log($(this).html());
                    if (!$(this).html().toLowerCase().includes(name)) {
                        $(this).parent().parent().parent().hide();
                    }
                });
            }else if(e.keyCode == 8){
                console.log('backspace pressed');
                $('.list-item-name').each(function () {
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