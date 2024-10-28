<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\meja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    //Menu
    public function getMenu(){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not  
        if ($Auth->role == "admin") {

            //Tampil menu
            $dt_menu = menu::get();
            return response()->json([
                'status' => true,
                'Data'   => $dt_menu,
                'mesage' => 'menu has retrieved'
            ]);
        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    public function addMenu(Request $req){
         //Gets current user
         $Auth = Auth::user();

         //Checks if the current user is ADMIN or not 
         if ($Auth->role == "admin") {
        
            //validasi
            $validator = Validator::make($req->all(),[
                'nama'      => 'required',
                'jenis'     => 'required',
                'deskripsi' => 'required',
                'gambar'    => 'required',
                'harga'     => 'required'
            ]);
            if ($validator->fails()) {
                return Response()->json
                ($validator->errors()->toJson());
            }
            $save = menu::create ([
                'nama'      =>$req->get('nama'),
                'jenis'     =>$req->get('jenis'),
                'deskripsi' =>$req->get('deskripsi'),
                'gambar'    =>$req->get('gambar'),
                'harga'     =>$req->get('harga')
            ]);
            if($save){
                return Response()->json(['status'=>true,'message' => 'Sukses menambahkan Menu']);

            } else {
                return Response()->json(['status'=>false, 'message' => 'Gagal menambahkan Menu']);
            }
        
        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    //Perbarui Menu
    public function updateMenu(Request $req, $id){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            $validator = Validator::make($req->all(),[
                'nama'      => 'required',
                'jenis'     => 'required',
                'deskripsi' => 'required',
                'gambar'    => 'required',
                'harga'     => 'required'
            ]);

            if ($validator->fails()) {
            return Response()->json
            ($validator->errors()->toJson());
            }
            $ubah =menu::where('id', $id)->update([
                'nama'      =>$req->get('nama'),
                'jenis'     =>$req->get('jenis'),
                'deskripsi' =>$req->get('deskripsi'),
                'gambar'    =>$req->get('gambar'),
                'harga'     =>$req->get('harga')
            ]);
            if ($ubah) {
                return Response()->json(['status'=>true,'message' => 'Sukses mengupdate Menu']);

            } else {
                return Response()->json(['status'=>false, 'message' => 'Gagal mengupdate Menu']);
            }

        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    //Hapus Produk
    public function deleteMenu($id){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            $hapus = menu::where('id',$id)->delete();

            if($hapus){
                return Response()->json(['status'=>true,'message' => 'Sukses menghapus Menu']);

            } else {
                return Response()->json(['status'=>false, 'message' => 'Gagal menghapus Menu']);
            }
        
        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    //Tampil Menu (ID)
    public function getMenuid($id) {
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            $dt=menu::where('id',$id)->first();
            return Response()->json($dt);

        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
//Meja
    //Tampil Meja 
    public function getMeja(){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            //Tampil meja
            $dt_meja = meja::get();
            return response()->json([
                'status' => true,
                'Data'   => $dt_meja,
                'mesage' => 'meja has retrieved'
            ]);
        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    //Tambah Meja
    public function addMeja(Request $req){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {
       
           //validasi
           $validator = Validator::make($req->all(),[
               'nomor_meja' => 'required'
           ]);
           if ($validator->fails()) {
               return Response()->json
               ($validator->errors()->toJson());
           }
           $save = meja::create ([
               'nomor_meja' =>$req->get('nomor_meja'),
               'status'      => 'available'
           ]);
           if($save){
               return Response()->json(['status'=>true,'message' => 'Sukses menambahkan Meja']);

           } else {
               return Response()->json(['status'=>false, 'message' => 'Gagal menambahkan Meja']);
           }
       
       } else {
           //If not then returns an error
           return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
       }
   }
   //Perbarui Meja
   public function updateMeja(Request $req, $id){
    //Gets current user
    $Auth = Auth::user();

    //Checks if the current user is ADMIN or not 
    if ($Auth->role == "admin") {

        $validator = Validator::make($req->all(),[ 
        ]);

        if ($validator->fails()) {
        return Response()->json
        ($validator->errors()->toJson());
        }
        $ubah =meja::where('id_meja', $id)->update([
            'status'      => 'used'
        ]);
        if ($ubah) {
            return Response()->json(['status'=>true,'message' => 'Sukses mengupdate Meja']);

        } else {
            return Response()->json(['status'=>false, 'message' => 'Gagal mengupdate Meja']);
        }

    } else {
        //If not then returns an error
        return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
    }
    }
    //Hapus Produk
    public function deleteMeja($id){
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            $hapus = meja::where('id_meja',$id)->delete();

            if($hapus){
                return Response()->json(['status'=>true,'message' => 'Sukses menghapus Meja']);

            } else {
                return Response()->json(['status'=>false, 'message' => 'Gagal menghapus Meja']);
            }
        
        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
    //Tampil Meja (ID)
    public function getMejaid($id) {
        //Gets current user
        $Auth = Auth::user();

        //Checks if the current user is ADMIN or not 
        if ($Auth->role == "admin") {

            $dt=meja::where('id_meja',$id)->first();
            return Response()->json($dt);

        } else {
            //If not then returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }
    }
}