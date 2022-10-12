<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $agent = Auth::guard('agent')->user();
        if($agent) {
            //1. Lấy toàn bộ giỏ hàng của tài khoản này.
            $gioHang = ChiTietDonHang::where('is_cart',  1)
                                     ->where('agent_id', $agent->id)
                                     ->get();

            if(empty($gioHang) || count($gioHang) > 0) {
                //2. tạo đơn hàng
                $donHang = DonHang::create([
                    'ma_don_hang'       => Str::uuid(),
                    'tong_tien'         =>  0,
                    'tien_giam_gia'     =>  0,
                    'thuc_tra'          =>  0,
                    'agent_id'          =>  $agent->id,
                    'loai_thanh_toan'   => 1,
                ]);
                $thuc_tra = 0; $tong_tien = 0;
                //3. Chuyển giỏ thành đơn hàng
                foreach($gioHang as $key => $value) {
                    $sanPham = SanPham::find($value->san_pham_id);
                    if($sanPham) {
                        $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                        $thuc_tra += $value->so_luong * $giaBan;
                        $tong_tien += $value->so_luong * $sanPham->gia_ban;

                        $value->don_gia = $giaBan;
                        $value->is_cart = 0;
                        $value->don_hang_id = $donHang->id;
                        $value->save();
                    } else {
                        $value->delete();
                    }
                }
                //4. Đã có thực trả và tổng tiền
                $donHang->thuc_tra = $thuc_tra;
                $donHang->tong_tien = $tong_tien;
                $donHang->tien_giam_gia = $tong_tien - $thuc_tra;
                $donHang->save();

                return response()->json([
                    'status' => true
                ]);
            } else {
                return response()->json([
                    'status' => 2
                ]);
            }
        }
        return response()->json([
            'status' => false
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function show(DonHang $donHang)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function edit(DonHang $donHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DonHang $donHang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonHang $donHang)
    {
        //
    }
}
