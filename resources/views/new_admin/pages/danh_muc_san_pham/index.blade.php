@extends('new_admin.master')
@section('title')
    <h3>Quản Lý Danh Mục</h3>
@endsection
@section('content')
<div id="app">
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="height: auto">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">Thêm mới danh mục</h4>
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
                        <form class="form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="userinput1">Tên Danh Mục</label>
                                            <input type="text" class="form-control" v-on:keyup="toSlug(ten_danh_muc)" v-model="ten_danh_muc"  name="ten_danh_muc">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="userinput3">Slug Danh Mục</label>
                                            <input type="text" class="form-control" v-model="slug_danh_muc" name="slug_danh_muc">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="userinput3">Hình Ảnh</label>
                                            <div class="input-group">
                                                <input v-model="hinh_anh" name="hinh_anh" class="form-control" type="text">
                                                <input type="button" class="btn-info lfm" data-input="hinh_anh" data-preview="holder" value="Upload">
                                            </div>
                                            <img style="margin-top:15px;max-height:100px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="issueinput6">Danh Mục Cha</label>
                                        <select v-model="id_danh_muc_cha" id="issueinput6" name="status" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Status" data-original-title="" title="">
                                            <option value="">Root</option>
                                            <template v-for="(value, key) in danh_muc_cha_vue">
                                                <option v-bind:value="value.id">@{{ value.ten_danh_muc }}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="issueinput6">Tình Trạng</label>
                                        <select v-model="is_open" name="status" class="form-control" >
                                            <option value="1" >Hiển Thị</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions right">
                                <button type="button" v-on:click="create($event)" class="btn btn-primary">Thêm mới Danh Mục
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách danh mục</h4>
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

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Tên Danh Mục</th>
                                            <th>Danh Mục Cha</th>
                                            <th>Tình Trạng</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(value, key) in list_vue">
                                            <th class="text-center align-middle">@{{ key + 1 }}</th>
                                            <td class="align-middle">@{{ value.ten_danh_muc }}</td>
                                            <td class="text-center align-middle">@{{ value.ten_danh_muc_cha === null ? 'Root' : value.ten_danh_muc_cha }}</td>
                                            <td class="text-center">
                                                {{-- @{{ value.is_open == 1 ? 'Hiển Thị' : 'Tạm Tắt' }} --}}
                                                <button class="btn btn-primary" v-on:click="doiTrangThai(value.id)"  v-if="value.is_open">Hiển Thị</button>
                                                <button class="btn btn-danger" v-on:click="doiTrangThai(value.id)" v-else>Tạm Tắt</button>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" v-on:click="editDanhMuc(value.id)">Edit</button>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" v-on:click="deleteDanhMuc(value.id)">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Danh Mục Sản Phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" v-model="idDelete"  placeholder="Nhập vào id cần xóa" hidden>
                    Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" v-on:click="acceptDelete()" data-dismiss="modal">Xóa Danh Mục</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Chỉnh Sửa Danh Mục Sản Phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <input type="text" v-model="idEdit" hidden>
                    <div class="position-relative form-group">
                        <label>Tên Danh Mục</label>
                        <input placeholder="Nhập vào tên danh mục" v-on:keyup="toSlugEdit(ten_danh_muc_edit)" v-model="ten_danh_muc_edit" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label>Slug Danh Mục</label>
                        <input placeholder="Nhập vào slug danh mục" v-model="slug_danh_muc_edit"  type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label>Hình Ảnh</label>
                        <div class="input-group">
                            <input v-model="hinh_anh_edit" class="form-control" type="text">
                            <input type="button" class="btn-info lfm" data-input="hinh_anh_edit" data-preview="holder_edit" value="Upload">
                        </div>
                        <img id="holder_edit" style="margin-top:15px;max-height:100px;">
                    </div>
                    <div class="position-relative form-group">
                        <label>Danh Mục Cha</label>
                        <select v-model="id_danh_muc_cha_edit" class="form-control">
                            {{-- <option value=0>Root</option> --}}
                            <option value="">Root</option>
                            <template  v-for="(value, key) in danh_muc_cha_vue">
                                <option v-bind:value="value.id">@{{ value.ten_danh_muc }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label>Tình Trạng</label>
                        <select v-model="is_open_edit" class="form-control">
                            <option value=1>Hiển Thị</option>
                            <option value=0>Tạm Tắt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" v-on:click="acceptUpdate()">Cập Nhật Danh Mục</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('.lfm').filemanager('image');
</script>
<script>
    new Vue({
        el              : "#app",
        data            : {
            ten_danh_muc            :   '',
            slug_danh_muc           :   '',
            hinh_anh                :   '',
            id_danh_muc_cha         :   0,
            is_open                 :   1,
            list_vue                :   [],
            danh_muc_cha_vue        :   [],
            danh_muc_edit           :   {},
            idDelete                :   0,
            idEdit                  :   0,
            ten_danh_muc_edit       :   '',
            slug_danh_muc_edit      :   '',
            hinh_anh_edit           :   '',
            id_danh_muc_cha_edit    :   0,
            is_open_edit            :   1,
        },

        created(){
            this.getData();
        },

        methods         : {
            toSlug(str) {
                str = str.toLowerCase();
                str = str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '');
                str = str.replace(/[đĐ]/g, 'd');
                str = str.replace(/([^0-9a-z-\s])/g, '');
                str = str.replace(/(\s+)/g, '-');
                str = str.replace(/-+/g, '-');
                str = str.replace(/^-+|-+$/g, '');

                this.slug_danh_muc = str;
            },
            toSlugEdit(str) {
                str = str.toLowerCase();
                str = str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '');
                str = str.replace(/[đĐ]/g, 'd');
                str = str.replace(/([^0-9a-z-\s])/g, '');
                str = str.replace(/(\s+)/g, '-');
                str = str.replace(/-+/g, '-');
                str = str.replace(/^-+|-+$/g, '');

                this.slug_danh_muc_edit = str;
            },

            create(e){
                e.preventDefault();
                var payload = {
                    'ten_danh_muc'      :   this.ten_danh_muc,
                    'slug_danh_muc'     :   this.slug_danh_muc,
                    'hinh_anh'          :   this.hinh_anh,
                    'id_danh_muc_cha'   :   this.id_danh_muc_cha,
                    'is_open'           :   this.is_open,
                };

                axios
                    .post('/admin/danh-muc-san-pham/index', payload)
                    .then((res) => {
                        // console.log(res);
                        toastr.success('Thêm mới thành công danh mục!');
                        this.getData();
                    })
                    .catch((res) => {
                        var danh_sach_loi = res.response.data.errors;
                        $.each(danh_sach_loi, function(key, value){
                            toastr.error(value[0]);
                        });
                    });
            },

            getData(){
                axios
                    .get('/admin/danh-muc-san-pham/data')
                    .then((res) => {
                        this.list_vue           = res.data.list;
                        this.danh_muc_cha_vue   = res.data.danh_muc_cha;
                    })
            },

            doiTrangThai(id) {
                axios
                    .get('/admin/danh-muc-san-pham/doi-trang-thai/' + id)
                    .then((res) => {
                        if(res.data.trangThai) {
                            toastr.success('Đã đổi trạng thái thành công!');
                            // Tình trạng mới là true
                            this.getData();
                        } else {
                            toastr.error('Vui lòng không can thiệp hệ thống!');
                        }
                    })
            },

            deleteDanhMuc(id){
                this.idDelete = id;
            },

            acceptDelete(){
                axios
                    .get('/admin/danh-muc-san-pham/delete/' + this.idDelete)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success('Đã xóa danh mục thành công');
                            this.getData();
                        } else {
                            toastr.error('Danh mục không tồn tại');
                        }
                    })
            },

            editDanhMuc(id){
                this.idEdit = id;
                axios
                    .get('/admin/danh-muc-san-pham/edit/' + id)
                    .then((res) => {
                        console.log(res);
                        if(res.data.status) {
                            this.ten_danh_muc_edit      =   res.data.data.ten_danh_muc;
                            this.slug_danh_muc_edit     =   res.data.data.slug_danh_muc;
                            this.hinh_anh_edit          =   res.data.data.hinh_anh;
                            this.id_danh_muc_cha_edit   =   res.data.data.id_danh_muc_cha;
                            this.is_open_edit           =   res.data.data.is_open;
                        } else {
                            toastr.error('Danh mục không tồn tại');
                        }
                    })
            },

            acceptUpdate() {
                var payload = {
                    'id'                 :   this.idEdit,
                    'ten_danh_muc'       :   this.ten_danh_muc_edit,
                    'slug_danh_muc'      :   this.slug_danh_muc_edit,
                    'hinh_anh'           :   this.hinh_anh_edit,
                    'id_danh_muc_cha'    :   this.id_danh_muc_cha_edit,
                    'is_open'            :   this.is_open_edit,
                };

                // console.log(payload);

                axios
                    .post('/admin/danh-muc-san-pham/update', payload)
                    .then((res) => {
                        // console.log(res);
                        toastr.success('Cập thành công danh mục!');
                        this.getData();
                    })
                    .catch((res) => {
                        var danh_sach_loi = res.response.data.errors;
                        $.each(danh_sach_loi, function(key, value){
                            toastr.error(value[0]);
                        });
                    });
            },
        },
    });
</script>
@endsection
