<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{SpecialOffer, Voucher, User};
use Validator;
use DB;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function __construct()
    {
        
    }
    public function listVouchers() {
        $data = array();
        $data['vouchers'] = Voucher::with(['specialOffer','user'])->latest()->get();
        $data['total_vouchers'] = Voucher::all()->count();
        $data['used_vouchers'] = Voucher::where('usage', '>', '0')->count();
        $data['unused_vouchers'] = Voucher::where('usage', 0)->count();
        return response()->json($data, 200);
    }
    public function generateVoucher(Request $request) {
        $validator= Validator::make($request->all(), [
            'special_offer_id' => 'required|numeric',
            'percentage_discount' => 'required|numeric',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $code = $this->generateCode();
        return response()->json([
            'vouchers' => $code
        ]);
    }
    public function addVoucher(Request $request) {
        $validator= Validator::make($request->all(), [
            'special_offer_id' => 'required|numeric',
            'percentage_discount' => 'required|numeric',
            'vouchers' => 'required',
            'expiry_date' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $voucher = new Voucher();
            $voucher->vouchers = $request->input('vouchers');
            $voucher->special_offer_id = $request->input('special_offer_id');
            $voucher->expiry_date = $request->input('expiry_date');
            $voucher->save();
            $voucher->specialOffer->percentage_discount = $request->input('percentage_discount');
            $voucher->specialOffer->save();
            DB::commit();
        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return response()->json(['errors' => 'Duplicate Voucher Code'], 422);
        }catch(Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()], 422);
        } 
        return response()->json(['msg' => 'Successful'], 200);
    }
    public function assignUser(Request $request) {
        $validator= Validator::make($request->all(), [
            'email' => 'required',
            'voucher_id' => 'required|numeric',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $inputs = $request->all();
        //get Voucher
        $voucher = Voucher::where(['id' => $inputs['voucher_id'],
            'usage' => 0])->first();
        if(!$voucher || isset($voucher->user_id)) {
            return response()->json(['errors' => 
                'voucher code is no longer available or has been used'], 422);
        }
        $user = User::where('email', $inputs['email'])->first();
        $voucher->user_id = $user->id;
        $voucher->save();
        return response()->json(['msg' => 'User Assigned Successfully'], 200);
    }
    public function redeemVoucher(Request $request) {
        $validator= Validator::make($request->all(), [
            'email' => 'required|email',
            'voucher_code' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $inputs = $request->all();
        //get Voucher
        $voucher = Voucher::with('specialOffer')->where(['vouchers' => $inputs['voucher_code'],
            'usage' => 0])->first();
        if(!$voucher || isset($voucher->user_id)) {
            return response()->json(['errors' => 
                'voucher code is no longer available or has been used'], 422);
        }
        $user = User::where('email', $inputs['email'])->first();
        $voucher->user_id = $user->id;
        $voucher->usage = 1;
        $voucher->usage_date = Carbon::now()->toDateTimeString();
        $voucher->save();
        $data['percentage_discount'] = $voucher->specialOffer->percentage_discount; 
        return response()->json($data, 200);
    }
    public function getValidVoucherCodesByEmail() {
        $validator= Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $inputs = $request->all();
        //get Voucher
        $user = User::where('email', $inputs['email'])->first();
        if(!$user) {
            return response()->json(['errors' => 'email Not in the system'], 422);
        }
        $vouchers = Voucher::with('specialOffer')->where(['user_id' => $user->id,
            'usage' => 0])->get();
        if(!$vouchers) {
            return response()->json(['errors' => 
                'No Valid Voucher Code'], 422);
        }
        return response()->json(['vouchers' => $vouchers], 200);
    }
    public function generateCode() {
        $code = strtoupper(bin2hex(random_bytes(9)));
        return $code;
    }
    public function getOffers() {
        $offers = SpecialOffer::latest()->get();
    }
}
