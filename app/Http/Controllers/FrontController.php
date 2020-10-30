<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Store;
use http\Client;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $store = Store::where('store_status',1)->get();

        return view('frontend.home.index',compact('store'));
    }
    public function viewstore($store_id){
     if (session('cli_id')){
         $cli = Client::where('cli_id',session('cli_id'))->first();
         if ($cli->cli_package == 0){
             session(['store_id_wait' => $store_id]);
             $packs = Package::where('pack_status',1)->get();
             return view('frontend.home.pack',compact('packs'));
         }else{
             $store = Store::where('store_id',$store_id)->get();
             return view('frontend.home.store', compact('store'));
         }
     }else{
         session(['store_id_wait' => $store_id]);
         $packs = Package::where('pack_status',1)->get();
         return view('frontend.home.pack',compact('packs'));
     }

    }
    public  function subscribe($pack_id){

        if (session('cli_id')){
            return view('payment.pay');
        }else{
            return view('login');
        }


    }
}
