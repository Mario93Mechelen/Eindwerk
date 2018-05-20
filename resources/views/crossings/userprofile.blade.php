@extends('layouts.master')

@section('content')

    <div class="profile_page">

        <div class="cover_image" style="background-image: url('/img/cover_image_default.jpg');"></div>

        <div class="crossings_map hidden" style="background-image: url('/img/header_bg_01.jpg');">
            <div id="map" style="position:absolute !important; height:100%;width:100%;"></div>
        </div>

        <div class="profile_page_content">

            <div class="upper_section">

                <img class="profile_image" src="{{url($user->avatar)}}" alt="">

                <h2 class="user_name">{{$user->first_name." ".$user->last_name}}</h2>


                <div class="buttons">
                @if($user != $myUser)

                    @if($user->friendRequestIsAccepted($myUser->id,$user->id))
                        <!-- indien vriend -->
                         <div class="button-wrapper friend-button isfriend-button-wrapper" data-id="{{$user->id}}">  <!-- hidden -->
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
                    <div class="button-wrapper message-button-wrapper" data-id="{{$user->id}}">
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
                                 <p>you crossed {{isset($crossingLocations) ? (($crossingLocations->count() == 1) ? $crossingLocations->count().' time' : $crossingLocations->count().' times') : '0 times'}} already</p>
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
        $('.message-button-wrapper').on('click', function(){
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
                    $('.hide-chat').show();
                    var src = "";
                    if (response.receiver.avatar.includes('http')) {
                        src = response.receiver.avatar;
                    } else {
                        src = '/' + response.receiver.avatar;
                    }
                    ;
                    if(response.existence == 'no'){
                        console.log('new convo was created');
                        $('.chat_to_detail').removeClass('chat-active');
                        $('.active-chat-item-indicator').addClass('hidden');
                        $('#chat_overview').prepend('<div class="item item-list col-xs-12"><a class="item-content chat_to_detail chat-active" href="" data-user="'+response.receiver.id+'" data-id="'+response.conversation_id+'"><div class="active-chat-item-indicator"></div><img class="chat-avatar" src="'+src+'"><div class="chat-right"><div class="chat-nametime"><p class="chat-name">'+response.receiver.first_name+' '+response.receiver.last_name+'</p><p class="chat-time">just now</p></div></div></a></div>')
                        $('.conversation-message-in').remove();$('.conversation-message-out').remove();
                    }else {

                        console.log('fetching existing convo');
                        if($('*[data-id="' + response.conversation_id + '"]').length) {
                            $('.chat_to_detail').removeClass('chat-active');
                            $('.active-chat-item-indicator').addClass('hidden');
                            var div = $('*[data-id="' + response.conversation_id + '"]').parent().html();
                            var composedDiv = '<div class="item item-list col-xs-12">' + div + '</div>';
                            $('*[data-id="' + data.data.conversation_id + '"]').parent().remove();
                            $('#chat_overview').prepend(composedDiv);
                            $('*[data-id="' + data.data.conversation_id + '"]').find('.active-chat-item-indicator').removeClass('hidden');
                            getChats(response.conversation_id[0]);
                        }else{
                            $('#chat_overview').prepend('<div class="item item-list col-xs-12"><a class="item-content chat_to_detail chat-active" href="" data-user="'+response.receiver.id+'" data-id="'+response.conversation_id+'"><div class="active-chat-item-indicator"></div><img class="chat-avatar" src="'+src+'"><div class="chat-right"><div class="chat-nametime"><p class="chat-name">'+response.receiver.first_name+' '+response.receiver.last_name+'</p><p class="chat-time">just now</p></div></div></a></div>')
                            $('.conversation-message-in').remove();$('.conversation-message-out').remove();
                        }

                    }
                }
            });
            function getChats(id){
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                    }

                });
                $.ajax({
                    method:"POST",
                    url:"/getConversation",
                    data:{
                        'id':id
                    }
                }).done(function(response){
                    if(response.code==200) {
                        console.log(response);
                        $('.conversation-message-in').remove();
                        $('.conversation-message-out').remove();
                        if(response.conversation.length>0) {
                            for(var i=0;i<response.conversation.length;i++) {
                                var src='';
                                if(response.conversation[i].sender.avatar.includes('http')){
                                    src=response.conversation[i].sender.avatar;
                                }else{
                                    src='/'+response.conversation[i].sender.avatar;
                                };
                                if (response.myId != response.conversation[i].sender.id) {
                                    var newdiv = '<div class="conversation-message-in"><img src="' + src + '" alt=""><p class="message message-in">' + response.conversation[i].text + '</p></div>';
                                    $('.messages_container').append(newdiv);
                                } else {
                                    var newdiv = '<div class="conversation-message-out"><p class="message message-out">' + response.conversation[i].text + '</p></div>';
                                    $('.messages_container').append(newdiv);
                                };
                            }
                        }
                    }
                });
            }
        })
    </script>
    <script>
        @if($user != $myUser && isset($crossingLocations))
        function positionToMap(position) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                zoom: 14,
                zoomControl:false,
                scaleControl:false,
                mapTypeControl:false,
                streetViewControl:false,
                fullscreenControl:false

            });
            var i = 0;
            var icon = {
                url: "{{asset('img/crossings-with-background.png')}}", // url
                scaledSize: new google.maps.Size(25, 25), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            @foreach($crossingLocations as $cl)
            var lat = '{{$cl->latitude}}';
            var lng = '{{$cl->longitude}}';
            var marker = new google.maps.Marker({
                position: {lat:parseFloat(lat),lng:parseFloat(lng)},
                map: map,
                title: 'crossing nr '+i,
                icon: icon
            });
            i++;
            @endforeach
        }

        function initMap(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(positionToMap);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        @endif
    </script>
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>

@endsection