@extends('acr_ilan.index')
@section('title')
    <title>{{$ilan->name}} İş ilanı</title>
@stop
@section('keywords')
    <meta name="keywords" content="@foreach($keys as $key){{$key}},@endforeach"/>
@show
@section('description')
    <meta name="description" content="{{strip_tags($ilan->icerik)}} "/>
@show
@section('acr_ilan')
    <section class="content">
        <div class="row">
            {!! $msg !!}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h1> {{$ilan->name}}</h1>
                        <a class="btn btn-warning btn-sm " style=" float: right" href="/acr/ilan/cv">
                            <span class="badge"><span class="fa fa-file-word-o"></span></span> CV
                        </a>
                        <a class="btn btn-info btn-sm " style=" float: right" href="/acr/ilan">İlanlar</a>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa  fa-map-marker margin-r-5"></i> Şehir</strong>

                        {{$ilan->city->name}}
                        <hr>
                        <strong><i class="fa fa-map-pin margin-r-5"></i> İlçe</strong>
                        {{$ilan->county->name}}
                        <hr>
                        <strong><i class="fa fa-book margin-r-5"></i> Detay</strong>
                        {!! $ilan->icerik !!}
                        <br>
                        <div id="basvur_{{$ilan->id}}">
                            @if(in_array($ilan->id,$ilan_ids))
                                <div class="btn btn-danger btn-lg btn-block" onclick="basvuru_kaldir({{$ilan->id}})">Başvuruyu Kaldır</div>
                            @else
                                @if(Auth::check())
                                    <div class="btn btn-success btn-lg btn-block" onclick="basvur({{$ilan->id}})">Başvur</div>
                                @else
                                    <a href="/login" class="btn btn-success b btn-lg btn-block">BAŞVUR</a>
                                @endif

                            @endif

                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop
@section('footer')
    <script>
        function basvuru_kaldir(ilan_id) {
            $.ajax({
                type: 'post',
                url: '/acr/ilan/basvuru/kaldir',
                data: 'ilan_id=' + ilan_id,
                success: function (msg) {
                    $('#basvur_' + ilan_id).html(msg);
                }
            })

        }

        function basvur(ilan_id) {
            $.ajax({
                type: 'post',
                url: '/acr/ilan/basvur',
                data: 'ilan_id=' + ilan_id,
                success: function (msg) {
                    if (msg == 1) {
                        alert('CV\'nizi Güncellemeniz gerekir!!!')
                    } else {
                        $('#basvur_' + ilan_id).html(msg);

                    }
                }
            })

        }
    </script>
@stop