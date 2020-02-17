@extends('layouts.master')

@section('style')

<style>
/* Make it a marquee */
.marquee {
    width: 450px;
    margin: 0 auto;
    overflow: hidden;
    white-space: nowrap;
    box-sizing: border-box;
    animation: marquee 50s linear infinite;
}

.marquee:hover {
    animation-play-state: paused
}

/* Make it move */
@keyframes marquee {
    0%   { text-indent: 27.5em }
    100% { text-indent: -105em }
}

/* Make it pretty */
.microsoft {
    padding-left: 1.5em;
    position: relative;
    font: 16px 'Segoe UI', Tahoma, Helvetica, Sans-Serif;
}

/* ::before was :before before ::before was ::before - kthx */
.microsoft:before, .microsoft::before {
    z-index: 2;
    content: '';
    position: absolute;
    top: -1em; left: -1em;
    width: .5em; height: .5em;
    box-shadow: 1.0em 1.25em 0 #0e5e7f,
        		1.6em 1.25em 0 #00A1F1,
        		1.0em 1.85em 0 #00A1F1,
        		1.6em 1.85em 0 #0e5e7f;
}

.microsoft:after, .microsoft::after {
    z-index: 1;
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 2em; height: 2em;
    background-image: linear-gradient(90deg, white 70%, rgba(255,255,255,0));
}

/* Style the links */
.vanity {
    color: #333;
    text-align: center;
    font: .75em 'Segoe UI', Tahoma, Helvetica, Sans-Serif;
}

.vanity a, .microsoft a {
    color: #1570A6;
    transition: color .5s;
    text-decoration: none;
}

.vanity a:hover, .microsoft a:hover {
    color: #F65314;
}

/* Style toggle button */
.toggle {
	display: block;
    margin: 2em auto;
}

</style>

@endsection

@section('content')

<section>
    <div class="container">

        <div class="divider-custom">
            <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                   Online Booking
                </div>
            <div class="divider-custom-line"></div>
        </div>

        <h4 class="text-center"><i>Welcome To The FDA Online Booking System</i></h4>
        <br>
        <p class="microsoft marquee text-info">Hello, here you can book to register your products to FDA, firstly you must <strong><a href="{{ route("user.sign-up") }}" class="text-warning"> Register</a></strong> your product, after that you can <strong><a href="{{ route("user-login") }}" class="text-warning">login</a></strong> with your account into the <strong><a href="{{ route("/") }}" class="text-warning"></strong> booking system </a> and you can book to get tokens.</p>
    </div>

    </section>

@endsection


