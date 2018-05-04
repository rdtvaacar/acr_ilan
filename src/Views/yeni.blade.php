@extends('acr_ilan.index')
@section('header')
    <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@stop
@section('acr_ilan')
    <section class="content">
        <div class="row">
            {!! $msg !!}
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 style="float: left">Yeni İlan Ekle</h4>
                        <a class="btn btn-info btn-sm " style=" float: right" href="/acr/ilan">İlanlar</a>
                    </div>
                    <div class="box-body">
                        <form method="post" action="/acr/ilan/kaydet">
                            {{csrf_field()}}
                            <label>Başlık</label>
                            <input name="name" value="{{@$ilan->name}}" class="form-control"/>
                            <label>Şehir</label>
                            <select class="form-control" id="city" name="city_id">
                                @foreach($cities as $city)
                                    <option {{@$ilan->city_id == $city->id ? 'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                            <div id="county"></div>
                            <label>Detay</label>
                            <textarea id="compose-textarea" name="icerik" class="form-control">{{@$ilan->icerik}}</textarea>
                            <br>
                            @if(!empty($id))
                                <input name="id" value="{{$id}}" type="hidden"/>
                            @endif
                            <button class="btn btn-primary">Bilgileri Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 style="float: left">İlan Kuralları</h4>
                    </div>
                    <div class="box-body">
                        <ol>
                            <li>İlanınız 2 ay boyunca yayında kalır, ardından yayından kaldırılır.</li>
                            <li>Sahte ilanlar düzenlemek yasaktır</li>
                            <li>Düzenlenen ilan ile bir kişiye maddi, manevi veya herhangi bir şekilde zarara uğratmak yasaktır.</li>
                        </ol>
                        yukarıdaki kurallara uymayanların verileri istenmesi halinde adli mercilerle paylaşılmak üzere saklanacaktır.
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop
@section('footer')
    <script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Page Script -->
    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
        $('#city').change(function () {
            city_id = $(this).val();
            county_get(city_id);
        });
        @if(!empty($id))
        $(document).ready(function () {
            county_get({{$ilan->city->id}},{{$ilan->county_id}});
        });

        @endif
        function county_get(city_id, county_id) {
            $.ajax({
                type: 'post',
                url: '/acr/ilan/county',
                data: 'city_id=' + city_id + '&county_id=' + county_id,
                success: function (veri) {
                    $('#county').html(veri);
                }
            });
        }
    </script>
@stop