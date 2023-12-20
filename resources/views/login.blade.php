<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/login-register.css') }}">
    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css" />
    <!--Stylesheet-->
    <style media="screen">
        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form h3 {
            font-size: 32px;
        }

        button {
            margin-bottom: 10px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="{{ route('login-action') }}" method="POST" id="login-form">
        @csrf
        <h3>Login Here</h3>

        <label for="email">Email <span class="err" id="email_err"></span></label>
        <input type="text" placeholder="Email" id="email" name="email">

        <label for="password">Password <span class="err" id="pass_err"></span></label>
        <input type="password" placeholder="Password" id="password" name="password">

        <button type="button" id="login-btn">Log In</button>
        <a href="{{ route('register') }}" class="pt-2">Don't have an account?</a>
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
        @if (session('success'))
            Swal.fire({
                title: 'Congratulations!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        $('#login-btn').on('click', function() {
            if (!isValidEmail($('#email').val())) {
                $('.err').css('display', 'none');
                $('#email_err').text("(Please provide a valid email)");
                $('#email_err').css('display', 'inline-block');
            } else if ($('#password').val() == '' || $('#password').val().length < 5) {
                $('.err').css('display', 'none');
                $('#pass_err').text("(Min 5 charecter)");
                $('#pass_err').css('display', 'inline-block');
            } else {
                // alert('Hurreh!');
                $('#login-form').submit();
                $('.err').css('display', 'none');
            }
        });

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        $(document).on('keydown', function(event) {
            if (event.key === 'Enter') {
                $('#login-btn').click();
            }
        });
    </script>
</body>

</html>
