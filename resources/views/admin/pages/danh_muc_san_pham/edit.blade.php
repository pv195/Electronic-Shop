@extends('admin.master')
@section('title')
<div class="page-title-icon">
    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
</div>
<div>Quản Lý Danh Mục
    <div class="page-title-subheading">
        Cập nhật danh mục
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Cập Nhật Thông Tin Danh Mục Sản Phẩm</h5>
                @if($errors->any())
                    @foreach ($errors->all() as $key => $value)
                    <div class="alert alert-danger" role="alert">
                        {{ $value }}
                    </div>
                    @endforeach
                @endif
                <form autocomplete="off" method="post" action="/admin/danh-muc-san-pham/update-form">
                    @csrf
                    <input type="text" name="id" value="{{$danh_muc->id}}" hidden>
                    <div class="position-relative form-group">
                        <label>Tên Danh Mục</label>
                        <input value="{{$danh_muc->ten_danh_muc}}" id="ten_danh_muc" name="ten_danh_muc" placeholder="Nhập vào tên danh mục" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label>Slug Danh Mục</label>
                        <input value="{{$danh_muc->slug_danh_muc}}" id="slug_danh_muc" name="slug_danh_muc" placeholder="Nhập vào slug danh mục" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label>Hình Ảnh</label>
                        <div class="input-group">
                            <input value="{{$danh_muc->hinh_anh}}" name="hinh_anh" id="thumbnail" class="form-control" type="text">
                            <input type="button" class="btn-info lfm" data-input="thumbnail" data-preview="holder" value="Upload">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;" src="{{$danh_muc->hinh_anh}}">
                    </div>
                    <div class="position-relative form-group">
                        <label>Danh Mục Cha</label>
                        <select name="id_danh_muc_cha"class="form-control">
                            <option value="">Danh Mục Root</option>
                            @foreach ($danh_muc_cha as $key => $value)
                            <option value={{ $value->id }} {{$danh_muc->id_danh_muc_cha == $value->id ? 'selected' : ''}}>
                                {{ $value->ten_danh_muc }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label>Tình Trạng</label>
                        <select name="is_open"class="form-control">
                            <option value=1 {{$danh_muc->is_open == 1 ? 'selected' : ''}}>Hiển Thị</option>
                            <option value=0 {{$danh_muc->is_open == 0 ? 'selected' : ''}}>Tạm Tắt</option>
                        </select>
                    </div>
                    <button class="mt-1 btn btn-success">Cập Nhật Danh Mục</button>
                </form>
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
        $(document).ready(function(){
            function toSlug(str) {
                str = str.toLowerCase();
                str = str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '');
                str = str.replace(/[đĐ]/g, 'd');
                str = str.replace(/([^0-9a-z-\s])/g, '');
                str = str.replace(/(\s+)/g, '-');
                str = str.replace(/-+/g, '-');
                str = str.replace(/^-+|-+$/g, '');
                return str;
            }
            $("#ten_danh_muc").keyup(function(){
                var tenDanhMuc = $("#ten_danh_muc").val();
                var slugDanhMuc = toSlug(tenDanhMuc);
                $("#slug_danh_muc").val(slugDanhMuc);
                // $("#slug_danh_muc").val(toSlug($("#ten_danh_muc").val()));
            });
        });
    </script>
@endsection
