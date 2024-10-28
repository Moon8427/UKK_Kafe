<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detail_transaksi;
use App\Models\transaksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class managerController extends Controller
{
    public function getDetailTransaksi(){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "manager") {

            //check data transaksi data based on primary key
            $dt_transaksi = detail_transaksi::where('detailTransaksiRelations');
            return response()->json([
            'status' => true,
            'Data'   => $dt_transaksi,
            'mesage' => 'transaksi has retrieved'
        ]);

        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Manager yang bisa menambah'], status: 500);
        }
    }

    //Profile
    public function profile(){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "manager") {

        $userData=auth()->user();

        return response()->json([
            "status"=>true,
            "messege"=>"Profile Data",
            "user"=>$userData,
            "user_id"=>request()->user()->id,
            "email"=>request()->user()->email,
        ]);
        }
    }
}