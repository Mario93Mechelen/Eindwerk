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
                                        <img class="post-new-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                                        <form>
                                            <input type="text"  class="commit-comment-student-feed">
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
                        <img class="new-post-img" src="/img/profile_pic_default.jpg" alt=""/>
                        <input placeholder="create new post">
                    </a>

                    <div class="new-post-bottom">
                        <div class="add-pictures">
                            <a class="new-post-add-picture" href="">+ Add picture</a>
                            <div class="img-in-post-wrapper">
                                <img class="img-in-post" src="/img/profile_pic_default.jpg" alt=""/>
                                <div class="change-image delete-image" data-photo=""><i class="fas fa-times"></i></div>
                            </div>
                            <div class="img-in-post-wrapper">
                                <img class="img-in-post" src="/img/profile_pic_default.jpg" alt=""/>
                                <div class="change-image delete-image" data-photo=""><i class="fas fa-times"></i></div>
                            </div>

                        </div>
                        <div class="buttons">
                            <a class="send preferred" href="">send</a>
                            <a class="cancel not-preferred" href="">cancel</a>
                        </div>
                    </div>


                </div>
                @if(!$myUser->school->posts()->where('type','school')->get()->isEmpty())
                    @foreach($myUser->school->posts()->where('type','student')->get() as $post)
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
                            </div>
                            <div class="post-bottom post-section">
                                <a href="" class="show-hide-post-comments">show comments</a>
                            </div>
                            <div class="post-comment-section post-section">

                                <div class="post-comments">
                                    @if(!$post->comments->isEmpty())
                                        @foreach($post->comments as $comment)
                                            <div class="post-comment">
                                                <img class="post-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                                                <div class="post-comment-right">
                                                    <h4 class="post-comment-name">{{$comment->user->first_name.' '.$comment->user->last_name}}</h4>
                                                    <p class="post-comment-message">{{$comment->body}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="post-new-comment">
                                    <img class="post-new-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                                    <form>
                                        <input type="text" class="comment-student-feed">
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



@endsection