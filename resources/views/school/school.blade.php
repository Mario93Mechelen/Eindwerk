@extends('layouts.master')

@section('content')

    <div class="school_page">

        <div class="cover_image"></div>

        <div class="school_page_content_wrapper">
        <div class="school_page_content">

            <div class="upper_section">
                <h2 class="school_name">{{$myUser->school ? $myUser->school->name : 'please fill in school_abroad at your profile'}}</h2>
            </div>

            <div class="school-list-toggle">
                <ul>
                    <li class="see-school-info active">school info</li>
                    <li class="see-student-feed">student feed</li>
                </ul>
            </div>

            <p class="school_introtext edit-button-target">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae congue dolor, in placerat sapien. Nam porta suscipit tortor non dapibus. Etiam quis felis ut.</p>

            <div class="button-wrapper members-button-wrapper">
                <a href="#" class="button member-list-button">
                    <div class="icon member-icon"></div>
                    <p>list of members</p>
                </a>
            </div>

            <div class="school-info-section">
                @if(!$myUser->school->posts()->where('type','school')->get()->isEmpty())
                    @foreach($myUser->school->posts()->where('type','school')->get() as $post)
                        <div class="post school-info-post">
                            <div class="post-top post-section">
                                <img class="post-img" src="/img/profile_pic_default.jpg" alt=""/>
                                <div class="post-top-right">
                                    <h4 class="post-name">{{$myUser->school->name}}</h4>
                                    <p class="post-time">2 hours ago</p>
                                </div>
                            </div>
                            <div class="post-mid post-section">
                                <p class="post-message">{{$post->body}}</p>
                            </div>
                            <div class="post-bottom post-section">
                                <a href="" class="show-hide-post-comments">show comments</a>
                            </div>
                            <div class="post-comment-section post-section">

                                <div class="post-comments">
                                    @if(!$post->comments->isEmpty())
                                        @foreach($post->comments as $comment)
                                            <div class="post-comment">
                                                <img class="post-comment-img" src="{{url($comment->user->avatar)}}" alt=""/>
                                                <div class="post-comment-right">
                                                    <h4 class="post-comment-name">{{$comment->user->first_name.' '.$comment->user->last_,ame}}</h4>
                                                    <p class="post-comment-message">{{$comment->body}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="post-new-comment">
                                        <img class="post-new-comment-img" src="{{$myUser->avatar}}" alt=""/>
                                        <form action="{{URL::action('ProfileController@postComment')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="text" name="comment" class="commit-comment-student-feed">
                                            <input type="hidden" name="postID" value="{{$post->id}}">
                                            <button type="submit" class="commit-comment-school-feed"></button>
                                        </form>
                                </div>

                            </div>
                        </div>  <!-- einde post -->
                    @endforeach
                @endif



            </div>  <!-- einde school info section -->

            <div class="student-feed-section">

                <div class="button-wrapper new-post-button-wrapper">
                    <a href="#" class="button">
                        <img class="new-post-img" src="{{url($myUser->avatar)}}" alt=""/>
                        <input placeholder="create new post" id="post-body">
                    </a>

                    <div class="new-post-bottom">
                            <div class="image-uploadzone-wrapper">
                                <div class="image-uploadzone">
                                    <form id="addphotos" class="dropzone" action="{{URL::action('PhotoController@store', ['type' => 'post', 'id' => 0])}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="dropzone-previews"></div>
                                    </form>
                                </div>
                            </div>
                        <div class="buttons">
                            <a class="send add-post preferred" href="">send</a>
                            <a class="cancel not-preferred" href="">cancel</a>
                        </div>
                    </div>


                </div>
                @if(!$myUser->school->posts()->where('type','student')->get()->isEmpty())
                    @foreach($myUser->school->posts()->where('type','student')->orderBy('created_at','desc')->get() as $post)
                        <div class="post student-feed-post">
                            <div class="post-top post-section">
                                <img class="post-img" src="{{$post->user->avatar}}" alt=""/>
                                <div class="post-top-right">
                                    <h4 class="post-name">{{$post->user->first_name.' '.$post->user->last_name}}</h4>
                                    <p class="post-time">2 hours ago</p>
                                </div>
                            </div>
                            <div class="post-mid post-section">
                                <p class="post-message">{{$post->body}}</p>
                                @if($post->photos)
                                    <div class="post-photos photo-section">
                                        @foreach($post->photos as $photo)
                                            <img class='userphoto' src="{{url($photo->path)}}" alt="{{$photo->path}}">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="post-bottom post-section">
                                <a href="" class="show-hide-post-comments">show comments</a>
                            </div>
                            <div class="post-comment-section post-section">

                                <div class="post-comments">
                                    @if(!$post->comments->isEmpty())
                                        @foreach($post->comments as $comment)
                                            <div class="post-comment">
                                                <img class="post-comment-img" src="{{$comment->user->avatar}}" alt=""/>
                                                <div class="post-comment-right">
                                                    <h4 class="post-comment-name">{{$comment->user->first_name.' '.$comment->user->last_name}}</h4>
                                                    <p class="post-comment-message">{{$comment->body}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="post-new-comment">
                                    <img class="post-new-comment-img" src="{{$myUser->avatar}}" alt=""/>
                                    <form action="{{URL::action('ProfileController@postComment')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="text" name="comment" class="comment-student-feed">
                                        <input type="hidden" name="postID" value="{{$post->id}}">
                                        <button type="submit" class="commit-comment-student-feed"></button>
                                    </form>
                                </div>

                            </div>
                        </div>  <!-- einde post -->
                    @endforeach
                @endif


            </div>  <!-- einde student feed section -->

        </div>  <!-- einde school page content -->

        <div class="member-list" id="member-list">

            <div class="member-list-inner">

                <h2>member list</h2>

                @if(!$myUser->school->users->isEmpty())
                    @foreach($myUser->school->users as $user)
                        <div class="item item-member item-list col-xs-12">
                            <a class="item-content" href="{{URL::action('ProfileController@show', $user)}}">
                                <img class="member-avatar" src="{{url($user->avatar)}}">
                                <div class="member-right">
                                    <div class="member-name">
                                        <p class="member-name">{{$user->first_name.' '.$user->last_name}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif

            </div>

        </div>  <!-- einde member list section -->

    </div>  <!-- einde school page -->
    </div>

    <div class="overlay"></div>
    <div class="overlay2"></div>

@endsection

@section('scripts')
    <script src="/js/dropzone.min.js" type="text/javascript"></script>
    <script>
        Dropzone.options.addphotos = {
            paramName: 'photo',
            maxFilesize: 3, //3MB
            acceptedFiles: '.jpg, .jpeg, .png, .bmp, .gif',
            error: function(file, response) {
                var message = response.errors.addphotos;
                console.log(response);
            },
        }
        $('.commit-comment-student-feed').on('click', function(){
           var comment = $('.comment-student-feed').val();
        });
        $('.add-post').on('click', function() {
            var body = $('#post-body').val();
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method: "POST",
                url: "{{URL::action('ProfileController@addPost')}}",
                data: {
                    'body': body,
                    'id': '{{$myUser->school->id}}',
                    'type': 'student'
                }
            }).done(function (response) {
                if (response.code == 200) {
                    console.log('this was posted');
                    window.location.reload();
                }
            });
        });

    </script>

@endsection