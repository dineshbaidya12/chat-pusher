<!DOCTYPE html>
<html lang="en">

<head>
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
    <style>
        .conversation-chats-container {
            width: 100%;
            height: 97vh;
            background: url('{{ asset('assets/images/bg/dark-travel.jpeg') }}') no-repeat center/cover;
        }

        .small-right-bar {
            /* display: none; */
        }

        .emoji-btn {
            top: 19px;
            left: 15px;
            color: #464646c9;
            font-size: 19px;
            cursor: pointer;
        }

        .emoji-div {
            display: none;
            width: 93%;
            bottom: 97px;
            z-index: 999999;
            left: 11px;
            scrollbar-width: thin;
        }

        emoji-picker {
            width: 100%;
            --num-columns: 15;
            --emoji-size: 1.5rem;
            --background: #202124;
        }

        .picker {
            width: 100%;
        }

        .more-opt-left-icon {
            padding-right: 12px;
        }

        .more-option-left {
            right: 24px;
            top: 32px;
            background: white;
            color: black;
            list-style: none;
            width: 123px;
            background: white;
            color: black;
            font-size: .8rem;
            cursor: pointer;
            padding: 0px 7px 0px 7px;
            user-select: none;
            overflow: hidden;
            transition: all 0.2s ease-in;
            opacity: 0;
            height: 0;
            z-index: 999;
        }

        .more-option-left a {
            text-decoration: none;
            color: black !important;
        }

        .more-option-left a li {
            font-family: var(--primary-heading);
            padding-bottom: 2px;
        }

        .more-option-left.active {
            padding: 7px;
            opacity: 1;
            height: fit-content;
        }


        #right-bar {
            transform: translateX(0px);
        }

        .go-back-cont {
            display: none;
        }

        .no-conv {
            color: white;
            text-align: center;
            background: #31864e;
            display: inline;
            padding: 5px 25px;
            border-radius: 20px;
            margin: auto;
        }

        .no-conv-div {
            display: flex;
            align-items: center;
        }

        .deleted-msg {
            font-size: 14px;
            font-family: 'Josefin Sans', sans-serif;
            font-style: italic;
        }

        .status-deleted {
            width: 15px;
            margin-top: -5px;
        }



        /* Green Circle count how much unread message */

        .unread-msg-count {
            display: inline-block;
            font-family: var(--primary-heading);
            font-size: 12px;
            background: #258825;
            padding: 0px 7px;
            border-radius: 50%;
            margin-left: 5px;
        }

        #type-message {
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #394053 #4f5055;
        }

        #type-message::-webkit-scrollbar {
            width: 8px;
        }

        #type-message::-webkit-scrollbar-thumb {
            background-color: #394053;
        }

        #type-message::-webkit-scrollbar-track {
            background-color: #4f5055;
        }

        .inner-rightbar-cover {
            position: absolute;
            height: 100%;
            width: 100%;
            background: white;
            background: url("{{ asset('assets/images/bg/welcome.jpg') }}") no-repeat center center/cover;
            z-index: 9999;
            right: 0;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .str-conv-h1 {
            font-size: 40px;
            font-family: var(--primary-heading);
            color: white;
            font-weight: bold;
            color: #202124;
            font-weight: bold;
            font-family: var(--primary-heading);
            text-shadow: 1px 1px 1px #f97d7d;
        }

        .preloader {
            height: 100vh;
            width: 100vw;
            background: white;
            z-index: 99999;
            top: 0;
            left: 0;
            position: absolute;
        }

        .add-new-connections {
            bottom: 10px;
            right: 12px;
            z-index: 999;
        }

        .add-new-connections img {
            height: 30px;
            width: 30px;
            object-fit: cover;
            cursor: pointer;
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

        @media (min-width: 420px) and (max-width: 767px) {
            .users-list {
                width: 100%;
                margin-left: 0px;
            }

            .users-list .inner-user-list {
                width: 100%;
            }

            .users-list .inner-user-list .col-12 .row {
                /* background: white; */
                max-height: 82px;
            }

            .users-list .inner-user-list .col-12 .row .users-dp {
                /* display: none; */
                max-width: 62px;
            }

            .users-list .inner-user-list .col-12 .row .user-image-div {
                /* display: none; */
                max-width: 120px;
            }
        }

        @media (min-width: 768px) {
            .user-image-div {
                padding: 0px;
                padding-left: 7px;
            }

            .more-opt-left-icon {
                padding-left: 2px;
                padding-right: 2px;
            }

            .more-option-left {
                right: 16px;
            }

            #right-bar {
                transform: translateX(0px);
            }
        }

        /* For Less than 768px screen */

        @media (max-width: 767px) {
            #right-bar {
                transform: translateX(10px);
            }

            .go-back-cont {
                display: block;
            }
        }

        /* for textarea  */

        @media(min-width:680px) and (max-width:767px) {
            #type-message {
                width: 89%;
            }
        }


        @media(min-width:580px) and (max-width:680px) {
            #type-message {
                width: 87%;
            }
        }

        @media(min-width:463px)and (max-width:580px) {
            #type-message {
                width: 87%;
            }

            .send-msg-btn img {
                top: -16px;
                right: -9px;
                height: 120%;
                width: 120%;
            }
        }

        @media(max-width:463px) {
            #type-message {
                display: block;
                width: 97vw;
                padding-right: 48px;
            }

            .send-msg-btn {
                position: absolute;
                top: 29px;
                right: 5%;
            }

            .send-msg-btn img {
                top: -16px;
                right: 0px;
                height: 120%;
                width: 120%;
            }
        }

        /* for textarea  */

        @media (min-width: 992px) and (max-width: 1286px) {
            .send-msg-btn img {
                top: -16px;
                right: -10px;
                height: 126%;
                width: 129%;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            #type-message {
                width: 88%;
            }

            .send-msg-btn img {
                top: -15px;
                right: -19px;
                height: 135%;
                width: 135%;
            }

            .emoji-div {
                width: 88%;
            }

            emoji-picker {
                --num-columns: 8;
                --emoji-size: 1.5rem;
                --background: #202124;
            }
        }

        #suggetion-container::-webkit-scrollbar {
            width: 8px;
        }

        #suggetion-container::-webkit-scrollbar-thumb {
            background-color: #394053;
        }

        #suggetion-container::-webkit-scrollbar-track {
            background-color: #4f5055;
        }

        #suggetion-container {
            position: absolute;
            width: 100%;
            list-style: none;
            padding: 9px;
            background: white;
            max-height: 150px;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #394053 #4f5055;
            z-index: 999;
        }

        #suggetion-container li {
            padding-top: 5px;
            padding-bottom: 5px;
            cursor: pointer;
            transition: .2s ease-in;
        }


        #suggetion-container li:hover {
            background: #ddd;
        }

        .suggestion-users {
            height: 35px;
            width: 35px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
            margin-right: 10px;
        }

        #request-connection {
            background: #202124 !important;
            color: white;
            opacity: .1;
            cursor: no-drop;
        }
    </style>
</head>

<body class="position-relative">
    <div class="preloader">
        <img src="{{ asset('assets/images/bg/buffer.png') }}">
    </div>
    <div class="page-wrapper">
        <div class="container-flued">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 left-bar inside-container" id="left-bar">
                    <div class="row">
                        <div class="left-bar-header p-2 w-100 position-relative">
                            <div class="add-new-connections position-absolute">
                                <img src="{{ asset('assets/images/dummy-imgs/add.png') }}">
                            </div>
                            <ul class="position-absolute more-option-left" id="more-option-left">
                                <a href="#">
                                    <li>View Profile</li>
                                </a>
                                <a href="{{ route('logout') }}">
                                    <li>Logout</li>
                                </a>
                            </ul>

                            <div class="col-12 position-absolute search-bar-div">
                                <div class="w-100 position-relative">
                                    <input type="text" value="" name="search-users" class="search-users"
                                        id="static-search-users" placeholder="search">
                                    <i
                                        class="fa-solid fa-magnifying-glass cursor-pointer m-1 px-3 color-white position-absolute search-inside-input">
                                    </i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p>Real Chat</p>
                                </div>
                                <div class="col-8 d-flex justify-content-end">
                                    <a href="#search" id="search-user">
                                        <i class="fa-solid fa-magnifying-glass cursor-pointer m-1 px-2 color-white"></i>
                                    </a>
                                    <a href="#more-option" id="more-opt-left">
                                        <i
                                            class="fa-solid fa-ellipsis-vertical cursor-pointer m-1 color-white more-opt-left-icon"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row users-area pt-3">
                                <div class="col-12">
                                    <p class="chats-heading"><i class="fa-solid fa-comments"></i> Chats</p>
                                    <div class="row mt-2 mb-2 cursor-pointer manage-user">
                                        <div class="col-6 text-center added hover transition active" id="added-btn">
                                            <a class="tabs-a" href="/#added">
                                                <p class="margin-0">
                                                    Added
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-6 text-center req hover transition" id="requests-btn">
                                            <a class="tabs-a" href="/#request">
                                                <p class="margin-0">
                                                    @php
                                                        if (count($requestsLists) > 0) {
                                                            echo 'Request(' . count($requestsLists) . ')';
                                                        } else {
                                                            echo 'Request';
                                                        }
                                                    @endphp
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row users-list position-relative">
                                        <div class="inner-user-list added-lists" id="added-lists">

                                            <div class="col-12">

                                                @if (count($connections) > 0)
                                                    @foreach ($connections as $conn)
                                                        @if ($conn->first_user !== auth()->user()->id)
                                                            @php
                                                                $name = $conn->firstUserDetails->name;
                                                                $profilePic = $conn->firstUserDetails->profile_pic;
                                                                $connectedUserId = $conn->firstUserDetails->id;
                                                                $connectedUsername = $conn->firstUserDetails->username;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $name = $conn->sedondUserDetails->name;
                                                                $profilePic = $conn->sedondUserDetails->profile_pic;
                                                                $connectedUserId = $conn->sedondUserDetails->id;
                                                                $connectedUsername = $conn->sedondUserDetails->username;
                                                            @endphp
                                                        @endif


                                                        <div class="row indivisual-user"
                                                            data-id="{{ $connectedUserId }}"
                                                            data-username="{{ $connectedUsername }}"
                                                            data-name="{{ $name }}">
                                                            <div class="user-image-div col-3">
                                                                @if ($profilePic != null || $profilePic != '' || !file_exists('user_profile_picture/thumb/' . $profilePic))
                                                                    <img src="{{ asset('user_profile_picture/thumb/' . $profilePic) }}"
                                                                        alt="Lorem Ipsum" class="users-dp">
                                                                @else
                                                                    <img src="{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}"
                                                                        alt="Lorem Ipsum" class="users-dp">
                                                                @endif
                                                            </div>
                                                            <div class="user-details-div col-9">
                                                                <p class="m-0 user-name">
                                                                    {{ $name ?? 'Server Issue' }}
                                                                </p>
                                                                @if ($conn->last_message != '')
                                                                    @php
                                                                        try {
                                                                            $lastMessageDetails = $conn->messageDetails[0];
                                                                        } catch (\Exception $err) {
                                                                            $lastMessageDetails = (object) [
                                                                                'sender' => '',
                                                                                'status' => '',
                                                                                'message' => '',
                                                                            ];
                                                                        }
                                                                    @endphp
                                                                    <p class="m-0 message-details">
                                                                        @if ($lastMessageDetails->sender == auth()->user()->id && $lastMessageDetails->status == 'unseen')
                                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                                alt="tick"
                                                                                class="status-unread">{{ \Illuminate\Support\Str::limit(strip_tags($lastMessageDetails->message), 30) }}
                                                                        @elseif ($lastMessageDetails->sender == auth()->user()->id && $lastMessageDetails->status == 'seen')
                                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                                alt="tick"
                                                                                class="status-read">{{ \Illuminate\Support\Str::limit(strip_tags($lastMessageDetails->message), 30) }}
                                                                        @elseif ($lastMessageDetails->status == 'deleted')
                                                                            <img src="{{ asset('assets/images/dummy-imgs/block.png') }}"
                                                                                alt="tick"
                                                                                class="status-deleted"><span>This
                                                                                Message
                                                                                was Deleted</span>
                                                                        @else
                                                                            {{ \Illuminate\Support\Str::limit(strip_tags($lastMessageDetails->message), 30) }}
                                                                        @endif
                                                                    </p>
                                                                @else
                                                                    <p class="m-0 message-details">
                                                                        <span style="color:grey;">No Conversation
                                                                            Yet</span>
                                                                    </p>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <span class="separtor"></span>
                                                    @endforeach
                                                @else
                                                    <p>No Connections</p>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="inner-user-list requests-lists">

                                            <div class="col-12">

                                                @if (count($requestsLists) > 0)
                                                    @foreach ($requestsLists as $req)
                                                        @if ($req->first_user !== auth()->user()->id)
                                                            @php
                                                                $id = $req->first_user;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $id = $req->second_user;
                                                            @endphp
                                                        @endif


                                                        @php
                                                            $userDetails = app('App\Http\Controllers\controller')->getUserDetails($id);
                                                            if (!$userDetails) {
                                                                continue;
                                                            }
                                                        @endphp

                                                        @if ($userDetails->profile_pic != '')
                                                            @php
                                                                $profilePic = asset('user_profile_picture/' . $userDetails->profile_pic);
                                                            @endphp
                                                        @else
                                                            @php
                                                                $profilePic = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
                                                            @endphp
                                                        @endif

                                                        <div class="row indivisual-user">
                                                            <div class="user-image-div col-3">
                                                                <img src="{{ $profilePic }}"
                                                                    alt="{{ $userDetails->name }}" class="users-dp">
                                                            </div>
                                                            <div class="user-details-div col-4 p-0">
                                                                <p class="m-0 user-name overflow-slide">
                                                                    {{ $userDetails->name ?? '' }}
                                                                    {{ '(' . $userDetails->username . ')' }}
                                                                </p>
                                                                <p class="m-0 message-details h-0">
                                                                    {{ app('App\Http\Controllers\controller')->formatTimeAgo($req->created_at) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-5 p-0 req-action">
                                                                <button data-id="{{ $req->id }}"
                                                                    data-action="accept"
                                                                    data-username="{{ $userDetails->name }}"
                                                                    class="btn req-action-btn accept-btn"><img
                                                                        src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                        alt="Accept"></button>
                                                                <button data-id="{{ $req->id }}"
                                                                    data-action="reject"
                                                                    data-username="{{ $userDetails->name }}"
                                                                    class="btn req-action-btn reject-btn"><img
                                                                        src="{{ asset('assets/images/dummy-imgs/reject.png') }}"
                                                                        alt="Accept"></button>
                                                            </div>
                                                        </div>

                                                        <span class="separtor"></span>
                                                    @endforeach
                                                @else
                                                    <div class="row">
                                                        <div class="no-requests">
                                                            You Don't Have Any Request
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-9 right-bar" id="right-bar">

                    <div class="inner-rightbar-cover">
                        <h1 class="str-conv-h1">Start Conversation<span
                                style="color:#202124; font-weight:bold; font-family:var(--primary-heading);text-shadow: 1px 1px 1px #f97d7d;">
                                With
                            </span>Your
                            Connections</h1>
                    </div>


                    <div class="row">
                        <div class="col-12 m-auto conversation-container">
                            <div class="conversation-header">
                                <div class="conversation-inner-header d-flex w-100">

                                    <div class="left-conv-header d-flex">
                                        <div class="go-back-cont div-sameline">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </div>
                                        <div class="conversation-person-details d-flex">
                                            <div class="conversation-user-img div-sameline">
                                                <img src="{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}"
                                                    alt="" id="chat-with-img">
                                            </div>
                                            <div class="conversation-user-name">
                                                <p class="username" id="chat-with"></p>
                                                <p class="current-status" id="chat-with-status">Typing...</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="right-conv-header">
                                        <div class="more-options position-relative">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                            <ul class="options position-absolute" id="options-conversation">
                                                <li>View Profile</li>
                                                <li>Wallpaper</li>
                                                <li>Block</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="conversation-chats-container position-relative">
                                <div class="position-absolute emoji-div">

                                    <emoji-picker for="type-message"></emoji-picker>
                                </div>


                                <div class="chats" id="chats">

                                    {{-- Dynamically send content  --}}

                                </div>


                                <div class="typing-area position-absolute">

                                    <div class="position-absolute emoji-btn">
                                        <i class="fas fa-smile"></i>
                                    </div>

                                    <form action="{{ route('send-msg') }}" id="send-msg" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <textarea name="type_message" id="type-message" placeholder="Type your message"></textarea>
                                    </form>
                                    <div class="send-msg-btn">
                                        <img src="{{ asset('assets/images/dummy-imgs/send.png') }}" alt="send"
                                            class="cursor-pointer" id="send-the-msg" data-id="">
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ------------------ MOdel  -------------------- --}}

    <div class="modal fade" tabindex="-1" role="dialog" id="requestModel" aria-labelledby="requestModelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModelLabel">Request to make connection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form content goes here -->
                    <form>
                        <div class="form-group position-relative" id="request-username">
                            <label for="request-user-type">Username</label>
                            <input type="text" class="form-control" id="request-user-type"
                                placeholder="testing.web017" autocomplete="off" name="request-the-db">
                            <ul id="suggetion-container">
                            </ul>
                        </div>
                        <input type="hidden" id="request-user-id" name="request_user_id" value=""
                            style="color:black;">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn" id="request-connection">Request</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ------------------ MOdel  -------------------- --}}


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.preloader').css('display', 'none');


            //------------scroll to bottom 
            var chatsSec = $('#chats');
            chatsSec.css('scroll-behavior', 'auto');

            function scrollToBottom() {
                // console.log('scrol to bottom');
                chatsSec.scrollTop(chatsSec.prop('scrollHeight'));
            }

            scrollToBottom();

            chatsSec.css('scroll-behavior', 'smooth');
            //------------scroll to bottom 



            let addReq = 'add';
            let isOpenSearchDiv = false;
            let moreOptionLeft = false;
            let moreConv = false;
            // search bar function
            $('#search-user').on('click', function() {
                openSearch();
            });

            window.addEventListener('popstate', function(event) {
                if (isOpenSearchDiv) {
                    closeSearch();
                    $('#requests-btn').click();
                }
            });


            // ---------------- Functions Area

            // Seacrh Bar Div

            function openSearch() {
                closeMoreOptionLeft();
                $('.search-bar-div').css('display', 'block');
                setTimeout(() => {
                    $('.search-bar-div').css('transform', 'translateY(-0px)');
                }, 10);

                $('input[name="search-users"]').val('');
                $('input[name="search-users"]').focus();
                setTimeout(() => {
                    isOpenSearchDiv = true;
                }, 400);
            }

            function closeSearch() {
                $('.search-bar-div').css('transform', 'translateY(-50px)');
                setTimeout(() => {
                    isOpenSearchDiv = false;
                    $('.search-bar-div').css('display', 'none');
                    $('#static-search-users').val('');
                    $('#added-lists .indivisual-user').show();
                    $('.separtor').show();
                }, 400);
            }

            function addReqButton() {
                if (addReq == 'add') {
                    $('#requests-btn').click();
                } else {
                    $('#added-btn').click();
                }
            }

            $(document).on('click', '.right-bar, .users-area', function() {
                if (isOpenSearchDiv) {
                    closeSearch();
                }
                closeMoreOptionLeft();
            });

            $('#requests-btn').on('click', function() {
                addReq = 'req';
                $('.requests-lists').css('transform', 'translateX(0%)');
                $('.added-lists').css('transform', 'translateX(-100%)');
                $('#requests-btn').addClass('active');
                $('#added-btn').removeClass('active');
            });

            $('#added-btn').on('click', function() {
                addReq = 'add';
                $('.requests-lists').css('transform', 'translateX(100%)');
                $('.added-lists').css('transform', 'translateX(0%)');
                $('#requests-btn').removeClass('active');
                $('#added-btn').addClass('active');
            });

            //-----------more option conversation
            $('#options-conversation').removeClass('active');
            $('.more-options').on('click', function() {
                if (!moreConv) {
                    moreConv = true;
                    $('#options-conversation').addClass('active');
                } else {
                    moreConv = false;
                    $('#options-conversation').removeClass('active');
                }
            });

            $(document).on('click', '.left-bar-header, .conversation-chats-container', function() {
                if (moreConv) {
                    closeMoreOptionConversation();
                }
            });

            function closeMoreOptionConversation() {
                moreConv = false;
                $('#options-conversation').removeClass('active');
            }

            //-----------more option 


            //---show hide time 

            $(document).on('click', '.parent-conv', function() {
                var messageTime = $(this).find('.message-time');
                if (messageTime.css('display') == 'none') {
                    messageTime.css('display', 'block');
                } else {
                    messageTime.css('display', 'none');
                }
            });

            //--------show hide time

            //-----type 
            let textarea = $('#type-message');

            // Update textarea height on input change
            textarea.on('input', function() {
                resizeTextarea();
            });

            // Initial resize
            resizeTextarea();

            function resizeTextarea() {
                // Set textarea height to auto to get the actual scroll height
                textarea.height('auto');

                // Set the textarea height to its scroll height if it's less than the max height, otherwise set it to the max height
                textarea.height(Math.min(textarea[0].scrollHeight, parseInt(textarea.css('max-height'))));
            }
            //-------type

            // ----------------- More opt left --------------//
            $('#more-opt-left').on('click', function(e) {
                if (!moreOptionLeft) {
                    moreOptionLeft = true;
                    $('#more-option-left').addClass('active');
                } else {
                    closeMoreOptionLeft();
                }
            });

            function closeMoreOptionLeft() {
                if (moreOptionLeft) {
                    moreOptionLeft = false;
                    $('#more-option-left').removeClass('active');
                }
            }

            closeMoreOptionLeft();

            // ----------------- More opt left --------------//


            {{--  // <div class="parent-conv sender">
            //     <div class="conversations-sender conversations">
            //         <p>
            //             @if ($msg->status !== 'deleted')
            //                 {{ $msg->message ?? '' }}
            //             @else
            //                 <img style="padding-top:3px; opacity: .4;"
            //                     src="{{ asset('assets/images/dummy-imgs/block.png') }}" class="status-deleted"><span
            //                     class="deleted-msg">This Message was
            //                     Deleted</span>
            //             @endif
            //         </p>
            //     </div>
            //     <div class="message-time">{{ \Carbon\Carbon::parse($msg->time)->format('h:iA') }}</div>
            // </div>
            --}}


            //----------- send message ---------//
            $('#send-the-msg').on('click', function() {
                $('.no-conv').css('display', 'none');
                let chatsDiv = $('#chats');
                let message = $('#type-message').val().trim();
                let id = $(this).data('id');
                // console.log(message);

                if (id != '' && message !== '') {
                    var newDiv = $('<div>', {
                        'class': 'parent-conv sender'
                    });

                    $.ajax({
                        url: "{{ route('send-messasge') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            message: message,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // console.log(data);
                            if (data.status) {
                                let newDivContent =
                                    `<div class="conversations-sender conversations">${data.message}</p></div>
                                    <div class="message-time">${data.time}</div>`;
                                newDiv.html(newDivContent);
                                chatsDiv.append(newDiv);
                                scrollToBottom();
                                $('#type-message').val('');
                            } else {
                                Swal.fire({
                                    title: 'Something went wrong please try again letter or refresh the page.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                } else {
                    // console.log('spaces');
                }

            });
            //----------- send message ---------//


            // ------------------ static search users -------------------- //


            $('#static-search-users').on('input', function() {
                let value = $(this).val().toLowerCase();
                let addedLists = $('#added-lists .indivisual-user');

                addedLists.hide();
                addedLists.filter(function() {
                    return $(this).data('name').toLowerCase().includes(value);
                }).show();

                // Hide separators that are next to hidden .indivisual-user elements
                addedLists.filter(':hidden').each(function() {
                    $(this).next('.separtor').hide();
                });

            });

            // ------------------ static search users -------------------- //

            // ------------- presss ctrl + enter to send msg -------------- //

            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.key === 'Enter') {
                    $('#send-the-msg').click();
                }
            });

            // ------------- presss ctrl + enter to send msg -------------- //

            // ---------------------- check For new message every 500 milisecond ---------------------- //


            // ------------------------ ADD NEW USER ------------------//

            // $('.add-new-connections').on('click', function() {
            //     Swal.fire({
            //         title: 'Request',
            //         input: 'text',
            //         inputPlaceholder: 'Type something...',
            //         showCancelButton: true,
            //         confirmButtonText: 'Request',
            //         cancelButtonText: 'Cancel',
            //         showLoaderOnConfirm: true,
            //         preConfirm: (inputValue) => {
            //             // Handle the input value (you can send a request here)
            //             return new Promise((resolve) => {
            //                 setTimeout(() => {
            //                     if (!inputValue) {
            //                         Swal.showValidationMessage(
            //                             'Please enter something');
            //                     }
            //                     resolve(inputValue);
            //                 }, 1000);
            //             });
            //         },
            //         allowOutsideClick: () => !Swal.isLoading()
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             Swal.fire({
            //                 title: 'Success!',
            //                 text: `You entered: ${result.value}`,
            //                 icon: 'success',
            //                 confirmButtonText: 'OK'
            //             });
            //         }
            //     });
            // });

            $('.add-new-connections').on('click', function() {
                $('#request-user-id').val('').trigger('input');
                $('#requestModel').modal('show');
            });

            $('#request-user-type').on('input', function() {
                $('#request-user-id').val('').trigger('input');
                let username = $(this).val();
                if (username != '') {
                    $.ajax({
                        url: "{{ route('search-user', ['username' => ':username']) }}"
                            .replace(':username', username),
                        type: 'GET',
                        success: function(data) {
                            $('#suggetion-container').html(data.message);
                        }
                    });
                } else {
                    $('#suggetion-container li').hide();
                }
            });

            $(document).on('click', '#suggetion-container li', function() {
                $('#request-user-type').val($(this).data('name'));
                $('#suggetion-container li').hide();
                $('#request-user-id').val($(this).data('id')).trigger(
                    'input');
            });


            $('#request-user-id').on('input', function() {
                if ($(this).val() == '') {
                    makeRequestBtnInvisible();
                } else {
                    makeRequestBtnVisible();
                }
            });


            function makeRequestBtnVisible() {
                // console.log('visible');
                $('#request-connection').css('opacity', 1);
                $('#request-connection').css('cursor', 'pointer');
            }

            function makeRequestBtnInvisible() {
                // console.log('invisible');
                $('#request-connection').css('opacity', .1);
                $('#request-connection').css('cursor', 'no-drop');
            }

            $('#request-connection').on('click', function() {
                let id = $('#request-user-id').val();
                // console.log(id);
                if (id != '' && id != 0) {
                    $.ajax({
                        url: "{{ route('send-request') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.status) {
                                $('#request-user-type').val('');
                                $('#request-user-id').val('').trigger('input');
                                Swal.fire({
                                    title: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }


            });

            // ------------------------ ADD NEW USER ------------------//

            //------------------ request username slide ------------------//

            $('.user-name').click(function() {
                var $this = $(this);
                var currentScrollLeft = $this.scrollLeft();

                // console.log(currentScrollLeft);
                var targetScrollLeft = (currentScrollLeft === 0) ? $this[0].scrollWidth : 0;

                $this.animate({
                    scrollLeft: targetScrollLeft
                }, 'slow');
            });

            //------------------ request username slide ------------------//


            //------------------ accept reject action ------------------//


            $('.req-action-btn').on('click', function() {
                let id = $(this).data('id');
                let action = $(this).data('action');
                let username = $(this).data('username');
                let btn = $(this);

                Swal.fire({
                    title: 'Are you sure you want to ' + action + ' ' + username + '?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (id != '' && (action == 'accept' || action == 'reject')) {
                            $.ajax({
                                url: "{{ route('accept-reject-request') }}",
                                type: 'POST',
                                data: {
                                    id: id,
                                    action: action,
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(data) {
                                    if (data.status) {
                                        Swal.fire({
                                            title: data.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                        var indivisualUser = btn.closest(
                                            '.indivisual-user');
                                        indivisualUser.next('.separtor').hide();
                                        indivisualUser.hide();
                                        $('#added-lists .col-12').append(data.data
                                            .htmlStructure);
                                        $('#added-lists .col-12 p:first').hide();
                                        handleScreenSizeChange();
                                    } else {
                                        Swal.fire({
                                            title: data.message,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Invalid request parameters.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });



            //------------------ accept reject action ------------------//


            setInterval(() => {
                var currentChatId = $('#send-the-msg').data('id');
                // console.log(currentChatId);
                if (currentChatId !== null && currentChatId !== '' && currentChatId !== 0) {
                    let chatDiv = $('#chats');
                    $.ajax({
                        url: "{{ route('get-message-realtime', ['id' => ':id', 'username' => ':username']) }}"
                            .replace(':id', currentChatId)
                            .replace(':username', $('#send-the-msg').data('username')),
                        type: 'GET',
                        success: function(data) {
                            // console.log(data);
                            chatDiv.append(data);
                            if (data != '' && data != null) {
                                chatDiv.scrollTop(chatDiv.prop('scrollHeight'));
                            }
                        }
                    });
                }
            }, 1000);

            // ---------------------- check For new message every 500 milisecond ---------------------- //

        });

        // -----------------------------------------responsive js ----------------------------------------------//

        //-------window size
        let smallScreenMediaQuery = window.matchMedia('(max-width: 767px)');


        function handleScreenSizeChange() {
            let chatsLists = document.getElementById('added-lists').querySelectorAll('.indivisual-user');
            if (smallScreenMediaQuery.matches) {
                // console.log('less than 767px');
                chatsLists.forEach(element => {
                    element.classList.add('small-screen-added-lists');
                });
                document.getElementById('right-bar').classList.add('small-right-bar');
                document.getElementById('left-bar').classList.add('small-left-bar');
                $('.small-right-bar').css('display', 'none');
            } else {
                // console.log('not less than 767px');
                chatsLists.forEach(element => {
                    element.classList.remove('small-screen-added-lists');
                });
                $('#right-bar').css('display', 'block');
                $('#left-bar').css('display', 'block');
                document.getElementById('right-bar').classList.remove('small-right-bar');
                document.getElementById('left-bar').classList.remove('small-left-bar');
            }
        }

        handleScreenSizeChange();
        smallScreenMediaQuery.addListener(handleScreenSizeChange);
        //-------window size


        $(document).on('click', '.small-screen-added-lists', function() {
            $('#type-message').focus();
            $('.small-left-bar').css('display', 'none');
            $('.small-right-bar').css('display', 'block');
        });
        let emojiDivShown = false;
        $('.emoji-btn').on('click', function() {
            $('#type-message').focus();
            if (!emojiDivShown) {
                emojiDivShown = true;
                $('.emoji-div').css('display', 'block');
            } else {
                emojiDivShown = false;
                $('.emoji-div').css('display', 'none');
            }
        });


        $('.go-back-cont').on('click', function() {
            $('.small-left-bar').css('display', 'block');
            $('.small-right-bar').css('display', 'none');
        });


        // -----------------------------------------responsive js ----------------------------------------------//

        $(document).on('click', '#chats, .send-msg-btn img', emojiDivClose);

        function emojiDivClose() {
            $('#type-message').focus();
            if (emojiDivShown) {
                emojiDivShown = false;
                $('.emoji-div').css('display', 'none');
            }
        }
    </script>

    <script>
        // --------------------------------  Dynamically get the chats ----------------------------------------//

        $(document).on('click', '#added-lists .indivisual-user', function(e) {
            // console.log('ab ayega maaza');
            let username = $(this).data('username');
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('get-message', ['id' => ':id', 'username' => ':username']) }}"
                    .replace(':id', id)
                    .replace(':username', username),
                type: 'GET',
                success: function(data) {
                    var chatsSecD = $('#chats');
                    chatsSecD.css('scroll-behavior', 'auto');
                    $('#chats').html(data);
                    $('#send-the-msg').data('id', id);
                    var chatsSecD = $('#chats');
                    chatsSecD.scrollTop(chatsSecD.prop('scrollHeight'));
                    chatsSecD.css('scroll-behavior', 'smooth');
                    $('.inner-rightbar-cover').css('display', 'none');
                }
            });
        });

        // --------------------------------  Dynamically get the chats ----------------------------------------// 
    </script>


    {{-- -------------------- emoji script  ------------------- --}}
    <script type="module">
        document.addEventListener('emoji-click', (event) => {
            const textarea = document.getElementById('type-message');
            const emoji = event.detail.unicode;
            insertAtCursor(textarea, emoji);
            textarea.focus();
        });



        function insertAtCursor(textarea, value) {
            const cursorPos = textarea.selectionStart;
            textarea.value =
                textarea.value.substring(0, cursorPos) +
                value +
                textarea.value.substring(cursorPos);
            textarea.setSelectionRange(cursorPos + value.length, cursorPos + value.length);
            textarea.dispatchEvent(new Event('input'));
        }
    </script>
    {{-- -------------------- emoji script  ------------------- --}}


    {{-- Perform clicks by link --}}
    <script>
        // var fragment = window.location.hash;
        // if (fragment === '#request') {
        //     $('.tabs-a').trigger('click');
        // } else {
        //     console.log('Fragment is ' + fragment);
        // }
    </script>

</body>

</html>
