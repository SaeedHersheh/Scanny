<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine States</title>
    <style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            color: #090d2c;
            background-color: #090d2c;
            font-family: "Arimo", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            flex-direction: column;
        }

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

        .states-container {
            background-color: #090d2c;
            border: 2px solid #CDF6F9;
            border-radius: 20px;
            padding: 30px 50px;
            min-width: 300px;
            text-align: center;
            color: #CDF6F9;
            animation: fadeIn 1.2s forwards;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin: 10px 0;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 15px;
            border-radius: 12px;
            transition: 0.3s ease;
            border: 1px solid #CDF6F9;
        }

        li.done {
            background-color: #0f1f3c;
        }

        li span.status {
            font-weight: bold;
        }

        .btn-back {
            margin-top: 25px;
            padding: 10px 20px;
            border-radius: 50px;
            background-color: #090d2c;
            color: #CDF6F9;
            border: 1px solid #CDF6F9;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-back:hover {
            background-color: #CDF6F9;
            color: #090d2c;
        }
    </style>
</head>
<body>

<div class="half-circle top-right"></div>
<div class="half-circle bottom-left"></div>

<div class="states-container">
    <h1>Machine States</h1>
    <ul>
        @foreach($states as $state => $status)
            <li class="{{ Str::contains($status, '✅') ? 'done' : '' }}">
                <span>{{ $state }}</span>
                <span class="status">{{ $status }}</span>
            </li>
        @endforeach
    </ul>

    <button class="btn-back" onclick="window.location.href='{{ url()->previous() }}'">Go Back</button>
</div>

</body>
</html>
