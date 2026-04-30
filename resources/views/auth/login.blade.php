<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Scanny</title>
<style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            color: #090d2c;
            background-color: #090d2c;
        }

        body {
            font-family: "Arimo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 700;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            padding: 30px 20px;
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 0 20px #CDF6F9;
            position: absolute;
            text-align: center;
            opacity: 0;
            animation: appearLogin 1s ease-out forwards;
        }

        .Welcome {
            text-align: center;
            margin-bottom: 30px;

        }

        .form_logo {
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 15px;
            border: 1px solid #0E1339;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .input-field:focus {
            border: 3px solid #0E1339;

        }

        .sign-in-button {
            padding: 10px 20px;
            background-color: #0E1339;
            color: #CDF6F9;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 20px;
        }


        @media (max-width: 600px) {
            .login-container {
                width: 300px;
            }
        }

        @keyframes appearLogin {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="login-container" id="loginPage">

    <div class="form_logo">
        <img src="{{ asset('images/p1.png') }}" style="width:100px; height:auto;">
        <h2>Welcome back!</h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <input type="email" name="email" class="input-field" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" class="input-field" placeholder="Password" required>
        </div>

        <button type="submit" class="sign-in-button"><b>Log in</b></button>
    </form>

    <div style="margin-top:10px; text-align:center;">
<a href="{{ route('register.form') }}" style="text-decoration:none;">Create an account</a>
    </div>

</div>

</body>
</html>
