<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/login-register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css" />
    <!--Stylesheet-->
    <style media="screen">
        form {
            height: 778px;
            transform: translate(-50%, -52%);
            top: 50%;
            left: 50%;
        }

        form h3 {
            font-size: 25px;
        }

        button {
            margin-top: 20px;
        }

        #us_err {
            font-size: 12px;
        }


        label {
            margin-top: 12px;
        }

        form {
            padding: 33px 35px;
        }

        #profile-pic {
            height: 120px;
            width: 120px;
            margin: auto;
            position: relative;
        }

        #profile-pic #profile-picture-img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        input {
            margin-top: 6px;
        }

        .edit-dp {
            position: absolute;
            right: 0px;
            bottom: 0px;
            height: 30px;
            width: 30px;
            background: #e3e3e3;
            border-radius: 50%;
            cursor: pointer;
        }

        #edit-img {
            height: 100%;
            width: 100%;
            padding: 7px;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form name="register_form" id="register-form" method="POST" action="{{ route('register-user') }}"
        enctype="multipart/form-data">
        @csrf
        <h3>Create New Account</h3>

        <div id="profile-pic">
            <img src="{{ asset('assets/images/dummy-imgs/default-profile-picture.jpg') }}" id="profile-picture-img">
            <div class="edit-dp">
                <img src="{{ asset('assets/images/dummy-imgs/pencil.png') }}" id="edit-img">
            </div>
        </div>

        <input type="file" id="profile_picture_input" name="user_image" style="display:none;"
            accept=".jpg,.png,.jpeg">


        <label for="first_name">First Name <span class="err" id="fname_err">(This is required)</span></label>
        <input type="text" placeholder="First Name" id="first_name" name="first_name">

        <label for="last_name">Last Name <span class="err" id="lname_err">(This is required)</span></label>
        <input type="text" placeholder="Last Name" id="last_name" name="last_name">


        <label for="username">Username <span class="err" id="us_err">(username already taken)</span></label>
        <input type="text" placeholder="Choose a Username" id="username" name="username" class="lowercase-text">

        <label for="email">Email <span class="err" id="email_err">(Email already taken)</span></label>
        <input type="email" placeholder="Email" id="email" name="email" class="lowercase-text">

        <label for="password">Password <span class="err" id="pass_err">(Min 5 charecters)</span></label>
        <input type="password" placeholder="Password" id="password" name="password">

        <a href="{{ route('login') }}">Already have an account?</a>
        <button type="button" id="register-button">Register</button>
        {{-- <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div> --}}
    </form>
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
        $('#register-button').on('click', function() {
            if ($('#first_name').val() == "") {
                $('.err').css('display', 'none');
                $('#fname_err').css('display', 'inline-block');
                return false;
            } else if ($('#last_name').val() == "") {
                $('.err').css('display', 'none');
                $('#lname_err').css('display', 'inline-block');
                return false;
            } else if ($('#username').val() == "") {
                $('.err').css('display', 'none');
                $('#us_err').text("(Please provide username)");
                $('#us_err').css('display', 'inline-block');
                return false;
            } else if (!isValidEmail($('#email').val())) {
                $('.err').css('display', 'none');
                $('#email_err').text("(Please provide a valid email)");
                $('#email_err').css('display', 'inline-block');
                return false;
            } else if ($('#password').val() == "" || $('#password').val().length < 5) {
                $('.err').css('display', 'none');
                $('#pass_err').css('display', 'inline-block');
                return false;
            } else if (!disableSubmit()) {
                return false;
            } else {
                $('.err').css('display', 'none');
                $('#register-form').submit();
            }
        });

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        $("#username").on('input', checkUsername);
        $("#email").on('input', checkEmail);

        let emailCheked = false;
        let usernameChecked = false;


        function checkUsername() {
            let username = $("#username").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('check-username') }}",
                type: 'POST',
                data: {
                    username: username,
                    _token: csrfToken,
                },
                success: function(response) {
                    if (!response.status) {
                        usernameChecked = false;
                        $('#us_err').css('display', 'inline-block');
                        $('#us_err').text(response.message);
                        disableSubmit();
                    } else {
                        usernameChecked = true;
                        $('#us_err').css('display', 'none');
                        disableSubmit();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }


        function checkEmail() {
            let email = $("#email").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (username != '') {
                $.ajax({
                    url: "{{ route('check-email') }}",
                    type: 'POST',
                    data: {
                        email: email,
                        _token: csrfToken,
                    },
                    success: function(response) {
                        if (!response.status) {
                            emailCheked = false;
                            $('#email_err').css('display', 'inline-block');
                            $('#email_err').text(response.message);
                            disableSubmit();
                        } else {
                            emailCheked = true;
                            $('#email_err').css('display', 'none');
                            disableSubmit();
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }

        function disableSubmit() {
            if (emailCheked && usernameChecked) {
                $('#register-button').css('pointer-events', 'auto');
                $('#register-button').css('opacity', '1');
                return true;
            } else {
                $('#register-button').css('pointer-events', 'none');
                $('#register-button').css('opacity', '.5');
                return false;
            }
        }

        $(document).ready(function() {
            $('#register-form')[0].reset();
            disableSubmit();

            $('#profile_picture_input').on('change', function() {
                var input = this;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#profile-picture-img').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            });

            $(document).on('click', '#edit-img, #profile-picture-img', function() {
                $('#profile_picture_input').click();
            });
        });
    </script>
</body>

</html>
