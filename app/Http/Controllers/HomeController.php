<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpecialOffer;
use App\User;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
    
    public function checkVoucher(Request $request) {
        $email = $request->input('email');
        $voucher_code = $request->input('voucher_code');
        //do a check to ensure code exists
        return response()->json(['data' => '']);
    }
    public function retrieveSpecialOffers(Request $request) {
        $search = $request->input('term');
        //get the offers
        $offers = SpecialOffer::where('name', 'like', "%$search")->get();
        return response()->json(['results' => $offers]);
    }
    public function retrieveUsers(Request $request) {
        $search = $request->input('search');
        if($search) {
            $users = User::where('email', 'like', "%$search%")->orderBy('email')->paginate(10);
        }else{
            $users = User::orderBy('email')->paginate(10);
        }
        return response()->json(['users' => $users]);
    }
}
