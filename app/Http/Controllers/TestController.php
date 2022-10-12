<?php

namespace App\Http\Controllers;

use App\Models\SanPham;

class TestController extends Controller
{
    public function form()
    {
        $sanPham = SanPham::all();
        return view('form', compact('sanPham'));
    }

    public function ajax()
    {
        return view('ajax');
    }

    public function data()
    {
        $sanPham = SanPham::all();
        return response()->json(['sanPham' => $sanPham]);
    }

    public function test(){
        return view('new_admin.pages.danh_muc_san_pham.index');
    }
}
