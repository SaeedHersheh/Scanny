<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use App\Models\VendingMachine;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class VendingMachineController extends Controller
{
public function qr($id)
{
    // If user is logged in → QR should send them to HOME
    if (Auth::check()) {
        $url = route('home');
    } 
    // If not logged in → QR should send them to MAIN
    else {
        $url = route('main.page');
    }

    // Generate QR code with the correct URL
    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(260)
                ->generate($url);


                session()->put('qr_scanned', true);

                
    // Always show the QR page
    return view('machine.qr_page', [
        'qrCode' => $qrCode,
        'id' => $id
    ]);
}








 

    // Show vending machine page (requires login)
    public function show($id)
{
    $machine = VendingMachine::findOrFail($id);
    $items = Item::where('vending_machine_id', $id)->get();

    return view('machine.machine', compact('machine', 'items'));
}


    public function addToCart(Request $request)
    {
        $itemId = $request->item_id;
        if (!$itemId) {
            return response()->json(['error' => 'No item ID provided']);
        }

        $item = Item::find($itemId);
        if (!$item) {
            return response()->json(['error' => 'Item not found']);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity']++;
        } else {
            $cart[$itemId] = [
                "name" => $item->name,
                "price" => $item->price,
                "quantity" => 1
            ];
        }

        
    session()->put('cart', $cart);

   
    session()->put('cart_chosen', count($cart) > 0);

    return response()->json([
        'message' => 'Item added',
        'cart' => $cart,
        'cartState' => 'Item chosen ✅'
    ]);
    }

    public function buy(Request $request)
    {
        $cart = session()->get('cart', []);
        if (!$cart || count($cart) == 0) {
            session()->forget('cart');
            return response()->json(['error' => 'Cart is empty']);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not logged in']);
        }
   


       
    $userFresh = \App\Models\User::find($user->id);
    $balance = (float)$userFresh->balance;
    $total = (float)$total;

if($balance < $total){
    
    session()->put('balance_ok', false);
    session()->put('purchase_done', false);
    session()->put('dispensed', false);
    return response()->json(['error'=>'Insufficient balance']);
}


$userFresh->balance = $balance - $total;
$userFresh->save();
session()->put('balance_ok', true);      
session()->put('purchase_done', true);   
session()->put('dispensed', true);       
session()->put('cart_chosen', false);    

    foreach($cart as $itemId => $cartItem){
        $dbItem = Item::find($itemId);

        if($dbItem){
            if($dbItem->count <$cartItem['quantity']){
                session()->forget('cart');
                return response()->json([
                    'error' => "not enough stock for {dbItem->name}"
                ]);
            }

            $dbItem->count -= $cartItem['quantity'];
            
            $dbItem->save();
        }
    }

       session()->put('purchase_done', true);  
    session()->put('dispensed', true);     
    session()->forget('cart');              
    session()->put('cart_chosen', false);   

    //        Auth::logout();
    // session()->invalidate();
    // session()->regenerateToken();


        return response()->json([
            'success' => 'Purchase completed',
            'spent' => $total,
            'new_balance' => $userFresh->balance
        ]);

      
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount'=> 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        if(!$user){
            return response()->json(['error', 'User not logged in'],401);
        }

        $amount = (float)$request->amount;

        $userFresh = \App\Models\User::find($user->id);

        $userFresh->balance = (float)$userFresh->balance+$amount;
        $userFresh->save();

        return response()->json([
        'success' => 'Balance added successfully',
        'new_balance' => $userFresh->balance
    ]);
    }

}
