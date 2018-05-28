<!-- toggle list & grid view -->
$(document).ready(function() {

    $('#list').click(function(event){event.preventDefault();$('.item').addClass('item-list col-xs-12 col-md-6').removeClass('item-grid col-xs-6 col-md-3');$('#list').addClass('toggle-active');$('#grid').removeClass('toggle-active');});
    $('#grid').click(function(event){event.preventDefault();$('.item').addClass('item-grid col-xs-6 col-md-3').removeClass('item-list col-xs-12 col-md-6');$('#list').removeClass('toggle-active');$('#grid').addClass('toggle-active');});
    $('#list').click(function() {

    });
});

<!-- hide search filter value when mobile -->
$(document).ready(function() {
    if(window.innerWidth < 768) {
        $(".searchButton").prop('value', '');
    } else {
        $(".searchButton").prop('value', 'search filters');
    }
});

window.onresize = function() {
    if(window.innerWidth < 768) {
        $(".searchButton").prop('value', '');
    } else {
        $(".searchButton").prop('value', 'search filters');
    }
};

//hide/show chat screen
$(document).ready(function(){
    $('.dropdown-item-chat').on('click', function(){
        $('.hide-chat').css("display", "flex");
    })
});

<!-- show/hide dropdown menus & labels & pop-ups :-) -->
$(document).ready(function() {
    $( "#nav_chat" ).click(function() {
        $("#dropdown-menu-profile").hide();
        $( "#nav_profile" ).removeClass("highlighted");
        $('.hide-chat').css("display", "flex");
        $('body').css('overflow','hidden');
    });
    $( "#nav_profile" ).click(function() {
        $("#dropdown-menu-profile").toggle();
        $("#dropdown-menu-chat").hide();
        $( "#nav_profile" ).toggleClass("highlighted");
        $( "#nav_chat" ).removeClass("highlighted");
    });

    /* email section in settings */
    $("#edit_email").click(function(e) {
        e.preventDefault();
        if ($("#edit_email").html() == "edit") {
            $("#edit_email").html("save");
            $("#email-settings").focus();
            $("#email-settings")[0].selectionStart = $("#email-settings")[0].selectionEnd = $("#email-settings").val().length;
        } else {
            var email = $('#email-settings').val();
            saveEmail(email);
            $("#edit_email").html("edit");
        }
    });
    function saveEmail(email){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/updateEmail",
            data:{
                'email':email
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('email saved')
                $('#email-settings').val(email);
            }
        });
    }

    /* social media section in settings */
    /* eerst bij laden van pagina kleur iconen juist zetten */
    $(".social_item_connect").each(function() {
        if ($(this).html() == "connect") {
            $(this).parent().find("i").css("color", "#aaaaaa");
        } else {
            $(this).parent().find("i").css("color", "#0048d9");
        }
    });
    /* dan reageren op kliks */
    $(".social_item_connect").click(function(e) {
       if ($(this).html() == "connect") {
           $(this).html("disconnect");
           $(this).parent().find("i").css("color", "#0048d9");
       } else {
           e.preventDefault();
           var socialtype = $(this).data('socialtype');
           disconnectSocialMedia(socialtype);
           $(this).html("connect");
           $(this).parent().find("i").css("color", "#aaaaaa");
           $(this).attr('href', '/login/'+socialtype);
       }
    });
    /* en ook op de profielpagina */
    $(".aboutme_social-info .social_item").each(function() {
        if ($(this).hasClass("connected")) {
            $(this).find("i").css("color", "#0048d9");
        } else {
            $(this).find("i").css("color", "#aaaaaa");
        }
    });

    function disconnectSocialMedia(socialtype){
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                }

            });
            $.ajax({
                method:"POST",
                url:"/disconnectSocialMedia",
                data:{
                    'social':socialtype
                }
            }).done(function(response){
                if(response.code==200) {
                    console.log('changed social media setting');
                }
            });
    };

    /* password section in settings */
    $("#edit_password").click(function(e) {
        e.preventDefault();
        if ($("#edit_password").html() == "edit") {
            $("#edit_password").html("save");
            $(".password_dropdown").slideDown();
        } else {
            var old_password = $('#settings-oldpassword').val();
            var new_password1 = $('.new_password1').val();
            var new_password2 = $('.new_password2').val();
            if(new_password1 == new_password2){
                savePassword(old_password,new_password2);
            }
            $("#edit_password").html("edit");
            $(".password_dropdown").slideUp();
        }
    });

    /* school info vs student feed toggle */
    $(".see-school-info").click(function(e) {
        e.preventDefault();
        $(this).addClass("active");
        $(".see-student-feed").removeClass("active");
        $(".school-info-section").toggle();
        $(".student-feed-section").toggle();
        $(".school_introtext").toggle();
        if(window.innerWidth < 768) {
            $(".members-button-wrapper").toggle();
        }
    });
    $(".see-student-feed").click(function(e) {
        e.preventDefault();
        $(this).addClass("active");
        $(".see-school-info").removeClass("active");
        $(".school-info-section").toggle();
        $(".student-feed-section").toggle();
        $(".school_introtext").toggle();
        if(window.innerWidth < 768) {
            $(".members-button-wrapper").toggle();
        }
    });


    /* show & hide comments of a post */
    $(".show-hide-post-comments").click(function(e) {
        e.preventDefault();
        $(this).parent().parent().find(".post-comments").slideToggle();
        if ( $(this).html() == "show comments" ) {
            $(this).html("hide comments");
        } else {
            $(this).html("show comments");
        }
    });

    /* create new post */
    $(".new-post-button-wrapper .button").click(function(e) {
        e.preventDefault();
        $(".new-post-bottom").slideDown();
        $(".overlay").show();
        $(".new-post-button-wrapper").css("box-shadow", "none");
    });

    /* add picture to post */
    $(".new-post-add-picture").click(function(e) {
        e.preventDefault();
        console.log("add picture hombrero");
    });

    /* delete picture from post */
    $(".delete-image").click(function(e) {
        e.preventDefault();
        $(this).parent().hide();  /* dit is niet de manier, maar toont al wat er moet gebeuren */
        console.log("delete picture hombrero");
    });

    /* send new post */
    $(".new-post-bottom .send").click(function(e) {
        e.preventDefault();
        $(".new-post-bottom").slideUp();
        $(".new-post-button-wrapper input").val("");
        $(".overlay").hide();
    });

    /* cancel new post */
    $(".new-post-bottom .cancel").click(function(e) {
        e.preventDefault();
        $(".new-post-bottom").slideUp();
        $(".new-post-button-wrapper input").val("");
        $(".overlay").hide();
    });

    /* toggle member list mobile */
    $(".member-list-button").click(function(e) {
        e.preventDefault();
        $(".member-list").show();
        $(".overlay2").show();
    });

    $(".overlay2").click(function(e) {
        $("#member-list").hide();
        $(".overlay2").hide();
        console.log("hey man");
    });



    function savePassword(oldp,newp){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/updatePassword",
            data:{
                'oldp':oldp,
                'newp':newp
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('password saved')
            }
        });
    }

    $('.email_notifications').on('click', function(){
       var id = $(this).attr('id');
       var val = $(this).is(":checked");
       console.log(val);
       updateEmailNotifications(id,val);
    });

    function updateEmailNotifications(id,val){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/updateEmailNotifications",
            data:{
                'id':id,
                'val':val
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('notification saved')
            }
        });
    }

    /* blocked users section in settings */
    $(".blocked-users-button-wrapper").click(function(e) {
        e.preventDefault();
        if ($(".blocked-users-button-wrapper > a").hasClass("list-hidden")) {
            $(".blocked-users-button-wrapper > a").removeClass("list-hidden");
            $(".blocked-users-button-wrapper > a").addClass("list-shown");
            $(".blocked_user_dropdown").slideDown();
        } else {
            $(".blocked-users-button-wrapper > a").removeClass("list-shown");
            $(".blocked-users-button-wrapper > a").addClass("list-hidden");
            $(".blocked_user_dropdown").slideUp();
        }
    });

    /*  gps data pop-up in settings page */

    $(".location-link").click(function(e) {
        e.preventDefault();
        $(".pop-up-data-off").toggleClass("hidden");
    });


    /*  delete profile pop-up in settings page */
    $(".delete_my_profile").click(function(e) {
        e.preventDefault();
        $(".pop-up-delete-profile").toggleClass("hidden");
    });

    /* cancel buttons  */
    $(".pop-up-data-off .preferred").click(function(e) {
        e.preventDefault();
        $(".pop-up-data-off").toggleClass("hidden");
    });

    $(".pop-up-delete-profile .preferred").click(function(e) {
        e.preventDefault();
        $(".pop-up-delete-profile").toggleClass("hidden");
    });


    /*  block user button & pop-up in profile page */
    $(".block_user").click(function(e) {
        e.preventDefault();
        $(".pop-up-block-user").toggleClass("hidden");
    });

    $(".block-user-confirm").click(function(e) {
        e.preventDefault();
        /* hier zorgen dat user in blocked komt en redirecten naar home page */
        var id = $(this).data('user');
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/blockUser",
            data:{
                'id':id,
            }
        }).done(function(response){
            if(response.code==200) {
                window.location.href = '/';
            }
        });

    });

    $('.unblock-me').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('user');
        var el = $(this).parent();
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/deleteBlockedUser",
            data:{
                'id':id,
            }
        }).done(function(response){
            if(response.code==200) {
                el.remove();

            }
        });
    });

    $(".block-user-cancel").click(function(e) {
        e.preventDefault();
        $(".pop-up-block-user").toggleClass("hidden");
    });


    /* other buttons */
    $(".pop-up-data-off .turn-on-off").click(function(e) {
        e.preventDefault();
        $(".pop-up-data-off").toggleClass("hidden");
        if ($(".location-link").html() == "active") {
            $(".location-link").html("inactive");
            $(".location-link").css("color", "#800000");
        } else {
            $(".location-link").html("active");
            $(".location-link").css("color", "#0048d9");
        }
        $(".pop-up-data-off a").toggleClass("preferred");
        $(".pop-up-data-off a").toggleClass("not-preferred");
        if ($(".pop-up-data-off a:first").html() == "turn off") {
            $(".pop-up-data-off a:first").html("turn on");
        } else {
            $(".pop-up-data-off a:first").html("turn off");
        }

    });

    /* delete button */
    $(".pop-up-delete-profile .not-preferred").click(function(e) {
        e.preventDefault();
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/deletelife",
            data:{
                'message':'do-it'
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('we pulled the plug on you m8');
                console.log('hasta la vista, baby');
            }
        });
        $(".pop-up-delete-profile").toggleClass("hidden");
        window.location.href = '/login';
        /* EVERYTHING ENDS!!! */
    });

    /* edit profile button */
    $(".edit-profile-button-wrapper").click (function(e) {
        e.preventDefault();
        if ($(".edit-profile-button-label").html() == "edit profile") {
            $(".edit-profile-button-label").html("save changes");
            $(".edit-profile-icon").css("background-image", "url('/img/Save_icon_White.png')");
            $(".edit-button-target").attr("readonly", false);
            $(".edit-button-target").attr("disabled", false);
            $(".user_introtext").attr("contenteditable", true);
            $(".edit-button-target").css("background-color", "rgba(128,0,0, 0.2)");
            $(".change-image").toggleClass("hidden");
            $(".photo-uploads").toggleClass("hidden");
        } else {
            $(".edit-profile-button-label").html("edit profile");
            $(".edit-profile-icon").css("background-image", "url('/img/Edit_icon_White.png')");
            $(".edit-button-target").attr("readonly", true);
            $(".edit-button-target").attr("disabled", true);
            $(".edit-button-target").attr("contenteditable", false);
            $(".edit-button-target").css("background-color", "transparent");
            var intro = $('.user_introtext').html();
            var birthdate = $('.birthdate').val();
            var gender = $('.gender-select').val();
            var home = $('.home').val();
            var school_home = $('.school_home').val();
            var school_abroad = $('.school_abroad').val();
            var study = $('.study').val();
            console.log(intro+birthdate+gender+home+school_abroad+school_home+study);
            saveProfile(intro,birthdate,gender,home,school_home,school_abroad,study);
            $(".change-image").toggleClass("hidden");
            $(".photo-uploads").toggleClass("hidden");
            $(".image-uploadzone-wrapper").slideUp();
        }
    });

    $(".button-upload-photos").click (function(e) {
        e.preventDefault();
        $(".image-uploadzone-wrapper").slideToggle();
    });


    function saveProfile(intro,birthdate,gender,home,school_home,school_abroad,study){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/updateProfile",
            data:{
                'intro':intro,
                'birthdate':birthdate,
                'gender':gender,
                'home':home,
                'school_home':school_home,
                'school_abroad':school_abroad,
                'study': study
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('profile updated');
            }
        });
    }

});

$(document).mouseup(function (e){

    var container = $("#nav_profile");
    if (!container.is(e.target) && container.has(e.target).length === 0){
        $("#dropdown-menu-profile").hide();
        $( "#nav_profile" ).removeClass("highlighted");
    }

    var container2 =  $('.chat-total');
    if (!container2.is(e.target) && container2.has(e.target).length === 0){
        $(".hide-chat").hide();
        $( "#nav_chat" ).removeClass("highlighted");
        $('body').css('overflow','scroll');
    }
});

<!-- toggle search filter -->
$(document).ready(function() {
    $(".searchButton").click(function() {
        $(".searchButtonOptions").slideToggle();
        $(".searchButton").toggleClass("searchButtonRadiusFix");
        $(".searchBox").toggleClass("searchBoxRadiusFix");

    });
});

/* later nog te bekijken, door absolute positioning van de searchButtonOptions div, pakt het click event daar niet op */
/*
$(document).mouseup(function (e){
    var container1 = $(".searchButton");
    var container2 = $(".searchButtonOptions");
    if (!container1.is(e.target) && !container2.is(e.target) && container1.has(e.target).length === 0){
        container2.addClass("hidden");
    }

    if(container2.is(e.target)) {
        console.log("klikkk");
    }
});
*/


<!-- interest item selection -->
$(document).ready(function() {
    $(".interest-item").click(function() {
        $(this).toggleClass("selected");
    });
});

<!-- toggle crossings map and button on profile page -->
$(document).ready(function() {
    $(".crossings-location-button-wrapper").click(function() {
        $(this).toggleClass("hidden");
        $(".crossings-hide-map-button-wrapper").toggleClass("hidden");
        $(".crossings_map").toggleClass("hidden");
    });
    $(".crossings-hide-map-button-wrapper").click(function() {
        $(this).toggleClass("hidden");
        $(".crossings-location-button-wrapper").toggleClass("hidden");
        $(".crossings_map").toggleClass("hidden");
    });

});

<!-- switch active distance unit -->
$(document).ready(function() {
   $(".distance_unit > ul > li").click(function() {
       if($(this).hasClass("active")) {
       } else {
           var distance = $(this).html();
           console.log(distance);
           changeDistance(distance);
           $(".distance_unit > ul > li").toggleClass("active");
       }
   })
});

//search friends chat
$('.chat-list .searchBox_inner').on('keyup', function(e){
    var name = $(this).val().toLowerCase();
    console.log(name);
    if(name != "" && e.keyCode!=8) {
        console.log('other keys are pressed');
        $('.chat-name').each(function () {
            console.log($(this).html());
            if (!$(this).html().toLowerCase().includes(name)) {
                $(this).parent().parent().parent().parent().hide();
            }
        });
    }else if(e.keyCode == 8){
        console.log('backspace pressed');
        $('.chat-name').each(function () {
            console.log($(this).html());
            if ($(this).html().toLowerCase().includes(name)) {
                $(this).parent().parent().parent().parent().show();
            }
        });
    }
});

<!-- switch between friends and requests -->
$(document).ready(function() {
    $(".see-friends").click(function() {
        $(".see-friends").addClass("active");
        $(".see-requests").removeClass("active");
        $(".requests_container").slideUp();
        $(".friends_container").slideDown();
    })
    $(".see-requests").click(function() {
        $(".see-requests").addClass("active");
        $(".see-friends").removeClass("active");
        $(".requests_container").slideDown();
        $(".friends_container").slideUp();
    })
});


/* header make dropdown as wide as profile item (if wider than 768px) */
$(document).ready(function() {
    if ($(window).width() > 768) {
        var newWidth = $("#nav_profile").width() + 44;
        $("#dropdown-menu-profile").css({'width': (newWidth + 'px')});
    }
});


function changeDistance(distance){
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

        }

    });
    $.ajax({
        method:"POST",
        url:"/updateDistance",
        data:{
            'distance':distance
        }
    }).done(function(response){
        if(response.code==200) {
            console.log('distance settings updated');
        }
    });
}


<!-- mobile switch between chat list and detail -->
$(document).ready(function() {
    if ($(window).width() < 768) {
        $(".chat_to_detail").click(function (e) {
            e.preventDefault();
            $('.chat-detail').animate({left: "-100vw"}, 1000);
            $('.chat_to_list').show();
        });
        $(".chat_to_list").click(function (e) {
            e.preventDefault();
            $('.chat-detail').animate({left: "0vw"}, 1000);
            $('.chat_to_list').hide();
        });
    }
});

<!-- hide send message button in chat when no input in textarea -->
$(document).keyup(function (e) {

    if ($(".new_message").val()) {
        $(".send_message").show();
    }
});

<!-- keep mobile screen on chat detail on submitting of message -->
$(document).ready(function() {
    if ($(document).width() < 768) {
        $(".new_message_form").on('submit', function(e) {
            e.preventDefault();
            $('.chat-detail').css('left', "-100vw");
            $('.new_message').val('');
            });
    }
});

//get chats on page load
$(document).ready(function(){
   if($('.chat-active').length){
       var id = $('.chat-active').data('id');
       getChatsById(id);

       $(".messages_container").animate({scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
   }
});

//click and show conversation
$(document).ready(function(){
    $('.chat_to_detail').on('click', function(e){
        e.preventDefault();
        $(this).find(".chat-name").removeAttr('style');
        $('.chat_to_detail').removeClass('chat-active');
        $('.active-chat-item-indicator').addClass('hidden');
        $(this).find('.active-chat-item-indicator').removeClass('hidden');
        $(this).addClass('chat-active');
        var id = $(this).data('id');
        console.log(id);
        getChatsById(id);
        updateSeenStatus($(this).data('id'));

        $(".messages_container").animate({scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
    })
});

function getChatsById(id){
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

function updateSeenStatus(convid){
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

        }

    });
    $.ajax({
        method:"POST",
        url:"/updateSeenStatus",
        data:{
            'convid':convid
        }
    }).done(function(response){
        if(response.code==200) {
            $('.new-message-indicator').addClass('hidden');
            $('*[data-id="' + convid + '"]').parent().removeAttr('style');
        }
    });
}

//send chats
$(document).ready(function(){
    $("#chat-input").emojioneArea({

        pickerPosition: "top",
        tonesStyle: "bullet",
        events: {
            keyup: function (editor, event) {
                input = this.getText();
                $(".send_message").show();
                if(event.keyCode == 13){
                    input = this.getText();
                    var receiver_id = $('.chat-active').data('user');
                    var conversation_id = $('.chat-active').data('id');
                    updateSeenStatus(conversation_id);
                    saveChat(input,receiver_id,conversation_id);
                    this.setText("");
                }
            },
            click: function(editor,event){
                updateSeenStatus($('.chat-active').data('id'));
            },
            change: function(editor,event){
                input = this.getText();
            },
        }
    });
    $('#emoji-face').click(function () {
        $('.emojionearea-button').click()
    });
    $('.send_message').on('click', function(e){
        e.preventDefault();
        var receiver_id = $('.chat-active').data('user');
        var conversation_id = $('.chat-active').data('id');
        saveChat(input,receiver_id,conversation_id);
        $('.emojionearea-editor').html('');
    });

    function saveChat(input,receiver_id,conversation_id){

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/sendchat",
            data:{
                'message': input,
                'receiver_id': receiver_id,
                'id' : conversation_id
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('message sent');
                var newdiv = '<div class="conversation-message-out"><p class="message message-out">' + input + '</p></div>';
                $('.messages_container').append(newdiv);
                $('.messages_container').scrollTop($('.messages_container')[0].scrollHeight);
            }
        })
    };
});

//script voor locatiebepalingen
$(document).ready(function(){
    var longitude;
    var latitude;
    var functionamount = 0;

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
        storeLocation(latitude, longitude, functionamount);
        functionamount++;
    }

    getLocation();
    window.setInterval(getLocation, 300000);

    function storeLocation(latitude,longitude,f){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        });
        $.ajax({
            method:"POST",
            url:"/location/store",
            data:{
                'longitude': longitude,
                'latitude': latitude,
                'amount': f,
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
});
