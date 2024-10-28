<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\menu;
use App\Models\meja;
use App\Models\Transaksi;
use App\Models\detail_transaksi;

class kasirController extends Controller
{
    //         // Method untuk menyimpan transaksi
    //         public function store(Request $request)
    //     {
    //     // Get the authenticated user
    //     $Auth = Auth::user();

    //     // Check if user is authenticated
    //     if (!$Auth || $Auth->role !== "kasir") {
    //         return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], 403);
    //     }

    //     // Ensure the necessary fields are present in the request
    //     $request->validate([
    //         'id_meja' => 'required|integer',
    //         'nama_pelanggan' => 'required|string',
    //         'menus' => 'required|array',
    //     ]);    

    //     $totalPrice = 0; // Menyimpan total harga transaksi

    //     // Create a new transaction
    //     $transaksi = Transaksi::create([
    //         'tanggal_transaksi' => now(),
    //         'id_user' => $Auth->id_user,  // Ensure this is set correctly
    //         'id_meja' => $request->id_meja,  // Get id_meja from the request
    //         'nama_pelanggan' => $request->nama_pelanggan,
    //         'status' => 'blm_bayar',
    //         'total_price' => $totalPrice,
    //     ]);

    //     // Process the orders for each menu item
    //     foreach ($request->menus as $menuId => $menuData) {
    //         if ($menuData['quantity'] > 0) {
    //             $menu = Menu::find($menuId);
    //             if ($menu) {  // Ensure the menu exists
    //                 $subtotal = $menu->price * $menuData['quantity'];
    //                 $totalPrice += $subtotal;

    //                 // Save ordered menu to the pivot table
    //                 $transaksi->menus()->attach($menuId, [
    //                     'quantity' => $menuData['quantity'],
    //                     'subtotal' => $subtotal,
    //                 ]);
    //             }
    //         }
    //     }

    //     // Update the total price in the transaction
    //     $transaksi->update(['total_price' => $totalPrice]);

    //     // Redirect to the transaction detail page or wherever necessary
    //     return redirect()->route('transaksi.show', $transaksi);
    // };

    public function store(Request $request)
    {
        // Get the authenticated user
        $Auth = Auth::user();

        // Check if user is authenticated
        if (!$Auth || $Auth->role !== "kasir") {
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], 403);
        }

        // Validate the request
        $request->validate([
            'id_meja' => 'required|integer',
            'nama_pelanggan' => 'required|string',
            'menu_items' => 'required|array',
            'menu_items.*.id_menu' => 'required|integer',  // Validate each menu item
        ]);

        // Create a new transaction
        $transaksi = Transaksi::create([
            'tgl_transaksi' => now(),
            'id_user' => $Auth->id_user,  // Ensure this is set correctly
            'id_meja' => $request->id_meja,  // Get id_meja from the request
            'nama_pelanggan' => $request->nama_pelanggan,
            'status' => 'blm_bayar',
        ]);

        // Process the orders for each menu item
        foreach ($request->menu_items as $menuItem) {
            $menu = Menu::where('id_menu', $menuItem['id_menu'])->first();

            if ($menu) {
                // Create a new detail_transaksi for each menu item
                detail_transaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_menu' => $menu->id_menu,
                    'harga' => $menu->harga,
                ]);
            }
        }

        // Retrieve the transaction with its details
        $transaksiWithDetails = Transaksi::with('detailTransaksiRelations.menu')->find($transaksi->id_transaksi);
        // Return a response indicating success
        return response()->json(['status' => true, 'message' => 'Transaksi berhasil ditambahkan', 'transaksi' => $transaksiWithDetails], 200);
    }
}
