@extends('layouts.master')

@section('content')

    <div class="profile_page">

        <div class="cover_image" style="background-image: url({{$user->profile->path_cover ? url($user->profile->path_cover) : '/img/cover_image_default.jpg'}});"><div class="too-large hidden" style="background-color:white;margin:auto;width:250px;position:relative;text-align:center;top:100px;"><p style="color:red;padding:50px;">Please upload a smaller image</p></div></div>


        <form class="change-image change-cover_image hidden" style="cursor:pointer" method="post" action="{{URL::action('ProfileController@updateCover')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <label for="cover_image"><i class="far fa-image"></i></label>
            <input type="file" accept="image/*" id="cover_image" name="cover_image" style="display:none">
        </form>

        <div class="crossings_map hidden" style="background-image: url('/img/header_bg_01.jpg');">
            <div id="map" style="position:absolute !important; height:100%;width:100%;"></div>
        </div>

        <div class="profile_page_content">

            <div class="upper_section">

                <img class="profile_image" src="{{url($user->avatar)}}" alt="">

                <form class="change-image change-profile_image hidden" style="cursor:pointer" method="post" action="{{URL::action('ProfileController@updateProfilepic')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="profile_image"><i class="far fa-image"></i></label>
                    <input type="file" accept="image/*" name="profile_image" id="profile_image" style="display:none">
                </form>

                <h2 class="user_name">{{$user->first_name." ".$user->last_name}}</h2>


                <div class="buttons">
                @if($user->id != $myUser->id)

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
                    <!-- edit knop op eigen profile page -->
                    <div class="button-wrapper edit-profile-button-wrapper">
                        <a href="#" class="button">
                            <div class="icon edit-profile-icon"></div>
                            <p class="edit-profile-button-label">edit profile</p>
                        </a>
                    </div>

                    <div style="height:70px;"></div>
                @endif

                </div>  <!-- einde div buttons -->


                <p class="user_introtext edit-button-target">{{$user->intro ? $user->intro : (($user == $myUser) ? 'Seems like you still need to give yourself a nice cliché intro' : null)}}</p>

            </div>  <!-- einde upper section -->

            <div class="photos_section">

                <h2 class="section_title">photos</h2>
                <div class="photo-uploads hidden">
                    <a href="{{$user->setting->instagram ? '/getPhotos/instagram' : '#'}}" class="button {{$user->setting->instagram ? 'instagram-photos' : null}}">Get instagram photos</a>
                    <a href="#" class="button dropzone-photos">Upload photos</a>
                </div>
                <div class="photo_collection">
                    @if(!$user->profile->photos->isEmpty())
                    @foreach($user->profile->photos as $photo)
                        <div>
                        <a href="{{url($photo->path)}}" data-toggle="lightbox" data-gallery="example-gallery"><img class="userphoto" src="{{url($photo->path)}}" alt=""></a><div class="change-image delete-image hidden" data-photo="{{$photo->id}}"><i class="fas fa-times"></i></div>
                        </div>
                    @endforeach
                    @endif
                </div>
                <div class="image-uploadzone hidden">
                    <form id="addphotos" class="dropzone" action="{{URL::action('PhotoController@store', ['type' => 'profile', 'id' => $user->profile->id])}}" method="post">
                        {{ csrf_field() }}
                        <div class="dropzone-previews"></div>
                    </form>
                    <a href="{{url()->current()}}" class="btn btn-primary pull-right" title="bevestig foto's">Bevestig</a>
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
                            <input type="date" value="{{$user->birthday}}" class="edit-button-target birthdate" readonly>
                        </div>

                        <!-- geslacht -->
                        <div class="aboutme_item">
                            <p class="item_label">gender</p>
                            <select class="edit-button-target gender-select" disabled>
                                <option value="male" {{($user->gender =='male') ? 'selected' : null }}>male</option>
                                <option value="female" {{($user->gender =='female') ? 'selected' : null }}>female</option>
                                <option value="other" {{($user->gender =='other' || $user->gender=="") ? 'selected' : null }}>other</option>
                            </select>
                        </div>

                        <!-- thuisplaats -->
                        <div class="aboutme_item">
                            <p class="item_label">home</p>
                            <input type="text" value="{{$user->home}}" placeholder="" id="home" class="edit-button-target home" readonly>
                            <p style="color:red;display:none;" class="error-selection">please select an option from the list</p>
                        </div>

                    </form>  <!-- einde basic info -->


                    <form class="aboutme_subsection aboutme_school-info">

                        <h4 class="subsection_title">education info</h4>

                        <!-- school thuis -->
                        <div class="aboutme_item">
                            <p class="item_label">school at home</p>
                            <input type="text" value="{{$user->home_school}}" placeholder="" id="school_home" class="edit-button-target school_home" readonly>
                            <p style="color:red;display:none;" class="error-selection">please select an option from the list</p>
                        </div>

                        <!-- school buitenland -->
                        <div class="aboutme_item">
                            <p class="item_label">school abroad</p>
                            <input type="text" value="{{$user->abroad_school}}" placeholder="" id="school_abroad" class="edit-button-target school_abroad" readonly>
                            <p style="color:red;display:none;" class="error-selection">please select an option from the list</p>
                        </div>

                        <!-- huidige studie -->
                        <div class="aboutme_item">
                            <p class="item_label">study</p>
                            <input type="text" value="{{$user->study}}" class="edit-button-target study" readonly>
                        </div>

                    </form>  <!-- einde education info -->

                    <form class="aboutme_subsection aboutme_social-info">

                        <h4 class="subsection_title">social</h4>

                        <!-- facebook -->
                        <div class="aboutme_item social_item {{$user->setting->facebook ? 'connected' : 'disconnected'}}">
                            <a target="_blank" href="{{$user->setting->facebook ? $user->setting->facebook : '#'}}">
                                <i class="fab fa-facebook"></i>
                                <p class="item_label">facebook</p>
                            </a>
                            <input type="text" value="www.facebook.com/someuser" readonly hidden>
                        </div>

                        <!-- twitter -->
                        <div class="aboutme_item social_item {{$user->setting->twitter ? 'connected' : 'disconnected'}}">
                            <a target="_blank" href="{{$user->setting->twitter ? $user->setting->twitter : '#'}}">
                                <i class="fab fa-twitter"></i>
                                <p class="item_label">twitter</p>
                            </a>
                            <input type="text" value="www.twitter.com/someuser" readonly hidden>
                        </div>

                        <!-- instagram -->
                        <div class="aboutme_item social_item {{$user->setting->instagram ? 'connected' : 'disconnected'}}">
                            <a target="_blank" href="{{$user->setting->instagram ? $user->setting->instagram : '#'}}">
                                <i class="fab fa-instagram"></i>
                                <p class="item_label">instagram</p>
                            </a>
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

            @if($user->id != $myUser->id)
                <div class="block_user">

                    <p>you would rather not have any contact with this user? <a href="">block user</a></p>

                </div>
            @endif

        </div>  <!-- einde profile page content -->

        <div class="pop-up pop-up-block-user hidden">
            <div class="pop-up-inner">
                <h4>are you sure you want to block this user?</h4>
                <p>remember that this will remove this user from your Semestr app and you will not be able to
                    communicate with each other again, unless you unblock the user in your settings page.</p>
                <div class="buttons">
                    <a class="block-user-confirm preferred" data-user="{{$user->id}}" href="">block user</a>
                    <a class="block-user-cancel not-preferred" href="">cancel</a>
                </div>
            </div>
        </div>


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
                    if(response.existence == 'no'){
                        console.log('new convo was created');
                        $('.chat_to_detail').removeClass('chat-active');
                        $('.active-chat-item-indicator').addClass('hidden');
                        $('#chat_overview').prepend('<div class="item item-list col-xs-12"><a class="item-content chat_to_detail chat-active" href="" data-user="'+response.receiver.id+'" data-id="'+response.conversation_id+'"><div class="active-chat-item-indicator"></div><img class="chat-avatar" src="'+response.receiver.avatar+'"><div class="online-indicator online"></div><div class="chat-right"><div class="chat-nametime"><p class="chat-name">'+response.receiver.first_name+' '+response.receiver.last_name+'</p><p class="chat-time">just now</p></div></div></a></div>')
                        $('.conversation-message-in').remove();$('.conversation-message-out').remove();
                    }else {

                        console.log('fetching existing convo');
                        if($('*[data-id="' + response.conversation_id + '"]').length) {
                            console.log('the conversation is in this container');
                            $('.chat_to_detail').removeClass('chat-active');
                            $('.active-chat-item-indicator').addClass('hidden');
                            var div = $('*[data-id="' + response.conversation_id + '"]').parent().html();
                            var composedDiv = '<div class="item item-list col-xs-12">' + div + '</div>';
                            $('*[data-id="' + response.conversation_id + '"]').parent().remove();
                            $('#chat_overview').prepend(composedDiv);
                            $('*[data-id="' + response.conversation_id + '"]').find('.active-chat-item-indicator').removeClass('hidden');
                            getChats(response.conversation_id[0]);
                        }else{
                            $('.active-chat-item-indicator').addClass('hidden');
                            $('#chat_overview').prepend('<div class="item item-list col-xs-12"><a class="item-content chat_to_detail chat-active" href="" data-user="'+response.receiver.id+'" data-id="'+response.conversation_id+'"><div class="active-chat-item-indicator"></div><img class="chat-avatar" src="'+response.receiver.avatar+'"><div class="online-indicator online"></div><div class="chat-right"><div class="chat-nametime"><p class="chat-name">'+response.receiver.first_name+' '+response.receiver.last_name+'</p><p class="chat-time">just now</p></div></div></a></div>')
                            $('.conversation-message-in').remove();
                            $('.conversation-message-out').remove();
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
                                if (response.myId != response.conversation[i].sender.id) {
                                    var newdiv = '<div class="conversation-message-in"><img src="' + response.conversation[i].sender.avatar + '" alt=""><p class="message message-in">' + response.conversation[i].text + '</p></div>';
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
        @if($user->id != $myUser->id && isset($crossingLocations))
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

    <!-- FORMS -->
    <script>
        $('input[type="file"]').on('change', function(){
            if(this.files[0].size<=4000000) {
                $(this).parent().submit();
            }else{
                $('.too-large').removeClass('hidden');
            }
        });
    </script>

    @if($myUser->id == $user->id)
        <script src="/js/dropzone.min.js" type="text/javascript"></script>
        <script>
            Dropzone.options.addphotos = {
                paramName: 'photo',
                maxFilesize: 3, //3MB
                acceptedFiles: '.jpg, .jpeg, .png, .bmp, .gif',
                maxFiles: '{{10-count($myUser->profile->photos)}}'
            }

        </script>

        <script>
            $('.delete-image').on('click', function(e){
                e.preventDefault();
                var id = $(this).data('photo');
                console.log(id);
                var el = $(this).parent();
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': "{{csrf_token()}}",

                    }

                });
                $.ajax({
                    method:"POST",
                    url:"{{URL::action('PhotoController@deletePhoto')}}",
                    data:{
                        'id': id,
                    }
                }).done(function(response){
                    if(response.code==200) {
                        el.remove();
                    }
                });
            })
        </script>
    @endif


    @if($myUser->id != $user->id)
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap" async defer></script>
    @else
        <script>
            $(document).ready(function(){
                var input = document.getElementById('school_home');
                var autocomplete = new google.maps.places.Autocomplete(input,{
                    types:['establishment'],
                });
                var input2 = document.getElementById('school_abroad');
                var autocomplete2 = new google.maps.places.Autocomplete(input2,{
                    types:['establishment'],
                });
                var input3 = document.getElementById('home');
                var autocomplete3 = new google.maps.places.Autocomplete(input3,{
                    types:['(cities)'],
                });

                forceSelection(input,autocomplete);
                forceSelection(input2,autocomplete2);
                forceSelection(input3,autocomplete3);


                function forceSelection(input,autocomplete){
                    var selected = false;
                    var downWasPressed = false;
                    var enterOrTabWasPressed = false;
                    input.addEventListener('keydown', function(e){
                        if (e.keyCode === 40) {
                            downWasPressed = true;
                        };
                    });

                    google.maps.event.addDomListener(input, 'keydown', function(e) {
                        e.cancelBubble = true;

                        // If enter key, or tab key
                        if (e.keyCode === 13 || e.keyCode === 9) {
                            // If user isn't navigating using arrows and this hasn't ran yet
                            if (!downWasPressed && !e.hasRanOnce) {
                                google.maps.event.trigger(e.target, 'keydown', {
                                    keyCode: 40,
                                    hasRanOnce: true,
                                });
                                downWasPressed = true;
                            }
                        }
                    });

                    google.maps.event.addDomListener(input, 'focusout', function(e) {
                        e.cancelBubble = true;
                            // If user isn't navigating using arrows and this hasn't ran yet
                            if (!downWasPressed) {
                                google.maps.event.trigger(e.target, 'keydown', {
                                    keyCode: 40,
                                });
                                downWasPressed = true;
                            }

                    });

                    input.addEventListener('focus', function(e){
                        input.value = '';
                        downWasPressed = false;
                        enterOrTabWasPressed = false;
                        console.log(downWasPressed+' enter: '+enterOrTabWasPressed);
                    });

                    // place_changed GoogleMaps listener when we do submit
                    google.maps.event.addListener(autocomplete, 'place_changed', function() {

                        // Get the place info from the autocomplete Api
                        const place = autocomplete.getPlace();

                    });
                }

            })
        </script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&libraries=places" async defer></script>
    @endif


@endsection