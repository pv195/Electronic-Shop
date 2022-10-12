@extends('new_admin.master')
@section('title')
    <h3>Quản Lý Nhập Kho</h3>
@endsection
@section('content')
<div id="app" class="row">
    <div class="col-md-4">
        <div class="card" style="height: auto">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-colored-form-control">Nhập Kho Sản Phẩm</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <fieldset class="form-group position-relative">
                        <input v-on:keyup="search()" v-model="inputSearch" type="text" class="form-control form-control mb-1" placeholder="Nhập vào tên sản phẩm">
                        <div class="form-control-position">
                            <i v-on:click="search()" class="feather icon-search info font-medium-4"></i>
                        </div>
                    </fieldset>
                    <table class="table table-bordered mb-0 mt-1">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in danhSachSanPham">
                                <th class="text-center">@{{ key + 1 }}</th>
                                <td>@{{ value.ten_san_pham }}</td>
                                <td class="text-center">
                                    <button v-on:click="addKhoHang(value.id)" class="btn btn-info btn-sm">Add</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="height: auto">
                <h4 class="card-title">Nhập Kho Sản Phẩm</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Đơn Giá</th>
                                <th class="text-center">Thành Tiền</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in danhSachKhoDangNhap">
                                <th class="text-center align-middle">@{{ key + 1 }}</th>
                                <td class="align-middle text-nowrap">@{{ value.ten_san_pham }}</td>
                                <td class="align-middle" style="width: 50px">
                                    <input v-on:change="update(value)" v-model="value.so_luong" type="number" min="1" class="form-control text-center" v-bind:value="value.so_luong">
                                </td>
                                <td class="align-middle">
                                    <input v-on:keyup="update(value)" v-model="value.don_gia" type="number"  class="form-control text-center" v-bind:value="value.don_gia">
                                </td>
                                <td class="align-middle">
                                    @{{ value.don_gia * value.so_luong }}
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-danger" v-on:click="destroy(value.id)">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button v-on:click="createStore()" class="m-1 btn btn-primary">Nhập Kho</button>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    new Vue({
        el  :   '#app',
        data:   {
            danhSachSanPham     :   [],
            danhSachKhoDangNhap :   [],
            inputSearch         :   '',
        },
        created() {
            this.loadSanPham();
            this.loadTableBenPhai();
        },
        methods :   {
            loadTableBenPhai() {
                axios
                    .get('/admin/nhap-kho/loadData')
                    .then((res) => {
                        this.danhSachKhoDangNhap = res.data.nhapKho;
                    });
            },
            loadSanPham() {
                axios
                    .get('/admin/san-pham/loadData')
                    .then((res) => {
                        this.danhSachSanPham = res.data.danhSachSanPham;
                    });
            },
            addKhoHang(id) {
                axios
                    .get('/admin/nhap-kho/add/' + id)
                    .then((res) => {
                        if(res.data.status == false) {
                            toastr.error("Sản phẩm không tồn tại!");
                        } else {
                            this.loadTableBenPhai();
                        }
                    });
            },
            search() {
                var payload = {
                    'tenSanPham'    :   this.inputSearch,
                };
                axios
                    .post('/admin/san-pham/search', payload)
                    .then((res) => {
                        this.danhSachSanPham    = res.data.dataProduct;
                    });
            },
            destroy(id) {
                axios
                    .get('/admin/nhap-kho/remove/' + id)
                    .then((res) => {
                        if(res.data.status == false) {
                            toastr.error("Sản phẩm không tồn tại!");
                        } else {
                            this.loadTableBenPhai();
                        }
                    });
            },
            update(row) {
                axios
                    .post('/admin/nhap-kho/update', row)
                    .then((res) => {
                        this.loadTableBenPhai();
                    });
            },
            createStore() {
                axios
                    .get('/admin/nhap-kho/create')
                    .then((res) => {
                        toastr.success("Đã Nhập Kho Thành Công!!!");
                        this.loadTableBenPhai();
                    });
            },
        },
    });
</script>
@endsection
