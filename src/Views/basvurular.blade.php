@extends('acr_ilan.index')
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
                        <a class="btn btn-info btn-sm " style=" float: right" href="/acr/ilan">
                            İLANLAR
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="data_table" class="table">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Başvuru Sahibi</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Tarih</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ilan->basvurular as $basvuru)
                                <tr id="{{$basvuru->id}}">
                                    <td>{{$basvuru->id}}</td>
                                    <td>
                                        <div style="cursor:pointer;" onmouseout="gosterme({{$basvuru->cv->id}})" onmouseover="goster({{$basvuru->cv->id}})"><span class="text-aqua">{{$basvuru->user->name}}</span></div>
                                        <div id="goster_{{$basvuru->cv->id}}" class="icerik_div" style=" display: none">{!!  $basvuru->cv->icerik !!}</div>
                                    </td>
                                    <td>{{$basvuru->user->email}}</td>
                                    <td>{{$basvuru->user->tel}}</td>
                                    <td>{{$basvuru->created_at}}</td>
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
                    $('#basvur_' + ilan_id).html(msg);
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