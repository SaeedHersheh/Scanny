<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Vending Machine {{ $machine->id }}</title>

<style>
/* your full CSS unchanged */
* { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
body {
    background: linear-gradient(to bottom, #CDF6F9 , #1A83A8 , #0E1339);
    height: 100vh;
    overflow-y: hidden;
    overflow-x: hidden;
    font-family: "Arimo", sans-serif;
    color: #090d2c;
}
.fixed-header {
    position: fixed; top: 20px; left: 0; width: 100%;
    color:#090d2c; text-align:center; padding:10px 0;
    font-size:18px; font-weight:600; z-index:10;
}
.header { text-align:center; padding-top:50px; height:40vh;
    display:flex; flex-direction:column;
    justify-content:center; align-items:center;
}
.instruction-text { font-size:14px; margin:0 20px 20px 20px; }
.buy-button {
    background:#090d2c; color:white; border:none;
    padding:12px 40px; font-size:18px; font-weight:700;
    border-radius:25px; cursor:not-allowed; opacity:0.5;
}
.buy-button:enabled { cursor:pointer; opacity:1; }
.green-arc {
    background:#090d2c; height:60vh;
    border-top-left-radius:50% 120px;
    border-top-right-radius:50% 120px;
    display:flex; flex-direction:column;
    align-items:center; padding-top:100px; overflow:hidden;
}
.products-container {
    display:flex; justify-content:center; align-items:flex-start;
    position:relative; width:100%; height:300px;
}
.product { position:absolute; text-align:center;
    transition:transform .5s ease, z-index .5s ease, opacity .5s ease;
}
.product img { width:160px; filter:drop-shadow(0 5px 5px #090d2c); }
.bottom-card { color:white; margin-top:10px; }
.bottom-card h3 { font-size:10px; margin-bottom:5px; }
.bottom-card .price { font-size:10px; font-weight:600; }

.quantity-control {
    display:flex; justify-content:center;
    align-items:center; margin-top:5px; gap:5px;
}
.quantity-control button {
    background:white; border:none; padding:3px 7px;
    font-size:12px; cursor:pointer; border-radius:6px;
}
.quantity-control span { color:white; min-width:20px; text-align:center; }
.out-of-stock { color:#f7b6b6; font-size:12px; margin-top:5px; display:none; }
</style>
</head>

<body>

<div class="fixed-header" style="display:flex; justify-content:space-between; align-items:center; padding:0 15px;">

    <!-- LEFT: LOGOUT -->
    <a 
        href="{{ route('logout.main') }}"
        style="
            background:white;
            color:#090d2c;
            padding:6px 14px;
            border-radius:15px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
            box-shadow:0 2px 4px rgba(0,0,0,0.2);
            transition:0.2s ease-in-out;
        "
        onmouseover="this.style.background='#CDF6F9';"
        onmouseout="this.style.background='white';"
    >
        Logout
    </a>

    <!-- CENTER TITLE -->
    <div style="flex:1; text-align:center; font-weight:700; font-size:18px; color:#090d2c;">
        Vending Machine
    </div>

    <!-- RIGHT SPACER -->
    <div></div>

    <a  
                onclick="window.location.href='{{ route('state.balance') }}'" 
                style="
            background:white;
            color:#090d2c;
            padding:6px 14px;
            border-radius:15px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
            box-shadow:0 2px 4px rgba(0,0,0,0.2);
            transition:0.2s ease-in-out;
        "
                onmouseover="this.style.background='#CDF6F9';"
                onmouseout="this.style.background='white';"
            >
                Add Balance
        </a >
</div>


<div class="header">

<div style="
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    margin-bottom:15px;
    margin-top:5px;
">

    <!-- USER BALANCE -->
    <div style="
        font-size:18px;
        font-weight:700;
        color:#ffffff;
    ">
        Balance: ₪{{ number_format(Auth::user()->balance, 2) }}
    </div>

    <!-- TOTAL PRICE -->
    <div id="totalBox"
        style="
            font-size:18px;
            font-weight:700;
            color:#ffffff;
        ">
        Total: ₪0.00
    </div>
    
        
        

    </div>

    <!-- INSTRUCTION -->
    <p class="instruction-text" style="color:white; margin-top:0;">
        After you have finished selecting your products, press Buy Now.
    </p>

    <!-- BUTTON BAR (BUY + CANCEL INLINE) -->
    <div style="display:flex; justify-content:center; gap:15px; margin-top:15px;">

        <!-- BUY NOW BUTTON -->
        <button 
            id="buyButton"
            class="buy-button"
            disabled
            style="
                padding:12px 32px;
                font-size:16px;
                border-radius:25px;
                background:#090d2c;
                color:white;
                border:none;
                opacity:0.5;
                cursor:not-allowed;
                transition:0.2s ease-in-out;
            "
        >
            Buy Now
        </button>

        <!-- CANCEL ORDER BUTTON -->
        <button 
            id="cancelButton"
            disabled
            style="
                padding:12px 32px;
                font-size:16px;
                border-radius:25px;
                background:white;
                color:#090d2c;
                border:none;
                opacity:0.5;
                cursor:not-allowed;
                box-shadow:0 3px 6px rgba(0,0,0,0.2);
                transition:0.2s ease-in-out;
            "
            onmouseover="this.style.background='#CDF6F9';"
            onmouseout="this.style.background='white';"
        >
            Cancel
        </button>

    </div>

</div>


<div class="green-arc">
    <div class="products-container">

        @foreach($items as $index => $item)
        <div class="product"
             data-index="{{ $index }}"
             data-stock="{{ $item->count }}"
             data-id="{{ $item->id }}"
             data-price="{{ $item->price }}"
        >

            <img src="{{ asset('images/products/' . $item->photo_path) }}" />

            <div class="bottom-card">
                <h3>{{ $item->name }}</h3>
                <div class="price">{{ number_format($item->price,2) }}₪</div>

                <div class="quantity-control">
                    <button class="decrease">-</button>
                    <span class="qty">0</span>
                    <button class="increase">+</button>
                </div>

                <div class="out-of-stock">Out of Stock</div>
            </div>

        </div>
        @endforeach

    </div>
</div>
<script>
let products = document.querySelectorAll('.product');
let currentIndex = Math.floor(products.length / 2);

// Build product quantity array from DB items
let productQuantities = Array.from(products).map(p => ({
    qty: 0,
    stock: parseInt(p.dataset.stock)
}));

const buyButton = document.getElementById('buyButton');
const cancelButton = document.getElementById('cancelButton');

// ⭐ Update Total Price
function updateTotalPrice() {
    let total = 0;

    products.forEach((p, i) => {
        const qty = productQuantities[i].qty;
        const price = parseFloat(p.dataset.price);
        total += qty * price;
    });

    document.getElementById("totalBox").innerText = "Total: ₪" + total.toFixed(2);
}

// ⭐ Enable / Disable Buy & Cancel based on qty
function updateBuyButton() {
    const hasItems = productQuantities.some(p => p.qty > 0);

    buyButton.disabled = !hasItems;
    cancelButton.disabled = !hasItems;

    buyButton.style.opacity = hasItems ? "1" : "0.5";
    buyButton.style.cursor  = hasItems ? "pointer" : "not-allowed";

    cancelButton.style.opacity = hasItems ? "1" : "0.5";
    cancelButton.style.cursor  = hasItems ? "pointer" : "not-allowed";

    updateTotalPrice();
}

// Update QTY UI
function updateQuantityControls(i) {
    let p = products[i];
    let q = productQuantities[i];

    p.querySelector('.qty').textContent = q.qty;
    p.querySelector('.increase').disabled = q.qty >= q.stock;
    p.querySelector('.decrease').disabled = q.qty <= 0;

    updateBuyButton();
}

// Carousel visuals
function updateCarousel() {
    products.forEach((p, i) => {
        const offset = i - currentIndex;
        const stock = productQuantities[i].stock;

        if (stock === 0) {
            p.style.opacity = 0.3;
            p.querySelector('.quantity-control').style.display = 'none';
            p.querySelector('.out-of-stock').style.display = 'block';
        } else {
            p.style.opacity = 1;
            p.querySelector('.out-of-stock').style.display = 'none';
        }

        if (offset === 0) {
            p.style.transform = "translateY(-10px) scale(1.6)";
            p.style.zIndex = 3;
            p.querySelector('.quantity-control').style.display = 'flex';
            updateQuantityControls(i);
        } else if (offset === 1 || offset === -1) {
            p.style.transform = `translateX(${offset * 180}px) translateY(60px) scale(1.2)`;
            p.style.zIndex = 2;
            p.querySelector('.quantity-control').style.display = 'none';
        } else {
            p.style.transform = `translateX(${offset * 220}px) translateY(80px) scale(.9)`;
            p.style.zIndex = 1;
            p.querySelector('.quantity-control').style.display = 'none';
        }
    });

    updateTotalPrice();
}

updateCarousel();

// Swipe
let startX = 0;
document.querySelector('.products-container').addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
});
document.querySelector('.products-container').addEventListener('touchend', e => {
    let endX = e.changedTouches[0].clientX;
    if (endX - startX > 30) currentIndex = Math.max(0, currentIndex - 1);
    if (startX - endX > 30) currentIndex = Math.min(products.length - 1, currentIndex + 1);
    updateCarousel();
});

// Increase / Decrease qty
products.forEach((p, i) => {
    p.querySelector('.increase').addEventListener('click', () => {
        let item = productQuantities[i];
        if (item.qty < item.stock) item.qty++;
        updateQuantityControls(i);
        updateTotalPrice();
    });

    p.querySelector('.decrease').addEventListener('click', () => {
        let item = productQuantities[i];
        if (item.qty > 0) item.qty--;
        updateQuantityControls(i);
        updateTotalPrice();
    });
});

// ⭐ CANCEL — Reset all items & disable buttons
cancelButton.addEventListener('click', () => {
    productQuantities.forEach(p => p.qty = 0);

    products.forEach((p, i) => {
        p.querySelector('.qty').textContent = 0;
        p.querySelector('.increase').disabled = false;
        p.querySelector('.decrease').disabled = true;
    });

    buyButton.disabled = true;
    buyButton.style.opacity = "0.5";
    buyButton.style.cursor = "not-allowed";

    cancelButton.disabled = true;
    cancelButton.style.opacity = "0.5";
    cancelButton.style.cursor = "not-allowed";

    updateTotalPrice();
});

// BUY NOW
buyButton.addEventListener('click', async () => {
    for (let i = 0; i < products.length; i++) {
        let qty = productQuantities[i].qty;
        if (qty > 0) {
            let id = products[i].dataset.id;

            for (let x = 0; x < qty; x++) {
                await fetch("{{ route('machine.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ item_id: id })
                });
            }
        }
    }

    const res = await fetch("{{ route('machine.buy') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    });

    const data = await res.json();

    if (data.success) {
        alert("Purchase successful!");
        window.location.reload();
    } else {
        alert(data.error);
    }
});
</script>


</body>
</html>
