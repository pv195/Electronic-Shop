<div class="main-page-banner pb-50 off-white-bg">
    <div class="container">
        <div class="row">
            @include('home_page.shares.menu')
            <div class="col-xl-9 col-lg-8 slider_box">
                <div class="slider-wrapper theme-default">
                    <div id="slider" class="nivoSlider">
                        @for($i = 1; $i < 6; $i++)
                            @php
                                $name = 'slide_' . $i;
                            @endphp
                            @if(isset($config->$name) && Str::length($config->$name) > 0)
                                <a href="/">
                                    <img src="{{ $config->$name }}" data-thumb="{{ $config->$name }}">
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
