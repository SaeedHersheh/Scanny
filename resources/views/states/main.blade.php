<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
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
            font-weight: 700;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Animations */
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.6); }
            100% { opacity: 1; transform: scale(1); }
        }

        .half-circle {
            position: absolute;
            width: 250px;
            height: 250px;
            transform: scale(0.8);
            opacity: 0;
            animation: fadeIn 1.5s forwards;
        }

        .top-right {
            top: -90px;
            right: -90px;
            background-color: #CDF6F9;
            border-radius: 0 0 0 100%;
        }

        .bottom-left {
            bottom: -90px;
            left: -90px;
            background-color: #CDF6F9;
            border-radius: 0 100% 0 0;
        }

        .logo-area {
            text-align: center;
            opacity: 0;
            transform: scale(0.6);
            animation: fadeIn 1.5s forwards;
            animation-delay: 0.6s;
        }

        .description {
            color: #CDF6F9;
            margin: 25px 0px;
            font-size: 12px;
        }

        .buttons {
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width:180px;
            padding: 10px;
            border-radius: 50px;
            background-color: #090d2c;
            color: #CDF6F9;
            border: 1px solid #CDF6F9;
            cursor: pointer;
            transition: 0.2s ease;
            margin-bottom: 15px;
        }

        .btn:hover {
            background-color: #CDF6F9;
            color: #090d2c;
        }

    </style>
</head>

<body>

<div class="half-circle top-right"></div>

<div class="logo-area">

    <img src="{{ asset('images/p4.png') }}" style="width:130px; height:auto;">

    <div class="description">
        If you already have an account, click Log in.<br><br>
        If you're new here, click Register to create one.
    </div>

    <div class="buttons">
        <button class="btn" onclick="location.href='{{ route('login.form') }}'"><b>Log in</b></button>
        <button class="btn" onclick="location.href='{{ route('register.form') }}'"><b>Register</b></button>
    </div>

</div>

<div class="half-circle bottom-left"></div>

</body>
</html>
