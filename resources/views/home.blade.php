@extends('app')

@section('content')  
<div class="page-wrapper">
        <div class="container-flued">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 left-bar inside-container" id="left-bar">
                    <div class="row">
                        <div class="left-bar-header p-2 w-100 position-relative">
                            <div class="add-new-connections" id="add-new-connections">
                                <img src="{{ asset('assets/images/dummy-imgs/add.png') }}">
                            </div>
                            <ul class="position-absolute more-option-left" id="more-option-left">
                                <a href="#">
                                    <li>{{ $authUser->name }}</li>
                                </a>
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
                                                            echo 'Request<span id="count-req-conn">' . (count($requestsLists) > 9 ? '9+' : count($requestsLists)) . '</span>';
                                                        } else {
                                                            echo 'Request<span id="count-req-conn" style="display:none;"></span>';
                                                        }
                                                    @endphp
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row users-list position-relative">
                                        <div class="inner-user-list added-lists" id="added-lists">

                                            <div class="col-12" id="all-connected-users">

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
                                                                        alt="{{$name ?? ''}}" class="users-dp">
                                                                @else
                                                                    <img src="{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}"
                                                                        alt="{{$name ?? ''}}" class="users-dp">
                                                                @endif
                                                            </div>
                                                            <div class="user-details-div col-9"
                                                                id="user-details-{{ $conn->id }}">
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
                                                                                'message' => 'nothing',
                                                                            ];
                                                                        }
                                                                    @endphp
                                                                    <p class="m-0 message-details"
                                                                        id="conv-{{ $conn->id }}">
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
                                                                        @elseif ($lastMessageDetails->message == 'nothing')
                                                                        <span style="color:grey;">No Conversation
                                                                            Yet</span>
                                                                        @else
                                                                            {{ \Illuminate\Support\Str::limit(strip_tags($lastMessageDetails->message), 30) }}
                                                                        @endif
                                                                    </p>
                                                                @else
                                                                    <p class="m-0 message-details"
                                                                        id="conv-{{ $conn->id }}">
                                                                        <span style="color:grey;">No Conversation
                                                                            Yet</span>
                                                                    </p>
                                                                @endif
                                                                @php
                                                                    $unreadCount = app('App\Http\Controllers\controller')->countUnreedMsg($connectedUserId, $authUser->id);
                                                                @endphp
                                                                <span class="unread-msg-count"
                                                                    id="user-unread-{{ $conn->id }}"
                                                                    style="{{ $unreadCount == 0 ? '' : 'display:block;' }}">{{ $unreadCount }}</span>
                                                            </div>
                                                        </div>
                                                        <span class="separtor"></span>
                                                    @endforeach
                                                @else
                                                    <p id="no-connection-p">No Connections</p>
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


                    <div class="row all-chats-show">
                        <div class="col-12 m-auto conversation-container">
                            <div class="conversation-header">

                                <div class="more-msg-options-wrapper">
                                    <div class="inner-options copy-div" data-messageid="0" data-bs-toggle="tooltip" data-bs-placement="top" title="copy text">
                                        <i class="fa-solid fa-copy"></i>
                                    </div>
                                    <div class="inner-options delete-div" data-messageid="0" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                    <div class="inner-options forward-div" data-messageid="0" data-bs-toggle="tooltip" data-bs-placement="top" title="forward">
                                        <i class="fas fa-share"></i>
                                    </div>
                                    <div class="inner-options close-more-opt-div" data-messageid="0" data-bs-toggle="tooltip" data-bs-placement="top" title="close">
                                        <i class="fas fa-close"></i>
                                    </div>
                                </div>



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
                                                <p class="current-status" id="chat-with-status">online</p>
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
                                            class="cursor-pointer" id="send-the-msg" data-id="" data-conv-id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row request-main-div" style="display: none">
                        {{-- <div class="back-to-main-chats-show">back</div> --}}

                        <div class="col-12 request-navbar">
                            <div class="back-to-main-chats-show div-sameline">
                                <i class="fa-solid fa-arrow-left"></i>
                            </div>
                            <p class="div-sameline req-heading">Explore and request for new connection</p>
                        </div>
                        <div class="col-12 request-inner-search-div">
                            <div class="inner-search">
                                <input type="text" class="form-control" id="request-user-type"
                                placeholder="Enter Name. eg: John Doe" autocomplete="off" name="request-the-db">
                                <p class="helping-text">To get exact same person please search by his/her username. eg: johndoe123</p>
                            </div>
                        </div>
                        <div class="col-12 suggetion-search-div" id="suggetion-search-div">
                            <div class="row scrollable" id="search-content-here">
                                {{-- @foreach ($newUsers as $user)
                                <div class='col-6 col-lg-4 col-md-6 searched-user'>
                                    <div class='user-searched-wrpper'>
                                        <div class='searched-user-img'>
                                            <img src="{{$user->profile_pic == '' ? asset('assets/images/dummy-imgs/default-profile-picture.jpg') : asset('user_profile_picture/thumb/'.$user->profile_pic)}}" alt="{{ $user->name}}">
                                        </div>
                                    </div>
                                    <p class='searched-names'>{{ $user->name}}({{ $user->username}})</p>
                                    <p class='searched-desc'>{{$user->email}}</p>
                                    <button class='request-connection-btn' data-id="{{$user->id}}" data-name="{{ $user->name}}({{ $user->username}})">Request</button>
                                </div>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    <div class="modal fade" id="forewardmessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalTitle">Select connection to share</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body forward-user-list-body scrollable">
                <div class="forward-users-wrapper">
                    @if (count($connections) > 0)
                        @foreach ($connections as $conn)
                            @if ($conn->first_user !== auth()->user()->id)
                                @php
                                    $userId = $conn->first_user;
                                    $name = $conn->firstUserDetails->name;
                                    $profilePic = $conn->firstUserDetails->profile_pic;
                                    $connectedUserId = $conn->firstUserDetails->id;
                                    $connectedUsername = $conn->firstUserDetails->username;
                                    $email = $conn->firstUserDetails->email;
                                    @endphp
                            @else
                            @php
                                    $userId = $conn->second_user;
                                    $name = $conn->sedondUserDetails->name;
                                    $profilePic = $conn->sedondUserDetails->profile_pic;
                                    $connectedUserId = $conn->sedondUserDetails->id;
                                    $connectedUsername = $conn->sedondUserDetails->username;
                                    $email = $conn->sedondUserDetails->email;
                                @endphp
                            @endif

                            <div class="row connection-users">
                                <div class="col-1">
                                    <input type="checkbox" name="forward-msg-checkbox" data-id="{{$userId}}">
                                </div>
                                <div class="col-3">
                                    <div class="image-dp">
                                        @if ($profilePic != null || $profilePic != '' || !file_exists('user_profile_picture/thumb/' . $profilePic))
                                            <img src="{{ asset('user_profile_picture/thumb/' . $profilePic) }}"
                                                alt="{{ $name }}" class="forward-users-dp">
                                        @else
                                            <img src="{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}"
                                                alt="{{ $name }}" class="forward-users-dp">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="user-details-div">
                                       <p>{{$name}} ({{$connectedUsername}})</p>
                                       <p class="extra-details">{{$email}}</p>
                                    </div>
                                </div>
                            </div>
                        
                        @endforeach
                    @endif
                </div>
            
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button type="button" class="btn forward-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="send">
                <i class="fa fa-paper-plane"></i>
            </button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
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
            let smallScreen;
            let currentConversationId = '';
            $('.preloader').css('display', 'none');
            // console.log(channel);

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

            //bottom notification

            function bottomNotification(message = ''){
                $('#bottomNotification p').text(message);
                $('#bottomNotification').css('display', 'block');
                setTimeout(() => {
                    $('#bottomNotification').fadeOut();
                }, 2000);
            }

            //reset conv

            function resetConversationId(){
                $('#send-the-msg').data('conv-id', '');
                currentConversationId = '';
            }

            // fire swal 

            function fireSwal(title, message, icon){
                Swal.fire({
                    title: title,
                    text: message,
                    icon: icon,
                    confirmButtonText: 'OK'
                });
            }

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

            //-----type 
            let textarea = $('#type-message');

            let firstTyping = true;
            // Update textarea height on input change
            textarea.on('input', function() {
                if(firstTyping){
                    updateTypingStatus($(this).val());
                    firstTyping = false;
                    setTimeout(() => {
                        firstTyping = true; 
                    }, 500);
                }
                //resize
                resizeTextarea();
            });

            // Initial resize
            resizeTextarea();

            function resizeTextarea() {
                textarea.height('auto');
                textarea.height(Math.min(textarea[0].scrollHeight, parseInt(textarea.css('max-height'))));
            }


            function updateTypingStatus(message) {
                if (message != '') {
                    $.ajax({
                        url: "{{ route('typing-status-change') }}",
                        type: 'POST',
                        data: {
                            id: currentConversationId,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // console.log(data);
                        }
                    });
                }
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

            // ------------------------ ADD NEW USER ------------------//

            $('.add-new-connections').on('click', function() {
                resetConversationId();

                $.ajax({
                    url: "{{ route('new-users') }}",
                    type: 'GET',
                    success: function(data) {
                        if(data.status){
                            $('#search-content-here').html(data.message);
                            $('#request-user-id').val('').trigger('input');
                            if(window.innerWidth > 767){
                                $('.all-chats-show').css('display', 'none');
                                $('.inner-rightbar-cover').css('display', 'none');
                                $('.request-main-div').css('display', 'block');
                            }else{
                                $('#left-bar').css('display', 'none');
                                $('#right-bar').css('display', 'block');
                                $('.all-chats-show').css('display', 'none');
                                $('.inner-rightbar-cover').css('display', 'none');
                                $('.request-main-div').css('display', 'block');
                            }
                        }else{
                            alert('Something went wrong.');
                        }
                    }
                });



                
            });

            $('.back-to-main-chats-show').on('click', function() {
                if(window.innerWidth > 767){
                    $('.request-main-div').css('display', 'none');
                    $('.inner-rightbar-cover').css('display', 'flex'); 
                }else{
                    $('.request-main-div').css('display', 'none');
                    $('#right-bar').css('display', 'none');
                    $('#left-bar').css('display', 'block');
                }
            });

            $('#request-user-type').on('input', function() {
                let username = $(this).val();
                if(username == ""){
                    username = "---";
                }
                $.ajax({
                    url: "{{ route('search-user', ['username' => ':username']) }}"
                        .replace(':username', username),
                    type: 'GET',
                    success: function(data) {
                        $('#search-content-here').html(data.message);
                    }
                });
            });

            $(document).on('click','.request-connection-btn', function() {
                let id = $(this).data('id');
                let btn=$(this);
                if (id != '' && id != 0) {
                    btn.html('...');
                    $.ajax({
                        url: "{{ route('send-request') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.status) {
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
                            btn.html('Request');
                        },
                        error: function(data) {
                            btn.html('Request');
                        }
                    });
                }


            });

            // ------------------------ ADD NEW USER ------------------//

            //------------------ request username slide ------------------//

            $(document).on('click', '.user-name', function() {
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

            $(document).on('click', '.req-action-btn', function() {
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
                                        if (data.accept) {
                                            $('#added-lists .col-12').append(data.data
                                                .htmlStructure);
                                            $('#no-connection-p').hide();
                                            handleScreenSizeChange();
                                        }
                                        if (data.data.countreq == 0) {
                                            $('.no-requests').css('display', 'flex');
                                            $('#count-req-conn').css('display', 'none');
                                        } else if (data.data.countreq > 9) {
                                            $('#count-req-conn').text("9+");
                                        } else {
                                            $('#count-req-conn').text(data.data
                                                .countreq);
                                        }

                                        // console.log(data.data.countreq);
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

            // ---------------------- check For new message every 500 milisecond ---------------------- //


            // -----------------  pusher  -------------------//

            // Pusher.logToConsole = true;
            var pusher = new Pusher('6dacd9cce718ed0e43e0', {
                cluster: 'ap2'
            });

            var channelForConversation = pusher.subscribe('privet');
            var channelForTyping = pusher.subscribe('typing-status');

            // -----------------  pusher  -------------------// 

            //----------- send message ---------//
            $('#send-the-msg').on('click', function() {
                $('.no-conv').css('display', 'none');
                let chatsDiv = $('#chats');
                let message = $('#type-message').val().trim();
                // $('#type-message').val('');
                let id = $(this).data('id');
                let convId = $(this).data('conv-id');
                // console.log(convId);
                if (id != '' && message !== '') {
                    var newDiv = $('<div>', {
                        'class': 'parent-conv sender',
                        'data-msgid' : 0
                    });
                    let messageWithoutHTML = $('<div>').html(message).text();
                    let formattedTime = new Date().toLocaleString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    });
                    $('#conv-' + convId).html(
                        `<img class="status-waitting" src="{{ asset('assets/images/dummy-imgs/clock.png') }}">` +
                        messageWithoutHTML.substring(0, 25));
                    let newDivContent =
                        `<div class="conversations-sender conversations">
                            <div class="clock"><i class="fa-regular fa-clock"></i></div>
                            <span class="message_content"><p>${messageWithoutHTML}</p></span>
                            <span class="place-the-tick-img"></span>
                            </div>
                    <div class="message-time">${formattedTime}</div>`;
                    newDiv.html(newDivContent);
                    chatsDiv.append(newDiv);
                    scrollToBottom();
                    $('#type-message').val('');

                    $.ajax({
                        url: "{{ route('send-messasge') }}",
                        type: 'POST',
                        headers: {
                            'X-Socket-Id': pusher.connection.socket_id
                        },
                        data: {
                            id: id,
                            message: message,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // console.log(data);
                            if (!data.status) {
                                Swal.fire({
                                    title: 'Something went wrong please try again letter or refresh the page.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }else{
                                $('.clock').remove();
                                $('.place-the-tick-img').html('<img src="{{asset("assets/images/dummy-imgs/tick-black.png")}}" class="message-seen-status-img">');
                                $('#conv-' + convId +' img').attr('src', "{{ asset('assets/images/dummy-imgs/tick.png') }}");
                                $('#conv-' + convId +' img').attr('class', "status-unread");
                                newDiv.attr('data-msgid', data.msgid);
                            }
                        }
                    });
                } else {
                    // console.log('spaces');
                }

            });
            //----------- send message ---------//

            // -------------------------------- Long Press Options ------------------------------------------------//
            let timer;
            let theGlobalMsgId = 0;

            // parent conv click listener

            $(document).on('click', '.parent-conv', function(e) {
                if($(this).data('msgid') != theGlobalMsgId){
                    closeMoreMessageOpt();
                }
                var messageTime = $(this).find('.message-time');
                if (messageTime.css('display') == 'none') {
                    messageTime.css('display', 'block');
                } else {
                    messageTime.css('display', 'none');
                }
            });

            // parent conv longpressed listener

            $(document).on('mousedown touchstart', '.parent-conv', function(e) {
                let parentConv = $(this);
                if(parentConv.data('msgid') != 0){
                    timer = setTimeout(function() {
                        openMoreMessageOpt(parentConv);
                    }, 500);
                }
            }).on('mouseup touchend', function() {
                clearTimeout(timer);
            });
            // $('.inner-options').click(function(){
            //     console.log($(this).data('messageid'));
            // });

            // ----------------------- More msg options -------------------//

            $('.copy-div').on('click', function(){
                let theMessageId = $(this).data('messageid');
                console.log(theMessageId);
                if (theMessageId != '0') {
                    let copyText = $('#chats div[data-msgid="' + theMessageId + '"] .conversations .message_content').text().trim();
                    let tempTextArea = $('<textarea>');
                    tempTextArea.val(copyText).css({position: 'fixed', left: '-9999px'}).appendTo($('body'));
                    tempTextArea[0].select();
                    tempTextArea[0].setSelectionRange(0, copyText.length);
                    document.execCommand('copy');
                    tempTextArea.remove();
                    bottomNotification('text copied');
                    closeMoreMessageOpt();
                }
            });

            $('.forward-div').on('click', function(){
                $('input[name="forward-msg-checkbox"]').prop('checked', false);
                $('#forewardmessage').modal('show');
            });

            $('.forward-btn').on('click', function(){
                var checkedIds = [];
                $('input[name="forward-msg-checkbox"]:checked').each(function() {
                    checkedIds.push($(this).data('id'));
                });
                if(checkedIds != ''){
                    $('.forward-btn').html('...');
                    $.ajax({
                        url: "{{route('forward-message')}}",
                        type: 'POST',
                        data: {
                            checkedIds: checkedIds,
                            messageId: theGlobalMsgId,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            $('.forward-btn').html('<i class="fa fa-paper-plane"></i>');
                            bottomNotification('message forwared');
                            $('#forewardmessage').modal('hide');
                            closeMoreMessageOpt();

                            checkedIds.forEach(element => {
                                $('div[data-id="'+element+'"] .message-details').html('<img src="{{asset("assets/images/dummy-imgs/tick.png")}}" alt="tick" class="status-unread">'+response.message);
                            });



                        },
                        error: function(error) {
                            console.log(error);
                            $('.forward-btn').html('<i class="fa fa-paper-plane"></i>');
                        }
                    });
                }
            });

            $('.close-more-opt-div').on('click', function(){
                closeMoreMessageOpt();
            });

            function closeMoreMessageOpt(){
                let element = $('#chats div[data-msgid="' + theGlobalMsgId + '"]').css('background', 'transparent');
                theGlobalMsgId = 0;
                $('.inner-options').data('messageid', '0');
                $('.more-msg-options-wrapper').css('display', 'none');
            }

            function openMoreMessageOpt(element){
                closeMoreMessageOpt();
                element.css('background', '#387bc478');
                let msgId = element.data('msgid');
                theGlobalMsgId = msgId;
                $('.inner-options').data('messageid', msgId);
                $('.more-msg-options-wrapper').css('display', 'flex');
            }

            //stop close modal if click outside
            $('#forewardmessage').on('click', function (e) {
                if ($(e.target).hasClass('modal')) {
                    e.stopPropagation();
                }
            });

            //checkbox for foreward message 
            $('.connection-users').on('click', function() {
                var checkbox = $(this).find('input[name="forward-msg-checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
            });

            // ----------------------- More msg options -------------------//

            // -------------------------------- Long Press Options ------------------------------------------------//

            // --------------------------------  Dynamically get the chats ----------------------------------------//
            let previousbind = '';
            let isFirst = true;
            let isFirstTyping = true;
            let typingBind = '';
            let eventName = '';
            let realChatHtml = '';
            $(document).on('click', '#added-lists .indivisual-user', function(e) {
                closeMoreMessageOpt();
                $('#type-message').val('');
                $('#type-message').focus();
                let countSpan = $(this).find('.unread-msg-count');
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
                        $('#chats').html(data.html);
                        $('#send-the-msg').data('id', id);
                        var chatsSecD = $('#chats');
                        chatsSecD.scrollTop(chatsSecD.prop('scrollHeight'));
                        chatsSecD.css('scroll-behavior', 'smooth');
                        $('.inner-rightbar-cover').css('display', 'none');
                        $('.all-chats-show').css('display', 'block');
                        var connectionId = data.connectionId;
                        currentConversationId = connectionId;
                        changeTypingChannel(connectionId);
                        changeChannel(connectionId);
                        $('#send-the-msg').data('conv-id', connectionId);
                        $('.small-left-bar').css('display', 'none');
                        $('.small-right-bar').css('display', 'block');
                        countSpan.css('display', 'none');
                        countSpan.text('');
                    }
                });
            });

            function changeChannel(id) {
                if (isFirst) {
                    isFirst = false;
                    previousbind = 'chats-' + id;
                } else {
                    channelForConversation.unbind(previousbind);
                    previousbind = 'chats-' + id;
                }

                channelForConversation.bind('chats-' + id, function(data) {
                    if(data.messagedata.sender == {{$authUser->id}}){
                        realChatHtml = `<div class="parent-conv sender" data-msgid="${data.messagedata.id}"><div class="conversations-sender conversations">`;
                    }else{
                        realChatHtml = `<div class="parent-conv reciever" data-msgid="${data.messagedata.id}"><div class="conversations-reciever conversations">`;
                    }

                    if(data.forward == 'true'){
                        realChatHtml += `<p class="forward-msg"><i class="fas fa-share"></i>Forwarded</p>`;  
                    }

                    realChatHtml += `<span class="message_content"><p>`+data.message + `</p></span>
                        <img src="{{asset('assets/images/dummy-imgs/tick-black.png')}}" class="message-seen-status-img">
                        </div>
                        <div class="message-time">` + data.formattedTime + `</div>
                    </div>
                    `;
                    $('#chats').append(realChatHtml);
                    scrollToBottom();
                    // alert(JSON.stringify(data));
                });

                // alert(channelForConversation);
            }
            let timeoutt= '';
            function changeTypingChannel(id){
                if (isFirstTyping) {
                    isFirstTyping = false;
                    typingBind = 'typingstatus-' + id;
                } else {
                    channelForTyping.unbind(typingBind);
                    typingBind = 'typingstatus-' + id;
                }

                channelForTyping.bind('typingstatus-' + id, function(data) {
                    let authID = {{$authUser->id }};
                    if(authID != data.whoIsTyping){
                        $('#chat-with-status').html('typing..');
                        clearTimeout(timeoutt);
                        timeoutt = setTimeout(() => {
                            $('#chat-with-status').html('online');
                        }, 1000);
                    }
                });
            }

            // --------------------------------  Dynamically get the chats ----------------------------------------// 

            // --------------------- Realtime Leftbar Notification ------------------------//

            var channelForLeftBarConv = pusher.subscribe('public');

            channelForLeftBarConv.bind('conv-' + {{ $authUser->id }}, function(data) {
                let message = $('<div>').html(data.message).text().substring(0, 25);
                $('#conv-' + data.convId).html(message);
                $('.no-conv').css('display', 'none');
                if ($('#send-the-msg').data('conv-id') != data.convId) {
                    $('#user-unread-' + data.convId).text(data.unreadMsg);
                    $('#user-unread-' + data.convId).css('display', 'block');
                } else {
                    $.ajax({
                        type: 'GET',
                        url: `{{ url('seen-msg/') }}/${data.msgId}`,
                    });
                }
            });

            // --------------------- Realtime Leftbar Notification ------------------------// 

            // --------------------- Friend Request Notification ------------------------//

            var channelForFriendRequest = pusher.subscribe('friend-request');

            channelForFriendRequest.bind('theuser-' + {{ $authUser->id }}, function(data) {
                if (data.type == 'friendrequest') {
                    let profilePic = data.userDetails.profile_pic;
                    if (profilePic == '') {
                        profilePic = "{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}";
                    } else {
                        profilePic = "{{ asset('user_profile_picture/thumb/') }}" + "/" + profilePic;
                    }

                    let htmlStructure = `<div class="row indivisual-user">
                        <div class="user-image-div col-3">
                            <img src="${profilePic}" alt="${data.userDetails.name}" class="users-dp">
                        </div>
                        <div class="user-details-div col-4 p-0">
                            <p class="m-0 user-name overflow-slide">
                                ${data.userDetails.name}
                                (${data.userDetails.username})
                            </p>
                            <p class="m-0 message-details h-0">
                                Just a moment ago
                            </p>
                        </div>
                        <div class="col-5 p-0 req-action">
                            <button data-id="${data.connectionId}" data-action="accept" data-username="${data.userDetails.username}" class="btn req-action-btn accept-btn"><img src="{{asset("assets/images/dummy-imgs/tick.png")}}" alt="Accept"></button>
                            <button data-id="${data.connectionId}" data-action="reject" data-username="${data.userDetails.username}" class="btn req-action-btn reject-btn"><img src="{{asset("assets/images/dummy-imgs/reject.png")}}" alt="reject"></button>
                        </div>
                    </div>
                    <span class="separtor"></span>`;

                    $('.requests-lists .col-12').append(htmlStructure);

                    if (data.countReq == 0) {
                        $('.no-requests').css('display', 'flex');
                        $('#count-req-conn').css('display', 'none');
                    } else if (data.countReq > 9) {
                        $('.no-requests').css('display', 'none');
                        $('#count-req-conn').css('display', 'inline-block');
                        $('#count-req-conn').html('9+');
                    } else {
                        $('.no-requests').css('display', 'none');
                        $('#count-req-conn').css('display', 'inline-block');
                        $('#count-req-conn').html(data.countReq);
                    }
                }else if(data.type == 'messageSeen'){
                    $('div[data-id="'+data.whoSeen+'"] .message-details img').attr('src', '{{asset("assets/images/dummy-imgs/tick-double.png")}}');
                    $('div[data-id="'+data.whoSeen+'"] .message-details img').attr('class', 'status-read');
                    if(data.connectionId == currentConversationId){
                        let tickSrc = "{{asset('assets/images/dummy-imgs/tick-black.png')}}";
                        let doubletickSrc = "{{asset('assets/images/dummy-imgs/double-tick-seen.png')}}";
                        $('img[src="'+tickSrc+'"]').attr('src', doubletickSrc);
                    }
                }
            });


            // --------------------- Friend Request Notification ------------------------// 

            // --------------------- Friend Request accept Notification ------------------------//
            var channelForAcceptFriendRequest = pusher.subscribe('accept-request');

            channelForAcceptFriendRequest.bind('userid-{{ $authUser->id }}', function(data) {
                fireSwal('Connection Request Accept', data.acceptedUserDetails.name + ' has accepted your connection request.', 'success');
                $('#no-connection-p').css('display', 'none');
                let profilePic = data.acceptedUserDetails.profile_pic;
                if (profilePic == '') {
                    profilePic = "{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}";
                } else {
                    profilePic = "{{ asset('user_profile_picture/thumb/') }}" + "/" + profilePic;
                }

                let prependContent = `<div class="row indivisual-user" data-id="${data.acceptedUserId}" data-username="rishi" data-name="${data.acceptedUserDetails.name}">
                        <div class="user-image-div col-3">
                            <img src="${profilePic}" alt="${data.acceptedUserDetails.name}" class="users-dp">
                        </div>
                        <div class="user-details-div col-9" id="user-details-${data.conversationId}">
                            <p class="m-0 user-name">
                                ${data.acceptedUserDetails.name}
                            </p>
                            <p class="m-0 message-details" id="conv-${data.conversationId}">
                                <span style="color:grey;">No Conversation Yet</span>
                            </p>
                            <span class="unread-msg-count" id="user-unread-${data.conversationId}">0</span>                       
                        </div>
                    </div><span class="separtor"></span>`;
                
                $('#all-connected-users').prepend(prependContent);

            });

            // --------------------- Friend Request accept Notification ------------------------//

            // This is end of Document ready
        });

        // -----------------------------------------responsive js ----------------------------------------------//

        //-------window size
        let smallScreenMediaQuery = window.matchMedia('(max-width: 767px)');


        function handleScreenSizeChange() {
            let chatsLists = document.getElementById('added-lists').querySelectorAll('.indivisual-user');
            if (smallScreenMediaQuery.matches) {
                // console.log('less than 767px');
                smallScreen = true;
                chatsLists.forEach(element => {
                    element.classList.add('small-screen-added-lists');
                });
                document.getElementById('right-bar').classList.add('small-right-bar');
                document.getElementById('left-bar').classList.add('small-left-bar');
                $('.small-right-bar').css('display', 'none');
                $('.request-main-div').css('display', 'none');
            } else {
                // console.log('not less than 767px');
                smallScreen = false;
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


        // $(document).on('click', '.small-screen-added-lists', function() {
        //     $('#type-message').focus();
        //     $('.small-left-bar').css('display', 'none');
        //     $('.small-right-bar').css('display', 'block');
        // });
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

    {{-- -------------------- shortcuts and click event ---------------- --}}
    <script>
        $(document).keydown(function(event) {
            if (event.ctrlKey && event.key === "e") {
                event.preventDefault();
                $('.emoji-btn').click();
            }
            if (event.ctrlKey && event.key === "s") {
                event.preventDefault();
                $('#search-user').click();
            }
        });

        window.addEventListener('beforeunload', function(event) {
            event.preventDefault();
            event.returnValue = '';
            alert('Are you sure you want to leave Realchat?');
        });
    </script>
    {{-- -------------------- shortcuts and click event ---------------- --}}
@endsection
