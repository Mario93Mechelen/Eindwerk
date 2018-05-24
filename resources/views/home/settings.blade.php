@extends('layouts.master')

@section('content')

    <div class="settings_page">

        <div class="settings_page_content">

            <div class="general_settings settings-section">
                <h2 class="section_title">general settings</h2>

                <div class="distance_unit">
                    <ul>
                        <li class="{{($myUser->setting->distance=='km') ? 'active' : null}}">kilometers</li>
                        <li class="{{($myUser->setting->distance=='mile') ? 'active' : null}}">miles</li>
                    </ul>
                </div>

                <form class="settings_subsection general_email">
                    <h4 class="subsection_title">
                        <p>email</p>
                        <a id="edit_email" href="">edit</a>
                    </h4>

                    <div class="settings_item">
                        <p class="item_label">email</p>
                        <input type="email" id="email-settings" value="{{$myUser->email}}">
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
                            <input type="text" id="settings-oldpassword" value="current password">
                        </div>

                        <div class="settings_item password_item">
                            <p class="item_label">new password</p>
                            <input type="text" class="new_password1" value="new password">
                        </div>

                        <div class="settings_item password_item">
                            <p class="item_label">new password repeat</p>
                            <input type="text" class="new_password2" value="new password repeat">
                        </div>

                    </div>

                </form>

                <form class="settings_subsection general_social">

                    <!-- facebook -->
                    <div class="settings_item social_item">
                        <i class="fab fa-facebook"></i>
                        <p class="item_label">facebook</p>
                        <a class="social_item_connect" href="">{{$myUser->setting->facebook ? 'disconnect' : 'connect'}}</a>
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

                        @foreach($myUser->blocked as $b)
                            <div class="settings_item blocked_user_item">
                                <img  src="{{url($b->avatar)}}" alt=""/>
                                <p class="item_label">{{$b->first_name.' '.$b->last_name}}</p>
                                <a href="" class="unblock-me" data-user="{{$b->id}}">unblock</a>
                            </div>
                        @endforeach

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
                            <input type="checkbox" class="email_notifications" id="settings-email_message" {{$myUser->setting->email_messages ? 'checked' : null}}>
                            <span class="checkmark"></span>
                        </div>
                    </div>
                    <div class="settings_item">
                        <p class="item_label">friend requests</p>
                        <div class="checkbox-container">
                            <input type="checkbox" class="email_notifications" id="settings-email_friends" {{$myUser->setting->email_friends ? 'checked' : null}}>
                            <span class="checkmark"></span>
                        </div>
                    </div>
                    <div class="settings_item">
                        <p class="item_label">group messages</p>
                        <div class="checkbox-container">
                            <input type="checkbox" class="email_notifications" id="settings-email_groups" {{$myUser->setting->email_groups ? 'checked' : null}}>
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

    </script>

@endsection