@extends('layouts.master')

@section('content')

    <div class="settings_page">

        <div class="settings_page_content">

            <div class="general_settings settings-section">
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
                        <a id="edit_email" href="">edit</a>
                    </h4>

                    <div class="settings_item">
                        <p class="item_label">email</p>
                        <input type="email" value="amber_heard@loveyou.com">
                    </div>
                </form>

                <form class="settings_subsection general_password">
                    <h4 class="subsection_title">
                        <p>password</p>
                        <a id="edit_password" href="">edit</a>
                    </h4>

                    <div class="password_dropdown">

                        <div class="settings_item password_item">
                            <p class="item_label">current password</p>
                            <input type="text" value="current password">
                        </div>

                        <div class="settings_item password_item">
                            <p class="item_label">new password</p>
                            <input type="text" value="new password">
                        </div>

                        <div class="settings_item password_item">
                            <p class="item_label">new password repeat</p>
                            <input type="text" value="new password repeat">
                        </div>

                    </div>

                </form>

                <form class="settings_subsection general_social">

                    <!-- facebook -->
                    <div class="settings_item social_item">
                        <i class="fab fa-facebook"></i>
                        <p class="item_label">facebook</p>
                        <a class="social_item_connect" href="">disconnect</a>
                    </div>

                    <!-- twitter -->
                    <div class="settings_item social_item">
                        <i class="fab fa-twitter"></i>
                        <p class="item_label">twitter</p>
                        <a class="social_item_connect" href="">connect</a>
                    </div>

                    <!-- instagram -->
                    <div class="settings_item social_item">
                        <i class="fab fa-instagram"></i>
                        <p class="item_label">instagram</p>
                        <a class="social_item_connect" href="">connect</a>
                    </div>

                </form>  <!-- einde social info -->

                <div class="settings_subsection general_blocked_users">
                    <div class="button-wrapper blocked-users-button-wrapper">
                        <a href="#" class="button list-hidden">
                            <p>blocked users</p>
                        </a>
                    </div>
                    <div class="blocked_user_dropdown">

                        <!-- dit zijn nog placeholders, moet nog uitgeloopt worden -->
                        <div class="settings_item blocked_user_item">
                            <img  src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <p class="item_label">Amber Heard</p>
                            <a href="">unblock</a>
                        </div>
                        <div class="settings_item blocked_user_item">
                            <img  src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <p class="item_label">Amber Heard</p>
                            <a href="">unblock</a>
                        </div>
                        <div class="settings_item blocked_user_item">
                            <img  src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <p class="item_label">Amber Heard</p>
                            <a href="">unblock</a>
                        </div>

                    </div>
                </div>


            </div>

            <div class="notification_settings settings-section">
                <h2 class="section_title">notification settings</h2>

                <form class="settings_subsection notification_email">
                    <h4 class="subsection_title">
                        <p>email notifications</p>
                    </h4>

                    <!-- email notifications -->
                    <div class="settings_item">
                        <p class="item_label">new messages</p>
                        <div class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </div>
                    </div>
                    <div class="settings_item">
                        <p class="item_label">friend requests</p>
                        <div class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </div>
                    </div>
                    <div class="settings_item">
                        <p class="item_label">group messages</p>
                        <div class="checkbox-container">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </div>
                    </div>
                </form>

            </div>

            <div class="privacy_settings settings-section">
                <h2 class="section_title">privacy settings</h2>

                <form class="settings_subsection privacy_location">
                    <h4 class="subsection_title">
                        <p>location services</p>
                        <a class= "location-link" href="">active</a>
                    </h4>

                    <div class="settings_item">
                        <p class="item_text">in order to make sure you get the optimal experience while using
                            Semestr, the app requires access to your current location. Your exact location will
                            <em>never</em> be shared with other users, only an estimated distance between you and
                            other users will be shown.</p>
                    </div>
                </form>

                <form class="settings_subsection privacy_data">
                    <h4 class="subsection_title">
                        <p>my data</p>
                        <a href="">request data</a>
                    </h4>

                    <div class="settings_item">
                        <p class="item_text">Semestr stores your data securely and abbording to the latest standards. If you wish to see which of your data has been stored, you can simply request a copy
                            of your personal data file. We will contact you when your report is ready for download.</p>
                    </div>
                </form>

                <a class="delete_my_profile">delete my profile</a>


            </div>

        </div>

        <div class="pop-up pop-up-data-off hidden">
            <div class="pop-up-inner">
                <h4>are you sure you want to turn of use of gps data?</h4>
                <p>remember that this will severely impact your Semestr experience in a negative way.</p>
                <div class="buttons">
                    <a class="turn-on-off not-preferred" href="">turn off</a>
                    <a class="preferred" href="">cancel</a>
                </div>
            </div>
        </div>

        <div class="pop-up pop-up-delete-profile hidden">
            <div class="pop-up-inner">
                <h4>are you sure you want to delete your profile and all associated data?</h4>
                <p>remember that this action is irreversable and will also delete all your pictures, conversations,
                    crossings and friends you've made during your time on Semestr.</p>
                <div class="buttons">
                    <a class="delete not-preferred" href="">delete</a>
                    <a class="preferred" href="">cancel</a>
                </div>
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