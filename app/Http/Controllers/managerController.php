<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detail_transaksi;
use App\Models\transaksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class managerController extends Controller
{
    public function getDetailTransaksi()
    {
        // Get the authenticated user
        $Auth = Auth::user();

        // Check if the current user is a manager
        if ($Auth->role == "manager") {

            // Retrieve all transactions with their associated detail transactions and menu items
            $transactions = Transaksi::with('detailTransaksiRelations.menu')->get();

            // Group the detail transactions by their parent transaction
            $groupedTransactions = $transactions->map(function ($transaksi) {
                return [
                    'transaksi' => $transaksi,
                    'detail_transaksi' => $transaksi->detailTransaksiRelations
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $groupedTransactions,
                'message' => 'Transaksi has been retrieved'
            ]);

        } else {
            // If not a manager, return an error
            return response()->json(['status' => false, 'message' => 'Hanya Manager yang bisa melihat detail transaksi'], 403);
        }
    }

    //Profile
    public function profile()
    {
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "manager") {

            $userData = auth()->user();

            return response()->json([
                "status" => true,
                "messege" => "Profile Data",
                "user" => $userData,
                "user_id" => request()->user()->id,
                "email" => request()->user()->email,
            ]);
        }
    }
}