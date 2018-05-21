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
    $('.hide-chat').hide();
    $('.dropdown-item-chat').on('click', function(){
        $('.hide-chat').show();
    })
});

<!-- show/hide dropdown menus & labels & pop-ups :-) -->
$(document).ready(function() {
    $( "#nav_chat" ).click(function() {
        $("#dropdown-menu-profile").hide();
        $( "#nav_profile" ).removeClass("highlighted");
        $('.hide-chat').show();
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

    /* password section in settings */
    $(".social_item_connect").click(function(e) {
        e.preventDefault();
       if ($(this).html() == "connect") {
           $(this).html("disconnect");
       } else {
           $(this).html("connect");
       }
    });

    /* social media section in settings */
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
        $(".pop-up-delete-profile").toggleClass("hidden");
        /* EVERYTHING ENDS!!! */
    });

    /* edit profile button */
    $(".edit-profile-button-wrapper").click (function(e) {
        e.preventDefault();
        var allInputs = $( ":input" );
        if ($(".edit-profile-button-label").html() == "edit profile") {
            $(".edit-profile-button-label").html("save changes");
            $(".edit-profile-icon").css("background-image", "url('/img/Save_icon_White.png')");
            allInputs.attr("readonly", false);
            allInputs.attr("disabled", false);
            $(".user_introtext").attr("contenteditable", true);
            $(".change-image").toggleClass("hidden");
        } else {
            $(".edit-profile-button-label").html("edit profile");
            $(".edit-profile-icon").css("background-image", "url('/img/Edit_icon_White.png')");
            allInputs.attr("readonly", true);
            allInputs.attr("disabled", true);
            $(".user_introtext").attr("contenteditable", false);
            $(".change-image").toggleClass("hidden");
        }

    });


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
        $(".searchButtonOptions").toggleClass("hidden");
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
   }
});

//click and show conversation
$(document).ready(function(){
    $('.chat_to_detail').on('click', function(e){
        e.preventDefault();
        $(this).parent().removeAttr('style');
        $('.chat_to_detail').removeClass('chat-active');
        $('.active-chat-item-indicator').addClass('hidden');
        $(this).find('.active-chat-item-indicator').removeClass('hidden');
        $(this).addClass('chat-active');
        var id = $(this).data('id');
        console.log(id);
        getChatsById(id);
        updateSeenStatus($(this).data('id'));
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
            }
        })
    };
    $('.messages_container').scrollTop($('.messages_container')[0].scrollHeight);
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
