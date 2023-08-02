<?php

namespace App\Http\Controllers;

use App\Models\PajakPenghasilan;
use App\Models\RekamSPT;
use App\Models\Doss;
use App\Models\Dopp;
use App\Models\Sptmasa;
use App\Models\Penandatangan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPTController extends Controller
{


    public function proses_tambah_buktisetor(Request $request)
    {
        $data = [
            'jenis_bukti_penyetoran' => $request->jenis_bukti_penyetoran,
            'npwp' => $request->npwp,
            'ntpn' => $request->ntpn,
            'nomor_pemindahbukuan' => $request->nomor_pemindahbukuan,
            'tahun_pajak' => $request->tahun_pajak,
            'masa_pajak' => $request->masa_pajak,
            'jenis_pajak' => $request->jenis_pajak,
            'jenis_setoran' => $request->jenis_setoran,
            'jumlah_setor' => $request->jumlah_setor,
            'tanggal_setor' => $request->tanggal_setor,
        ];
        $rekam_spt = new RekamSPT();
        $rekam_spt->create($data);
        return response()->json('sukses');
    }

    public function hapus_buktisetor($id)
    {
        $rekam_spt = RekamSPT::find($id);
        $rekam_spt->delete();
        return response()->json('sukses');
    }

    public function get_sptmasa(Request $request, $userid)
    {
        // $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'status' => 'sudah posting', 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        $PajakPenghasilan = PajakPenghasilan::selectRaw("jenis_pajak,jenis_setoran, FORMAT(SUM(CONVERT(REGEXP_REPLACE(jumlah_setor, '[,.]', ''), INTEGER)),0) AS total_jumlah_setor")->groupBy(['jenis_setoran', 'jenis_pajak'])->where(['user_id' => $userid, 'status' => 'sudah posting', 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        $sptmasa = Sptmasa::selectRaw("sptmasa.id, sptmasa.id_billing, sptmasa.jenis_pajak,sptmasa.jenis_setoran,sptmasa.jumlah_setor,sptmasa.nomor_bukti,sptmasa.tanggal_setor, (SELECT FORMAT(SUM(CONVERT(REGEXP_REPLACE(pajak_penghasilan.jumlah_setor, '[,.]', ''), INTEGER)),0) FROM pajak_penghasilan WHERE pajak_penghasilan.jenis_setoran = sptmasa.jenis_setoran AND pajak_penghasilan.masa_pajak = sptmasa.masa_pajak AND pajak_penghasilan.tahun_pajak = sptmasa.tahun_pajak AND pajak_penghasilan.user_id = sptmasa.user_id) as total_pajak_penghasilan")->groupBy(['id','jenis_setoran', 'jenis_pajak', 'jumlah_setor','id_billing'])->where(['user_id' => $userid, 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        return response()->json(['pajak_penghasilan' => $PajakPenghasilan, 'sptmasa' => $sptmasa], 200);
    }

    public function get_dashboard(Request $request, $userid)
    {
        // $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'status' => 'sudah posting', 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        $sptmasa = Sptmasa::selectRaw("sptmasa.id, sptmasa.id_billing, sptmasa.jenis_pajak, sptmasa.masa_pajak, sptmasa.tahun_pajak,sptmasa.jenis_setoran,sptmasa.jumlah_setor,sptmasa.nomor_bukti,sptmasa.tanggal_setor, (SELECT FORMAT(SUM(CONVERT(REGEXP_REPLACE(pajak_penghasilan.jumlah_setor, '[,.]', ''), INTEGER)),0) FROM pajak_penghasilan WHERE pajak_penghasilan.jenis_setoran = sptmasa.jenis_setoran AND pajak_penghasilan.masa_pajak = sptmasa.masa_pajak AND pajak_penghasilan.tahun_pajak = sptmasa.tahun_pajak) as total_pajak_penghasilan")->groupBy(['id','jenis_setoran', 'jenis_pajak', 'jumlah_setor','id_billing'])->where(['user_id' => $userid])->get();
        return response()->json(['sptmasa' => $sptmasa], 200);
    }

    public function surat_billing($id)
    {
        $sptmasa = Sptmasa::find($id);
        return response()->json($sptmasa, 200);
    }

    public function surat_bpe($id)
    {
        $sptmasa = Sptmasa::find($id);
        return response()->json($sptmasa, 200);
    }

    public function get_penyiapansptmasa(Request $request, $userid)
    {
        $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        return response()->json($sptmasa, 200);
    }

    public function get_lengkapispt(Request $request, $userid)
    {
        $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        return response()->json($sptmasa, 200);
    }

    public function get_kirimspt(Request $request, $userid)
    {
        $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        return response()->json($sptmasa, 200);
    }

    public function get_indukspt(Request $request, $userid)
    {
        $sptmasa = PajakPenghasilan::selectRaw(" FORMAT(SUM(CONVERT(REGEXP_REPLACE(jumlah_setor, '[,.]', ''), INTEGER)),0) AS total_jumlah_setor")
        ->groupBy(DB::raw('SUBSTRING_INDEX(kode_objek_pajak, "-", 1)'))
        ->where(['user_id' => $userid, 'status' => 'sudah posting', 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])
        ->whereRaw('SUBSTRING_INDEX(kode_objek_pajak, "-", 1) = ?', $request->kode_objek_pajak)
        ->get();

        return response()->json($sptmasa, 200);
    }

    public function get_dbp1(Request $request, $userid)
    {
        $sptmasa = PajakPenghasilan::where(['user_id' => $userid, 'tahun_pajak' => $request->tahun_pajak, 'masa_pajak' => $request->masa_pajak])->get();
        return response()->json($sptmasa, 200);
    }
    public function get_id_billing($n)
    {
      $characters = '0123456789';
      $random = '';

      for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $random .= $characters[$index];
      }

      return $random;
    }
    public function update_id_billing($sptmasa_id)
    {
        $sptmasa= Sptmasa::find($sptmasa_id);
        $today = strtotime(date('Y-m-d H:i:s'));
        $expired = date('Y-m-d H:i:s',strtotime('+1 month',$today));
        $sptmasa->id_billing= $this->get_id_billing(10);
        $sptmasa->billing_expired = $expired;
        $sptmasa->save();
        return response()->json('berhasil', 200);
    }

    public function simpan_penandatangan(Request $request)
    {
        $data = [
            'pengaturan_id' => $request->pengaturan_id,
            'tahun_pajak' => $request->tahun_pajak,
            'masa_pajak' => $request->masa_pajak,
        ];
        $rekam_spt = new Penandatangan();
        $rekam_spt->create($data);
        return response()->json('sukses');
    }

    public function simpan_doss_dopp(request $request)
    {
        $datadoss = [
            [
                'doss_point_id' => '1',
                'kode_objek_pajak' => null,
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp1),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph1),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'doss_point_id' => '2',
                'kode_objek_pajak' => null,
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp2),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph2),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,
            ],
            [
                'doss_point_id' => '3',
                'kode_objek_pajak' => null,
                'jumlah_dpp' => null,
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph3),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,
            ],
            [
                'doss_point_id' => '4',
                'kode_objek_pajak' => null,
                'jumlah_dpp' => null,
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph4),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,
            ],
            [
                'doss_point_id' => '5',
                'kode_objek_pajak' => null,
                'jumlah_dpp' => null,
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph5),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,
            ]
        ];

        $datadopp = [
            [
                'dopp_point_id' => '1',
                'kode_objek_pajak' => "22-101-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp6),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph6),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '2',
                'kode_objek_pajak' => "22-405-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp7),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph7),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '3',
                'kode_objek_pajak' => "22-405-02",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp8),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph8),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '4',
                'kode_objek_pajak' => "27-100-07",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp9),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph9),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '5',
                'kode_objek_pajak' => "27-102-03",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp10),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph10),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '6',
                'kode_objek_pajak' => "28-401-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp11),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph11),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '7',
                'kode_objek_pajak' => "28-401-04",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp12),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph12),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '8',
                'kode_objek_pajak' => "28-401-05",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp13),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph13),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '9',
                'kode_objek_pajak' => "28-401-06",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp14),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph14),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '10',
                'kode_objek_pajak' => "28-404-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp15),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph15),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '11',
                'kode_objek_pajak' => "28-404-02",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp16),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph16),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '12',
                'kode_objek_pajak' => "28-404-03",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp17),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph17),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '13',
                'kode_objek_pajak' => "28-404-04",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp18),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph18),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '14',
                'kode_objek_pajak' => "28-404-05",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp19),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph19),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '15',
                'kode_objek_pajak' => "28-404-06",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp20),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph20),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '16',
                'kode_objek_pajak' => "28-404-07",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp21),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph21),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '17',
                'kode_objek_pajak' => "28-404-08",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp22),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph22),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '18',
                'kode_objek_pajak' => "28-102-09",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp23),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph23),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '19',
                'kode_objek_pajak' => "28-404-10",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp24),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph24),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '20',
                'kode_objek_pajak' => "28-404-11",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp25),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph25),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '21',
                'kode_objek_pajak' => "28-406-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp26),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph26),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '22',
                'kode_objek_pajak' => "28-407-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp27),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph27),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ],
            [
                'dopp_point_id' => '23',
                'kode_objek_pajak' => "28 -408-01",
                'jumlah_dpp' => str_replace(",","",$request->jumlah_dpp28),
                'jumlah_pph' => str_replace(",","",$request->jumlah_pph28),
                'pajak_penghasilan_id' => $request->pajak_penghasilan_id,

            ]

        ];

        $doss = Doss::insert($datadoss);
        $dopp = Dopp::insert($datadopp);
        // $rekam_spt->create($data);
        return response()->json('suksess');
    }

    public function get_doss($id)
    {
        $data = Doss::where('pajak_penghasilan_id', $id)->get();
        return response()->json($data, 200);
    }
    public function get_dopp($id)
    {
        $data = Dopp::where('pajak_penghasilan_id', $id)->get();
        return response()->json($data, 200);
    }

    public function get_penandatangan(Request $request)
    {
        $data = Penandatangan::with(['pengaturan'])->where(['tahun_pajak'=> $request->tahun_pajak, 'masa_pajak'=> $request->masa_pajak])->get();
        return response()->json($data, 200);
    }

    public function tambah_spt(Request $request, $userid)
    {
        //  dd($request->all());
        try {
            $hitung_data_hari_ini = PajakPenghasilan::select("id")
                ->where('tanggal_setor', date('d-m-Y', time()))
                ->get()->count();
            // return response()->json($hitung_data_hari_ini,200);
            $data = [
                'jenis_bukti_penyetoran' => $request->jenis_bukti_penyetoran,
                'ntpn' => $request->ntpn,
                'npwp' => $request->npwp,
                'nomor_bukti' => date('Ymd', time()) . str_pad(((int)$hitung_data_hari_ini += 1), 6, '0', STR_PAD_LEFT),
                'tahun_pajak' => $request->tahun_pajak,
                'no_identitas' => $request->npwp,
                'nama' => $request->nama,
                'masa_pajak' => $request->masa_pajak,
                'jenis_pajak' => $request->jenis_pajak,
                'jenis_setoran' => $request->jenis_setoran,
                'jumlah_setor' => $request->jumlah_setor,
                'tanggal_setor' => $request->tanggal_setor,
                'user_id' => $userid,
                'tipe' => 'pphsendiri',

            ];
            $sptmasa = new Sptmasa();
            $sptmasa->create($data);
            return response()->json('sukses', 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }
}
