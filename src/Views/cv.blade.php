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
                        <h4 style="float: left">CV Ekleyin</h4>
                        <a class="btn btn-info btn-sm " style=" float: right" href="/acr/ilan">İlanlar</a>
                    </div>
                    <div class="box-body">
                        <form method="post" action="/acr/ilan/cv/kaydet">
                            {{csrf_field()}}
                            <label>Başlık</label>
                            <input name="name" value="{{@$cv->name}}" class="form-control"/>
                            <div id="county"></div>
                            <label>Detay</label>
                            <textarea id="compose-textarea" name="icerik" class="form-control">{{@$cv->icerik}}</textarea>
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
                        <h4 style="float: left">CV Kuralları</h4>
                    </div>
                    <div class="box-body">
                        <ol>
                            <li>CV nizi aldatıcı şekilde hazırlamayın.</li>
                            <li>Sahte CV düzenlemek yasaktır</li>
                            <li>Düzenlenen CV ile bir kişiye maddi, manevi veya herhangi bir şekilde zarara uğratmak yasaktır.</li>
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
    </script>
@stop