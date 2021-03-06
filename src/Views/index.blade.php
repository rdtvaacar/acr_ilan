@extends('acr_ilan.index')
@section('title')
    <title>Ücretsiz iş ilanları sayfası</title>
@stop
@section('keywords')
    <meta name="keywords" content="ücretsiz,ilan,iş,arama,bulma,bakıcı,okul öncesi,çocuk,okul,kreş,öğretmen,bebek"/>
@show
@section('description')
    <meta name="description" content="Ücretsiz ilan sayfası ile işletmenizin eleman ihtiyacını karşılamak için ilan hazırlayabilirsiniz."/>
@show
@section('header')
    @include('includes.data_table_css')
    <style>
        .icerik_div {
            border-radius: 14px 14px 14px 14px;
            -moz-border-radius: 14px 14px 14px 14px;
            -webkit-border-radius: 14px 14px 14px 14px;
            border: 0px solid #000000;
            display: none;
            position: absolute;
            background: #ffffff;
            padding: 10px;
            z-index: 9;
            -webkit-box-shadow: 12px 17px 79px -32px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 12px 17px 79px -32px rgba(0, 0, 0, 0.75);
            box-shadow: 12px 17px 79px -32px rgba(0, 0, 0, 0.75);
        }
    </style>
@stop
@section('acr_ilan')
    <section class="content">
        <div class="row">
            {!! $msg !!}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border"><h1>Ücretsiz İlan Sayfası</h1>
                        <a class="btn btn-success btn-sm " style=" float: right" href="/acr/ilan/yeni">
                            <span class="badge"><span class="fa fa-plus-square"></span></span> YENİ İLAN VER
                        </a>
                        <a class="btn btn-warning btn-sm " style=" float: right" href="/acr/ilan/cv">
                            <span class="badge"><span class="fa fa-file-word-o"></span></span> CV
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="data_table" class="table">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>İlan Sahibi</th>
                                <th>Başlık</th>
                                <th>Şehir</th>
                                <th>İlçe</th>
                                <th>Tarih</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ilans as $ilan)
                                <tr id="{{$ilan->id}}">
                                    <td>{{$ilan->id}}</td>
                                    <td>{{$ilan->user->name}}</td>
                                    <td>
                                        <a onmouseout="gosterme({{$ilan->id}})" onmouseover="goster({{$ilan->id}})" href="/acr/ilan/incele?id={{$ilan->id}}">{{$ilan->name}}</a>
                                        <div id="goster_{{$ilan->id}}" class="icerik_div" style=" display: none">{!!  $ilan->icerik !!}</div>
                                    </td>
                                    <td>{{$ilan->city->name}}</td>
                                    <td>{{$ilan->county->name}}</td>
                                    <td>{{$ilan->created_at}}</td>
                                    @if(Auth::check() == true &&$ilan->user_id == Auth::user()->id)
                                        <td><a class="btn btn-warning btn-sm" href="/acr/ilan/yeni?id={{$ilan->id}}">Düzenle</a></td>
                                        <td><a class="btn btn-info btn-sm" href="/acr/ilan/basvurular?ilan_id={{$ilan->id}}">Başvurular
                                                <span class="badge">{{$ilan->basvurular_count}}</span>
                                            </a></td>
                                        <td>
                                            <div onclick="sil({{$ilan->id}})" class="btn btn-danger btn-sm">Sil</div>
                                        </td>
                                    @else
                                        <td id="basvur_{{$ilan->id}}">
                                            @if(in_array($ilan->id,$ilan_ids))
                                                <div class="btn btn-danger btn-sm" onclick="basvuru_kaldir({{$ilan->id}})">Başvuruyu Kaldır</div>
                                            @else
                                                @if(Auth::check())
                                                    <div class="btn btn-success btn-sm" onclick="basvur({{$ilan->id}})">Başvur</div>
                                                @else
                                                    <a href="/login" class="btn btn-success btn-sm">BAŞVUR</a>
                                                @endif

                                            @endif
                                        </td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables/dataTables.rowReorder.min.js"></script>
    <script src="/plugins/datatables/dataTables.responsive.min.js"></script>
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

        function goster(id) {
            $('#goster_' + id).show();
        }

        function gosterme(id) {
            $('#goster_' + id).hide();
        }

        $('#data_table').DataTable({
            "responsive": true,
            "order": [[0, "desc"]],
            "paging": true,

            "lengthChange": false,

            "searching": true,

            "ordering": true,

            "info": true,

            "autoWidth": true,

            "language": {

                "sProcessing": "İşleniyor...",

                "lengthMenu": "Sayfada _MENU_ satır gösteriliyor",

                "zeroRecords": "Gösterilecek sonuç yok.",

                "info": "Toplam _PAGES_ sayfadan _PAGE_. sayfa gösteriliyor",

                "infoEmpty": "Gösterilecek öğe yok",

                "infoFiltered": "(filtered from _MAX_ total records)",

                "search": "Arama yap",

                "oPaginate": {

                    "sFirst": "İlk",

                    "sPrevious": "Önceki",

                    "sNext": "Sonraki",

                    "sLast": "Son"

                },


            },

            rowReorder: {

                selector: 'td:nth-child(5)'

            },

            responsive: true

        });

        function sil(id) {
            if (confirm('Silmek istediğinizden emin misiniz?') == true) {
                $.ajax({
                    type: 'post',
                    url: '/acr/ilan/sil',
                    data: 'id=' + id,
                    success: function () {
                        $('#' + id).hide();
                    }
                })
            }

        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop