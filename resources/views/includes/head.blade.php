<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Chat App</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
{{-- Jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- Bootstrap --}}
<link rel="stylesheet" href="{{ asset('bootstrap-4.0.0/css/bootstrap.min.css') }}">
<script src="{{ asset('bootstrap-4.0.0/js/bootstrap.bundle.min.js') }}"></script>
{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
{{-- Include EmojiPicker CSS and JS --}}
{{-- <link rel="stylesheet" href="/path/to/emoji-picker.css">
<script src="/path/to/emoji-picker.js"></script> --}}
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css" />
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css " rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<style>
    .inner-rightbar-cover {
        background: url("{{ asset('assets/images/bg/welcome.jpg') }}") no-repeat center center/cover;
    }

    .conversation-chats-container {
        background: url("{{ asset('assets/images/bg/dark-travel.jpeg') }}") no-repeat center/cover;
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .preloader {
        display: flex;
        align-items: center;
        justify-content: center;

    }

    .preloader img {
        height: 10%;
        animation: rotate 2s linear infinite;
    }

    .inner-search{
        background:  url("{{ asset('assets/images/bg/search.jpeg') }}") no-repeat center center/cover;
    }
</style>