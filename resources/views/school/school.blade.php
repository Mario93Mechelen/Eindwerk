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




        </div>  <!-- einde school page content -->

    </div>  <!-- einde school page -->

@endsection

@section('scripts')



@endsection