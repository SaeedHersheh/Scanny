<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Balance</title>

    <style>
        html,body {
            margin: 0;
            padding: 0;
            background-color: #090d2c;
            font-family: "Arimo", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .container {
            background: white;
            padding: 40px 20px;
            border-radius: 15px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 10px #CDF6F9;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .title {
            margin-bottom: 10px;
            color: #090d2c;
            font-size: 20px;
            font-weight: bold;
        }

        .currentBalance {
            color: #090d2c;
            font-size: 28px;
            margin-bottom: 25px;
        }

        select {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #090d2c;
            background-color: white;
            cursor: pointer;
            margin-bottom: 15px;
        }

        button {
            padding: 15px;
            margin-top: 10px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            background: #090d2c;
            color: white;
            opacity: 0.4;
            transition: .3s;
        }

        button.enabled {
            opacity: 1;
            cursor: pointer;
        }

        #successMsg {
            margin-top: 12px;
            color: green;
            font-size: 14px;
        }
    </style>

</head>

<body>

<div class="container">

    <img src="{{ asset('images/p1.png') }}" class="logo">

    <div class="title">Your Balance</div>

    <div class="currentBalance" id="balanceDisplay">
₪{{ number_format(Auth::user()->balance ?? 0, 2) }}
    </div>

    <div class="title">Add Balance</div>

    <select id="balanceSelect">
        <option value="" disabled selected>Select amount</option>
        <option value="5">5 ₪</option>
        <option value="10">10 ₪</option>
        <option value="20">20 ₪</option>
        <option value="50">50 ₪</option>
        <option value="100">100 ₪</option>
    </select>

    <button id="go" disabled><b>Add</b></button>
    <!-- GO BACK HOME BUTTON -->
    <!-- GO BACK HOME BUTTON -->
<div style="margin-top: 18px; text-align: center;">
    <a 
        href="{{ route('home') }}" 
        style="
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            color: #0E1339;
        "
    >
        Back to Home
    </a>
</div>


    <div id="successMsg"></div>

</div>


<script>
    const select = document.getElementById("balanceSelect");
    const goBtn = document.getElementById("go");
    const successMsg = document.getElementById("successMsg");
    const balanceDisplay = document.getElementById("balanceDisplay");

    // Enable button when selection changes
    select.addEventListener("change", () => {
        goBtn.disabled = false;
        goBtn.classList.add("enabled");
    });

    // Handle Add Balance
    goBtn.addEventListener("click", () => {
        let amount = select.value;

        fetch("{{ route('balance.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ amount: amount })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                balanceDisplay.innerText = "₪" + parseFloat(data.new_balance).toFixed(2);
                successMsg.innerText = "Balance added: ₪" + amount;
            } else {
                successMsg.innerText = data.error;
            }
        });
    });
</script>

</body>
</html>
