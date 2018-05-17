$(document).ready(function() {
    $('.chats-view').scrollTop($('.chats-view')[0].scrollHeight);
    var input = "";
    $("#chat-input").emojioneArea({

        pickerPosition: "top",
        tonesStyle: "bullet",
        events: {
            keyup: function (editor, event) {
                input = this.getText();
                if(event.keyCode == 13){
                    input = this.getText();
                    saveChat(input);
                    this.setText("");
                }
            },
            change: function(editor,event){
                input = this.getText();
            }
        }
    });

    $('#emoji-face').click(function () {
        $('.emojionearea-button').click()
    });

    $('.send-chat').on('click', function(){
        saveChat(input);
        $('.emojionearea-editor').html('');
    })

    function saveChat(input){
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': "{{csrf_token()}}",

            }

        });
        $.ajax({
            method:"POST",
            url:"{{URL::action('ConversationController@addChatToConversation', $conversation)}}",
            data:{
                'message': input,
                'sender_id': '{{$myUser->id}}',
                'receiver_id': 3,
                'id' : '{{$conversation->id}}'
            }
        }).done(function(response){
            if(response.code==200) {
                console.log('message sent');
            }
        })
    }

});