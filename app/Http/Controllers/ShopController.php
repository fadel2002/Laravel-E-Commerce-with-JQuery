<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Auth;

class ShopController extends Controller
{
    use \App\Http\Traits\AdminTrait;
    use \App\Http\Traits\ShopTrait;
    
    public function index()
    {
        try {
            $data = [];

            $data = $this->getAllBarangWithPaginate();

            // dd($data);
            
            return view('shop.index', compact('data'));
            
        }catch (ModelNotFoundException $exception) {
            
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function detail($id)
    {
        try {
            $data = [];
            
            $barang = Barang::with('gambarBarangs')->where('id_barang', $id)->first();
            $barang_mirip = Barang::where('nama_kategori', $barang->nama_kategori)->limit(4)->get();

            $cart = Transaksi::where([['id_user', Auth::user()->id_user], ['status_transaksi', 0]])->first();
            $cart_history = 0;
            
            if ($cart){
                $detail_barang = DetailTransaksi::where([['id_barang', $id],['id_transaksi', $cart->id_transaksi]])->first();
                if ($detail_barang){
                    $cart_history = $detail_barang->kuantitas_barang;
                }
            }
            
            $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', Auth::user()->id_user]])->first();
            if (!$transaksi){
                $transaksi['total_transaksi'] = 0;
            }
            $data = [
                'kategori' => ['Food', 'Drink', 'Cigar'],
                'admin' => $this->dataAdmin(),
                'produk' => [
                    'id' => $barang->id_barang,
                    'nama' => $barang->nama_barang,
                    'harga' => $barang->harga_barang,
                    'gambar' => $barang->gambar_barang,
                    'deskripsi' => $barang->deskripsi_barang,
                    'berat' => $barang->berat_barang,
                    'stok' => $barang->stok_barang,
                    'kuantitas_sementara' => $cart_history,
                    'gambar_lain' => $barang->gambarBarangs->transform(function ($item, $key) {
                                        return [
                                            'gambar' => $item->gambar_barang,
                                        ];  
                                    }),
                ],
                'produk_mirip' => $barang_mirip->transform(function ($item, $key) {
                    return [
                        'id' => $item->id_barang,
                        'nama' => $item->nama_barang,
                        'harga' => $item->harga_barang,
                        'gambar' => $item->gambar_barang,
                    ];
                }),
                'total_transaksi' => $transaksi['total_transaksi'],
            ];
            
            return view('shop.detail', compact('data'));
            
        }catch (ModelNotFoundException $exception) {
            
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // ajax
    public function getMoreData(Request $request)
    {
        if ($request->ajax()){
            $data = [];
            $data = [
                'produk' => Barang::paginate(6)
            ];
            return view('shop.pagination', compact('data'))->render();
        }    
    }
    
    // ajax
    public function searchOnType(Request $request)
    {
        if ($request->ajax()){
            $data = [];
            $data = [
                'produk' => Barang::where('nama_barang','LIKE','%'.$request->search."%")->paginate(6)
            ];
            return view('shop.pagination', compact('data'))->render();
        }    
    }

    public function search(Request $request)
    {
        if ($request->filled('search')){
            try {
                $data = [];
                $data = [
                    'admin' => $this->dataAdmin(),
                    'kategori' => ['Food', 'Drink', 'Cigar'],
                    'produk' => Barang::where('nama_barang','LIKE','%'.$request->search."%")->paginate(6),
                    'produk_terbaru' => Barang::orderBy('updated_at', 'desc')->limit(6)->get()->transform(function ($item, $key) {
                        return [
                            'id' => $item->id_barang,
                            'nama' => $item->nama_barang,
                            'harga' => $item->harga_barang,
                            'gambar' => $item->gambar_barang,
                        ];
                    }),
                ];
                return view('shop.index', compact('data'));
            }catch (ModelNotFoundException $exception) {
            
                return back()->withError($exception->getMessage())->withInput();
            }
        }    
    }

    // ajax
    public function searchAjax(Request $request)
    {
        if ($request->ajax()){
            try {
                $data = [];
                $data = [
                    'produk' => Barang::where('nama_barang','LIKE','%'.$request->search."%")->paginate(6),
                ];
                return view('shop.pagination', compact('data'))->render();
            }catch (ModelNotFoundException $exception) {
            
                return back()->withError($exception->getMessage())->withInput();
            }
        }    
    }

    public function selectCategories(Request $request)
    {
        if ($request->filled('kategori')){
            try {
                if ($request->kategori == "*"){
                    $barang = Barang::paginate(6);
                    $barang_terbaru = Barang::orderBy('updated_at', 'desc')->limit(6)->get()->transform(function ($item, $key) {
                        return [
                            'id' => $item->id_barang,
                            'nama' => $item->nama_barang,
                            'harga' => $item->harga_barang,
                            'gambar' => $item->gambar_barang,
                        ];
                    });
                }
                else{
                    $barang = Barang::where('nama_kategori','LIKE','%'.$request->kategori."%")->paginate(6);
                    $barang_terbaru = Barang::where('nama_kategori','LIKE','%'.$request->kategori."%")->orderBy('updated_at', 'desc')->limit(6)->get()->transform(function ($item, $key) {
                        return [
                            'id' => $item->id_barang,
                            'nama' => $item->nama_barang,
                            'harga' => $item->harga_barang,
                            'gambar' => $item->gambar_barang,
                        ];
                    });
                }
                $data = [];
                $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', Auth::user()->id_user]])->first();
                if (!$transaksi){
                    $transaksi['total_transaksi'] = 0;
                }
                $data = [
                    'admin' => $this->dataAdmin(),
                    'kategori' => ['Food', 'Drink', 'Cigar'],
                    'produk' => $barang,
                    'produk_terbaru' => $barang_terbaru,
                    'total_transaksi' => $transaksi['total_transaksi'],
                ];
                return view('shop.index', compact('data'));
            }catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        }      
    }

    public function checkout(){
        try {
            $data = [];
            $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', Auth::user()->id_user]])->first();
            if (!$transaksi){
                $transaksi['total_transaksi'] = 0;
            }
            $data = [
                'admin' => $this->dataAdmin(),
                'kategori' => ['Food', 'Drink', 'Cigar'],
                'total_transaksi' => $transaksi['total_transaksi'],
            ];            
            return view('shop.checkout', compact('data'));
        }catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function cart(){
        try {
            $data = [];
            $transaksi = Transaksi::with('detailTransaksis.barang')->where([['status_transaksi', 0],['id_user', Auth::user()->id_user]])->first();
            if (!$transaksi) {
                $transaksi['detailTransaksis'] = [];
                $transaksi['total_transaksi'] = 0;
            }
            // return response()->json([
            //     'data' => $transaksi,
            // ], 200);
            
            $data = [
                'admin' => $this->dataAdmin(),
                'kategori' => ['Food', 'Drink', 'Cigar'],
                'produk' => $transaksi,
                'total_transaksi' => $transaksi['total_transaksi'],
            ];            
            return view('shop.cart', compact('data'));
        }catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    /* POST REQUEST */

    // ajax
    public function addToCartAjax(Request $request){
        if ($request->ajax()){
            try {
                $data = [];

                $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', $request->id_user]])->first();

                if ($transaksi){
                    $detail_transaksi = DetailTransaksi::where([['id_transaksi', $transaksi->id_transaksi],['id_barang', $request->id_barang]])->first();
                    $total_transaksi = $transaksi->total_transaksi;
                    if ($detail_transaksi){
                        $total_transaksi = $total_transaksi - ((int)$detail_transaksi->kuantitas_barang * (int)$request->harga);
                        if ($request->kuantitas == 0){
                            $detail_transaksi->delete();
                        }else {
                            $detail_transaksi->update([
                                'kuantitas_barang' => $request->kuantitas,
                            ]);
                        }                        
                    }else{
                        if ($request->kuantitas > 0){
                            DetailTransaksi::create([
                                'id_transaksi' => $transaksi->id_transaksi,
                                'id_barang' => $request->id_barang,
                                'kuantitas_barang' => (int)$request->kuantitas,
                            ]);
                        }
                    }
                    $transaksi->update([
                        'total_transaksi' => $total_transaksi + ((int)$request->harga * (int)$request->kuantitas),
                    ]);
                }else {
                    $new_transaksi = Transaksi::create([
                        'total_transaksi' => (int)$request->harga * (int)$request->kuantitas,
                        'id_user' => (int)$request->id_user,
                    ]);
                    if ($request->kuantitas > 0){
                        DetailTransaksi::create([
                            'id_transaksi' => (int)$new_transaksi->id_transaksi,
                            'id_barang' => (int)$request->id_barang,
                            'kuantitas_barang' => (int)$request->kuantitas,
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Update Success!',
                ], 200);
            }catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } 
    }

    public function updateCart(Request $request){
        return response()->json([
            'data' => 'Update Success!',
        ], 200);
        
        if ($request->ajax()){
            try {
                $data = [];

                $transaksi = Transaksi::where([['status_transaksi', 0],['id_user', $request->id_user]])->first();

                if ($transaksi){
                    $detail_transaksi = DetailTransaksi::where([['id_transaksi', $transaksi->id_transaksi],['id_barang', $request->id_barang]])->first();
                    $total_transaksi = $transaksi->total_transaksi;
                    if ($detail_transaksi){
                        $total_transaksi = $total_transaksi - ((int)$detail_transaksi->kuantitas_barang * (int)$request->harga);
                        if ($request->kuantitas == 0){
                            $detail_transaksi->delete();
                        }else {
                            $detail_transaksi->update([
                                'kuantitas_barang' => $request->kuantitas,
                            ]);
                        }                        
                    }else{
                        if ($request->kuantitas > 0){
                            DetailTransaksi::create([
                                'id_transaksi' => $transaksi->id_transaksi,
                                'id_barang' => $request->id_barang,
                                'kuantitas_barang' => (int)$request->kuantitas,
                            ]);
                        }
                    }
                    $transaksi->update([
                        'total_transaksi' => $total_transaksi + ((int)$request->harga * (int)$request->kuantitas),
                    ]);
                }else {
                    $new_transaksi = Transaksi::create([
                        'total_transaksi' => (int)$request->harga * (int)$request->kuantitas,
                        'id_user' => (int)$request->id_user,
                    ]);
                    if ($request->kuantitas > 0){
                        DetailTransaksi::create([
                            'id_transaksi' => (int)$new_transaksi->id_transaksi,
                            'id_barang' => (int)$request->id_barang,
                            'kuantitas_barang' => (int)$request->kuantitas,
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Update Success!',
                ], 200);
            }catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } 
    }
}