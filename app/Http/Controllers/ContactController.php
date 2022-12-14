<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Auth;

class ContactController extends Controller
{
    use \App\Http\Traits\AdminTrait;
    use \App\Http\Traits\ShopTrait;
    
    public function index()
    {
        try {
            $data = [];
            $transaksi = null;
            if (Auth::check()){
                $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', Auth::user()->id_user]])->first();
            }  
            if (!$transaksi){
                $transaksi['total_transaksi'] = 0;
            }
            $data = [
                'kategori' => $this->kategori,
                'admin' => $this->dataAdmin(),
                'total_transaksi' => $transaksi['total_transaksi'],
            ];
    
            // dd($data);
            
            return view('contact.index', compact('data'));
            
        }catch (ModelNotFoundException $exception) {
            
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}