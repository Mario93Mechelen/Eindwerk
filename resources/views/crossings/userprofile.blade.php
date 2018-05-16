@extends('layouts.master')

@section('content')

    <div class="profile_page">
        @php
            $crossingLocations = App\Crossing::where('crosser_id',$myUser->id)->where('crossed_id', $user->id)->first()->crossingLocations->count();
        @endphp

        <div class="cover_image" style="background-image: url('/img/cover_image_default.jpg');"></div>

        <div class="crossings_map hidden" style="background-image: url('/img/header_bg_01.jpg');"></div>

        <div class="profile_page_content">

            <div class="upper_section">

                <img class="profile_image" src="{{url($user->avatar)}}" alt="">

                <h2 class="user_name">{{$user->first_name." ".$user->last_name}}</h2>


                <div class="buttons">
                @if($user != $myUser)

                    @if($user->friendRequestIsAccepted($myUser->id,$user->id))
                    <!-- indien vriend -->
                     <div class="button-wrapper friend-button isfriend-button-wrapper">  <!-- hidden -->
                         <a href="#" class="button">
                             <div class="icon friend-icon"></div>
                             <p>friends</p>
                         </a>
                     </div>
                    @elseif($user->friendRequestIsSent($myUser->id,$user->id))
                     <div class="button-wrapper friend-button addfriend-button-wrapper" data-id="{{$user->id}}">
                         <a href="#" class="button">
                             <div class="icon add-friend-icon"></div>
                             <p>Request sent</p>
                         </a>
                     </div>
                    @else
                    <!-- indien nog geen vrienden -->
                    <div class="button-wrapper friend-button addfriend-button-wrapper" data-id="{{$user->id}}">
                        <a href="#" class="button">
                            <div class="icon add-friend-icon"></div>
                            <p>add friend</p>
                        </a>
                    </div>
                    @endif


                    <!-- message -->
                    <div class="button-wrapper message-button-wrapper">
                        <a href="#" class="button">
                            <div class="icon message-icon"></div>
                            <p>message</p>
                        </a>
                    </div>


                    @if($user->friendRequestIsAccepted($myUser->id,$user->id))
                    <!-- indien vriend -->
                    <div class="button-wrapper crossings-location-button-wrapper">  <!-- hidden -->
                        <a href="#" class="button">
                            <div class="icon crossings-location-icon"></div>
                            <p>see where you crossed each other</p>
                        </a>
                    </div>
                    @else
                     <!-- indien nog geen vrienden -->
                     <div class="button-wrapper crossings-quantity-button-wrapper">
                         <a href="#" class="button">
                             <div class="icon crossings-quantity-icon"></div>
                             <p>you crossed {{($crossingLocations == 1) ? $crossingLocations.' time' : $crossingLocations.' times'}} already</p>
                         </a>
                     </div>
                     <p class="subtext">become friends to see where you have crossed</p>
                    @endif

                    <!-- indien vriend en crossings map open -->
                    <div class="button-wrapper crossings-hide-map-button-wrapper hidden">  <!-- hidden -->
                        <a href="#" class="button">
                            <p>hide map</p>
                        </a>
                    </div>

                    @else

                    <div style="height:70px;"></div>

                    @endif

                </div>  <!-- einde div buttons -->


                <p class="user_introtext">{{$user->intro ? $user->intro : (($user == $myUser) ? 'Seems like you still need to give yourself a nice cliché intro' : null)}}</p>
-

            </div>  <!-- einde upper section -->

            <div class="photos_section">

                <h2 class="section_title">photos</h2>

                <div class="photo_collection">
                    <a href="{{url('img/user_photo_example1.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example1.jpg')}}" alt=""></a>
                    <a href="{{url('img/user_photo_example2.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example2.jpg')}}" alt=""></a>
                    <a href="{{url('img/user_photo_example3.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example3.jpg')}}" alt=""></a>
                    <a href="{{url('img/user_photo_example1.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example1.jpg')}}" alt=""></a>
                    <a href="{{url('img/user_photo_example2.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example2.jpg')}}" alt=""></a>
                    <a href="{{url('img/user_photo_example3.jpg')}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url('img/user_photo_example3.jpg')}}" alt=""></a>
                </div>


            </div>
            <!-- einde photo section -->

            <div class="aboutme_section">

                <h2 class="section_title">about me</h2>

                <div class="aboutme_section_inner">

                    <form class="aboutme_subsection aboutme_basic-info">

                        <h4 class="subsection_title">basic info</h4>

                        <!-- geboortedatum -->
                        <div class="aboutme_item">
                            <p class="item_label">birth date</p>
                            <input type="date" value="{{$user->birthday}}" readonly>
                        </div>

                        <!-- geslacht -->
                        <div class="aboutme_item">
                            <p class="item_label">gender</p>
                            <select disabled>
                                <option value="male" {{($user->gender =='male') ? 'selected' : null }}>male</option>
                                <option value="female" {{($user->gender =='female') ? 'selected' : null }}>female</option>
                                <option value="other" {{($user->gender =='other' || $user->gender=="") ? 'selected' : null }}>other</option>
                            </select>
                        </div>

                        <!-- thuisplaats -->
                        <div class="aboutme_item">
                            <p class="item_label">home</p>
                            <input type="text" value="{{$user->home}}" readonly>
                        </div>

                    </form>  <!-- einde basic info -->


                    <form class="aboutme_subsection aboutme_school-info">

                        <h4 class="subsection_title">education info</h4>

                        <!-- school thuis -->
                        <div class="aboutme_item">
                            <p class="item_label">school at home</p>
                            <input type="text" value="{{$user->home_school}}" readonly>
                        </div>

                        <!-- school buitenland -->
                        <div class="aboutme_item">
                            <p class="item_label">school abroad</p>
                            <input type="text" value="{{$user->abroad_school}}" readonly>
                        </div>

                        <!-- huidige studie -->
                        <div class="aboutme_item">
                            <p class="item_label">study</p>
                            <input type="text" value="{{$user->study}}" readonly>
                        </div>

                    </form>  <!-- einde education info -->

                    <form class="aboutme_subsection aboutme_social-info">

                        <h4 class="subsection_title">social</h4>

                        <!-- facebook -->
                        <div class="aboutme_item social_item">
                            <i class="fab fa-facebook"></i>
                            <p class="item_label">facebook</p>
                            <input type="text" value="www.facebook.com/someuser" readonly hidden>
                        </div>

                        <!-- twitter -->
                        <div class="aboutme_item social_item">
                            <i class="fab fa-twitter"></i>
                            <p class="item_label">twitter</p>
                            <input type="text" value="www.twitter.com/someuser" readonly hidden>
                        </div>

                        <!-- instagram -->
                        <div class="aboutme_item social_item">
                            <i class="fab fa-instagram"></i>
                            <p class="item_label">instagram</p>
                            <input type="text" value="www.instagram.com/someuser" readonly hidden>
                        </div>

                    </form>  <!-- einde social info -->

                </div>  <!-- einde about me inner section (voor desktop positioning) -->

            </div>  <!-- einde about me section -->

            <div class="interests_section">

                <h2 class="section_title">interests</h2>

                <ul class="interests">
                    <li class="interest-item selected">chinese food</li>
                    <li class="interest-item ">tennis</li>
                    <li class="interest-item selected">beer</li>
                    <li class="interest-item ">foreign languages</li>
                    <li class="interest-item selected">movies</li>
                    <li class="interest-item ">dance music</li>
                    <li class="interest-item ">video games</li>
                </ul>

            </div>  <!-- einde interests section -->

            <div class="report_abuse">

                <p>see something suspicious? <a href="">report it</a></p>

            </div>

        </div>  <!-- einde profile page content -->


    </div>  <!-- einde profile page -->

@endsection

@section('scripts')

    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true,
                width:1000,
                height:1000,
                showArrows:true
            });
        });
    </script>

    <script>
        $('.friend-button').on('click', function(e){
            var id = $(this).data('id');
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('ProfileController@sendFriendRequest')}}",
                data:{
                    'id': id,
                }
            }).done(function(response){
                if(response.code==200) {
                    $('.friend-button').find('p').text(response.text);
                }
            });
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


@endsection