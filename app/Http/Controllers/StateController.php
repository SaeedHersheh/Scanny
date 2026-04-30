<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
  
    public function statesView(Request $request)
    {
        $states = [
            'QR Scan'        => $request->session()->get('qr_scanned', true) ? 'Scanned ✅' : 'Not Scanned ❌',
            'Login'          => $request->session()->get('login_success', false) ? 'Logged in ✅' : 'Not Logged in ❌',
            'Cart'           => $request->session()->get('cart_chosen', false) ? 'Item chosen 🛒' : 'No items chosen ❌',
            'Balance Check'  => $request->session()->get('balance_ok', false) ? 'Sufficient ✅' : 'Insufficient ❌',
            'Purchase'       => $request->session()->get('purchase_done', false) ? 'Completed ✅' : 'Not Done ❌',
            'Dispense'       => $request->session()->get('dispensed', false) ? 'Item dispensed ✅' : 'Waiting ❌',
        ];

        return view('states.states', compact('states'));
    }
}
