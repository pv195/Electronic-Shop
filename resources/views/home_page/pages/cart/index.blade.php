@extends('home_page.master')
@section('content')
<div id="app" class="cart-main-area ptb-100 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- Form Start -->
                <form action="#">
                    <!-- Table Content Start -->
                    <div class="table-content table-responsive mb-45">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in listCart" >
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img v-bind:src="value.anh_dai_dien" alt="cart-image" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">@{{ value.ten_san_pham }}</a></td>
                                        <td class="product-price"><span class="amount">@{{ formatNumber(value.don_gia) }}</span></td>
                                        <td class="product-quantity"><input v-on:change="updateRow(value)" v-model="value.so_luong" type="number"/></td>
                                        <td class="product-subtotal">@{{ formatNumber(value.don_gia * value.so_luong) }}</td>
                                        <td class="product-remove"> <a><i v-on:click="deleteRow(value)" class="fa fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Table Content Start -->
                    <div class="row">
                       <!-- Cart Button Start -->
                        <div class="col-md-8 col-sm-12">
                            <div class="buttons-cart">
                                <input type="submit" value="Update Cart" />
                                <a href="#">Continue Shopping</a>
                            </div>
                        </div>
                        <!-- Cart Button Start -->
                        <!-- Cart Totals Start -->
                        <div class="col-md-4 col-sm-12">
                            <div class="cart_totals float-md-right text-md-right">
                                <h2>Cart Totals</h2>
                                <br />
                                <table class="float-md-right">
                                    <tbody>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td>
                                                <strong><span class="amount">@{{ formatNumber(total()) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="wc-proceed-to-checkout" v-on:click="createBill()">
                                    <a>Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                        <!-- Cart Totals End -->
                    </div>
                    <!-- Row End -->
                </form>
                <!-- Form End -->
            </div>
        </div>
         <!-- Row End -->
    </div>
</div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   '#app',
            data    :   {
                listCart    : [],
                tong_tien   : 0,
            },
            created() {
                this.loadCart();
            },
            methods :   {
                loadCart() {
                    axios
                        .get('/cart/data')
                        .then((res) => {
                            this.listCart = res.data.data;
                        });
                },
                formatNumber(number) {
                    return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
                },
                updateRow(row) {
                    axios
                        .post('/add-to-cart-update', row)
                        .then((res) => {
                            if(res.status) {
                                toastr.success("Đã cập nhật giỏ hàng!");
                                this.loadCart();
                            }
                        });
                },
                deleteRow(row) {
                    axios
                        .post('/remove-cart', row)
                        .then((res) => {
                            toastr.success("Đã cập nhật giỏ hàng!");
                            this.loadCart();
                        });
                },

                total() {
                    var tong_tien = 0;
                    this.listCart.forEach((value,key) => {
                        tong_tien += value.don_gia * value.so_luong;
                    });
                    return tong_tien;
                },

                createBill() {
                    axios
                        .get('/create-bill')
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success('Đã chuyển thành công');
                                this.loadCart();
                            } else if (res.data.status == 0 ) {
                                toastr.error('Có lỗi xảy ra');
                            } else {
                                toastr.warning('Giỏ hàng bị rỗng!')
                            }
                        });
                }
            },
        });
    </script>
@endsection
