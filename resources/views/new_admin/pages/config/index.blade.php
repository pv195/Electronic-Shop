@extends('new_admin.master')
@section('title')
    <h3>Quản Lý Cấu hình</h3>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
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
                    <form action="/admin/cau-hinh" method="post">
                        @csrf

                        @for($i = 1; $i < 6; $i++)
                        @php
                            $name = 'slide_' . $i;
                        @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label>Silde {{ $i }}</label>
                                    <div class="input-group">
                                        <input id="anh_dai_dien_{{$name}}" name="{{$name}}" class="form-control" type="text" value="{{ (isset($config->$name) && Str::length($config->$name) > 0) ? $config->$name : ''}}">
                                        <input type="button" class="btn-info lfm" data-input="anh_dai_dien_{{$name}}" data-preview="holder_{{$name}}" value="Upload">
                                    </div>
                                    <img id="holder_{{$name}}" style="margin-top:15px;max-height:100px;" src="{{ (isset($config->$name) && Str::length($config->$name) > 0) ? $config->$name : ''}}">
                                </div>
                            </div>
                        </div>
                        @endfor

                        <div class="form-actions right">
                            <button type="submit" class="btn btn-primary">
                                Cập Nhật Cấu Hình
                            </button>
                        </div>
                    </form>
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
@endsection
