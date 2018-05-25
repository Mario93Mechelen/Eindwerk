@extends('layouts.master')

@section('content')

    <div class="school_page">

        <div class="cover_image"></div>

        <div class="school_page_content">

            <div class="upper_section">
                <h2 class="school_name">Thomas More Mechelen Campus Kruidtuin</h2>
            </div>

            <div class="school-list-toggle">
                <ul>
                    <li class="see-school-info active">school info</li>
                    <li class="see-student-feed">student feed</li>
                </ul>
            </div>

            <p class="school_introtext edit-button-target">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae congue dolor, in placerat sapien. Nam porta suscipit tortor non dapibus. Etiam quis felis ut.</p>

            <div class="button-wrapper members-button-wrapper">
                <a href="#" class="button">
                    <div class="icon member-icon"></div>
                    <p>list of members</p>
                </a>
            </div>

            <div class="school-info-section">

                <div class="post school-info-post">
                    <div class="post-top post-section">
                        <img class="post-img" src="/img/profile_pic_default.jpg" alt=""/>
                        <div class="post-top-right">
                            <h4 class="post-name">Amber Heard</h4>
                            <p class="post-time">2 hours ago</p>
                        </div>
                    </div>
                    <div class="post-mid post-section">
                        <p class="post-message">This is a post message, which was typed as an example of what a post
                            message might look like, you know. Yeah boiii.</p>
                    </div>
                    <div class="post-bottom post-section">
                        <a href="">show comments</a>
                    </div>
                    <div class="post-bottom post-section post-comment-section">
                        <div class="post-comment"> <!-- to be hidden -->
                            <img class="post-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                            <div class="post-comment-top-right">
                                <h4 class="post-comment-name">Amber's Sister</h4>
                                <p class="post-comment-message">I concur with that statement, this comment is just
                                    here to acknowledge what was written before.</p>
                            </div>
                        </div>
                        <div class="post-comment"> <!-- to be hidden -->
                            <img class="post-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                            <div class="post-comment-top-right">
                                <h4 class="post-comment-name">Amber's Sister</h4>
                                <p class="post-comment-message">I concur with that statement, this comment is just
                                    here to acknowledge what was written before.</p>
                            </div>
                        </div>
                        <div class="post-new-comment">
                            <form>
                                <img class="post-new-comment-img" src="/img/profile_pic_default.jpg" alt=""/>
                                <form>
                                    <input type="text">
                                    <button type="submit"></button>
                                </form>
                            </form>
                        </div>
                    </div>
                </div>

            </div>




        </div>  <!-- einde school page content -->

    </div>  <!-- einde school page -->

@endsection

@section('scripts')



@endsection