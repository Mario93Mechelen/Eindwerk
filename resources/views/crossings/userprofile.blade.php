@extends('layouts.master')

@section('content')

    <div class="profile_page">

        <div class="cover_image" style="background-image: url('/img/cover_image_default.jpg');"></div>

        <div class="profile_page_content">

            <div class="upper_section">


                <img class="profile_image" src="{{url('img/profile_pic_default.jpg')}}" alt="">

                <h2 class="user_name">Amber Heard</h2>

                <div class="buttons">

                    <!-- indien nog geen vrienden -->
                    <div class="button-wrapper addfriend-button-wrapper">
                        <a href="#" class="button">
                            <div class="icon add-friend-icon"></div>
                            <p>add friend</p>
                        </a>
                    </div>

                    <!-- indien vriend -->
                    <div class="button-wrapper isfriend-button-wrapper hidden">  <!-- hidden -->
                        <a href="#" class="button">
                            <div class="icon friend-icon"></div>
                            <p>friends</p>
                        </a>
                    </div>

                    <!-- message -->
                    <div class="button-wrapper message-button-wrapper">
                        <a href="#" class="button">
                            <div class="icon message-icon"></div>
                            <p>message</p>
                        </a>
                    </div>

                    <!-- indien nog geen vrienden -->
                    <div class="button-wrapper crossings-quantity-button-wrapper">
                        <a href="#" class="button">
                            <div class="icon crossings-quantity-icon"></div>
                            <p>you crossed x times already</p>
                        </a>
                    </div>
                    <p class="subtext">become friends to see where you have crossed</p>

                    <!-- indien vriend -->
                    <div class="button-wrapper crossings-location-button-wrapper hidden">  <!-- hidden -->
                        <a href="#" class="button">
                            <div class="icon crossings-location-icon"></div>
                            <p>see where you crossed each other</p>
                        </a>
                    </div>

                </div>  <!-- einde div buttons -->

                <p class="user_introtext">Hey, ik ben Amber, ik vind Mario een toffe jongen maar ben te verlegen iets
                    tegen hem te zeggen. En ik hou van ice cream, yeah!</p>

            </div>  <!-- einde upper section -->

            <div class="photos_section">

                <img class="userphoto" src="" alt="">

            </div>  <!-- einde photo section -->

            <div class="aboutme_section">

                <h2 class="section_title">about me</h2>

                <form class="aboutme_subsection aboutme_basic-info">

                    <h4 class="subsection_title">basic info</h4>

                    <!-- geboortedatum -->
                    <div class="aboutme_item">
                        <p class="item_label">birth date</p>
                        <input type="date" value="1991-10-23" readonly>
                    </div>

                    <!-- geslacht -->
                    <div class="aboutme_item">
                        <p class="item_label">gender</p>
                        <select disabled>
                            <option value="male">male</option>
                            <option value="female">female</option>
                            <option value="other" selected>other</option>
                        </select>
                    </div>

                    <!-- thuisplaats -->
                    <div class="aboutme_item">
                        <p class="item_label">home</p>
                        <input type="text" value="London, UK" readonly>
                    </div>

                </form>  <!-- einde basic info -->


                <form class="aboutme_subsection aboutme_school-info">

                    <h4 class="subsection_title">education info</h4>

                    <!-- school thuis -->
                    <div class="aboutme_item">
                        <p class="item_label">school at home</p>
                        <input type="text" value="Oxford University" readonly>
                    </div>

                    <!-- school buitenland -->
                    <div class="aboutme_item">
                        <p class="item_label">school abroad</p>
                        <input type="text" value="New York University" readonly>
                    </div>

                    <!-- huidige studie -->
                    <div class="aboutme_item">
                        <p class="item_label">study</p>
                        <input type="text" value="Master in Psychology" readonly>
                    </div>

                </form>  <!-- einde education info -->

                <form class="aboutme_subsection aboutme_social-info">

                    <h4 class="subsection_title">social</h4>

                    <!-- facebook -->
                    <div class="aboutme_item social_item">
                        <img src="" alt="" class="social_icon">
                        <p class="item_label">facebook</p>
                        <input type="text" value="www.facebook.com/someuser" readonly hidden>
                    </div>

                    <!-- twitter -->
                    <div class="aboutme_item social_item">
                        <img src="" alt="" class="social_icon">
                        <p class="item_label">twitter</p>
                        <input type="text" value="www.twitter.com/someuser" readonly hidden>
                    </div>

                    <!-- instagram -->
                    <div class="aboutme_item social_item">
                        <img src="" alt="" class="social_icon">
                        <p class="item_label">instagram</p>
                        <input type="text" value="www.instagram.com/someuser" readonly hidden>
                    </div>

                </form>  <!-- einde social info -->

            </div>  <!-- einde about me section -->

            <div class="interests_section">

                <h2 class="section_title">interests</h2>

                <div class="interests">
                    <span>chinese food</span>
                    <span>tennis</span>
                    <span>beer</span>
                    <span>foreign languages</span>
                    <span>movies</span>
                    <span>dance music</span>
                    <span>video games</span>
                </div>

            </div>  <!-- einde interests section -->

            <div class="report_abuse">

                <p>see something suspicious? <a href="">report it</a></p>

            </div>

        </div>  <!-- einde profile page content -->


    </div>  <!-- einde profile page -->

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
        $(document).ready(function() {
            $("#radiusSlider").change(function() {
                var rate  = $(this).val();
                var distance = 0;
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
                            $('.item').each(function(){
                                $(this).remove();
                            });
                            for(i=0;i<response.distance.length;i++){
                                if($('#list').hasClass('toggle-active')){
                                    $('#aroundme_overview').append('<div class="item item-list col-xs-12 col-md-6"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p></div></div></div>')
                                    console.log(response.distance[i]['user'])
                                }else{
                                    $('#aroundme_overview').append('<div class="item item-grid col-xs-6 col-md-3"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p></div></div></div>')

                                }
                            }
                        }
                    });
                }

            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>

@endsection