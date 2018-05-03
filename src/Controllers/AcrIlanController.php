<?php

namespace Acr\Ilan\Controllers;

use Acr\Ilan\Model\Ilan_basvuru;
use Acr\Ilan\Model\Ilan_cv;
use App\City;
use App\County;
use Acr\Ilan\Model\Ilan;
use App\Handlers\Commands\my;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcrIlanController extends Controller
{
    protected $ilan_zaman;

    function ilan_denetim()
    {
        $ilan_zaman = time() - (30 * 24 * 60 * 60);
        $ilan_model = new Ilan();
        $ilanlar    = $ilan_model->where('updated_at' > $ilan_zaman)->first();
    }

    function incele(Request $request, my $my)
    {

        $ilan_model    = new Ilan();
        $basvuru_model = new Ilan_basvuru();
        $id            = $request->id;
        $ilan          = $ilan_model->where('id', $id)->first();
        $msg           = $my->msg();
        $ilan_ids      = [];
        if (Auth::check()) {
            $basvurular = $basvuru_model->where('user_id', Auth::user()->id)->get();
            foreach ($basvurular as $basvuru) {
                $ilan_ids[] = $basvuru->ilan_id;
            }
        }
        $keys = explode(" ", $ilan->name);
        return View('acr_ilan::incele', compact('ilan', 'msg', 'ilan_ids', 'keys'));
    }

    function basvurular(Request $request, my $my)
    {
        $msg        = $my->msg();
        $ilan_model = new Ilan();
        $ilan_id    = $request->ilan_id;
        $ilan       = $ilan_model->where('user_id', Auth::user()->id)->where('id', $ilan_id)->with([
            'basvurular' => function ($q) {
                $q->with([
                    'user',
                    'cv'
                ]);
            },
        ])->first();
        return View('acr_ilan::basvurular', compact('msg', 'ilan', 'ilan_id'));
    }

    function basvuru_kaldir(Request $request)
    {
        $basvuru_model = new Ilan_basvuru();
        $ilan_id       = $request->ilan_id;
        $basvuru_model->where('ilan_id', $ilan_id)->where('user_id', Auth::user()->id)->delete();
        return '<div class="btn btn-success btn-sm" onclick="basvur(' . $ilan_id . ')">Başvur</div>';
    }

    function basvur(Request $request)
    {
        $cv_model = new Ilan_cv();
        $cv       = $cv_model->where('user_id', Auth::user()->id)->first();
        if (empty($cv->id)) {
            return 1;
        }
        $basvuru_model = new Ilan_basvuru();
        $ilan_id       = $request->ilan_id;
        $data          = [
            'user_id' => Auth::user()->id,
            'cv_id'   => $cv->id,
            'ilan_id' => $ilan_id
        ];
        $basvuru_id    = $basvuru_model->insertGetId($data);
        return '<div class="btn btn-danger btn-sm" onclick="basvuru_kaldir(' . $ilan_id . ')">Başvuruyu Kaldır</div>';
    }

    function cv_kaydet(Request $request)
    {
        $cv_model = new Ilan_cv();
        $data     = [
            'name'    => $request->name,
            'icerik'  => $request->icerik,
            'user_id' => Auth::user()->id,
        ];
        $id       = $request->id;
        if (empty($id)) {
            $cv_model->insert($data);
        } else {
            $cv_model->where('id', $id)->where('user_id', Auth::user()->id)->update($data);
        }
        return redirect()->back()->with('msg', $this->basarili());
    }

    function cv(my $my)
    {
        $cv_model = new Ilan_cv();
        $sayi     = $cv_model->where('user_id', Auth::user()->id)->count();
        if ($sayi < 1) {
            $cv_model->insertGetId(['user_id' => Auth::user()->id]);
        }
        $cv  = $cv_model->where('user_id', Auth::user()->id)->first();
        $id  = $cv->id;
        $msg = $my->msg();
        return View('acr_ilan::cv', compact('cv', 'cities', 'msg', 'id'));
    }

    function index(my $my)
    {
        $msg           = $my->msg();
        $ilan_model    = new Ilan();
        $basvuru_model = new Ilan_basvuru();
        $ilan_ids      = [];
        if (Auth::check()) {
            $basvurular = $basvuru_model->where('user_id', Auth::user()->id)->get();
            foreach ($basvurular as $basvuru) {
                $ilan_ids[] = $basvuru->ilan_id;
            }
        }
        $ilans = $ilan_model->with([
            'city',
            'county',
            'user',
        ])->withCount('basvurular')->get();
        return View('acr_ilan::index', compact('msg', 'ilans', 'ilan_ids'));
    }

    function sil(Request $request)
    {
        $ilan_model = new Ilan();
        $id         = $request->id;
        $ilan_model->where('id', $id)->delete();
    }

    function yeni(Request $request, my $my)
    {
        $ilan_model = new Ilan();
        $id         = $request->id;
        $ilan       = $ilan_model->where('id', $id)->where('user_id', Auth::user()->id)->first();
        $city_model = new City();
        $cities     = $city_model->get();
        $msg        = $my->msg();
        return View('acr_ilan::yeni', compact('ilan', 'cities', 'msg', 'id'));
    }

    function kaydet(Request $request)
    {
        $ilan_model = new Ilan();
        $data       = [
            'name'      => $request->name,
            'icerik'    => $request->icerik,
            'city_id'   => $request->city_id,
            'county_id' => $request->county_id,
            'user_id'   => Auth::user()->id,
        ];
        $id         = $request->id;
        if (empty($id)) {
            $ilan_model->insert($data);
        } else {
            $ilan_model->where('id', $id)->where('user_id', Auth::user()->id)->update($data);
        }
        return redirect()->back()->with('msg', $this->basarili());
    }

    function county(Request $request, $city_id = null, $county_id = null)
    {
        $county_model = new County();
        if (empty($city_id)) {
            $city_id = $request->input('city_id');
        }
        if (empty($county_id)) {
            $county_id = $request->input('county_id');
        }
        $counties = $county_model->where('city_id', $city_id)->get();
        // citys
        $row = '<div class="form-group">';
        $row .= '<label>İLÇE</label>';
        $row .= '<select id="county_id" required name="county_id" class="form-control ">';
        $row .= '<option value="">SEÇİNİZ</option>';
        foreach ($counties as $county) {
            $select = $county->id == $county_id ? 'selected="selected"' : '';
            $row    .= '<option ' . $select . ' value="' . $county->id . '">';
            $row    .= $county->name;
            $row    .= '</option>';
        }
        $row .= '</select>';
        $row .= '</div>';
        return $row;
    }

}