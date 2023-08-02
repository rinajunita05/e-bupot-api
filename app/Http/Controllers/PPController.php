<?php

namespace App\Http\Controllers;

use App\Models\PphPasal;
use App\Models\PphSendiri;
use App\Models\PphNon;
use App\Models\DokumenPphPasal;
use App\Models\DokumenPphNon;
use App\Imports\DataImport;
use App\Models\ImportData;
use App\Imports\DataDetailImport;
use App\Models\PajakPenghasilan;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Posting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PPController extends Controller
{
    public function get_pphpasal_byid($id)
    {
        $pphpasal = PphPasal::select(['pphpasal.*', 'objek_pajak.nama_pajak', 'dokumen_pphpasal.nama_dokumen', 'dokumen_pphpasal.no_dokumen', 'dokumen_pphpasal.tgl_dokumen'])->with(['pengaturan'])
            ->join('objek_pajak', 'objek_pajak.kode_pajak', '=', 'pphpasal.kode_objek_pajak')
            ->join('dokumen_pphpasal', 'dokumen_pphpasal.pphpasal_id', '=', 'pphpasal.id')->find($id);
        return response()->json($pphpasal, 200);
    }
    public function get_import_data()
    {
        $import_data = ImportData::selectRaw("*, (SELECT COUNT(id) FROM import_data_details WHERE import_data_id = import_data.id) AS jml_baris")->get();
        return response()->json($import_data, 200);
    }
    public function proses_tambah_pphsendiri(Request $request, $user_id)
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
                'nomor_pemindahbukuan' => $request->nomor_pemindahbukuan,
                'nomor_bukti' => date('Ymd', time()) . str_pad(((int)$hitung_data_hari_ini += 1), 6, '0', STR_PAD_LEFT),
                'tahun_pajak' => $request->tahun_pajak,
                'masa_pajak' => $request->masa_pajak,
                'jenis_pajak' => $request->jenis_pajak,
                'jenis_setoran' => $request->jenis_setoran,
                'kode_objek_pajak' => $request->kode_objek_pajak,
                'jumlah_penghasilan_bruto' => $request->jumlah_penghasilan_bruto,
                'jumlah_setor' => $request->jumlah_setor,
                'tanggal_setor' => $request->tanggal_setor,
                'tipe' => 'pphsendiri',
                'user_id' => $user_id
            ];
            $pphsendiri = new PajakPenghasilan();
            $pphsendiri->create($data);
            return response()->json('sukses', 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }
    public function get_pphsendiri($userid)
    {
        $data = PajakPenghasilan::where(['tipe' => 'pphsendiri' , 'user_id' => $userid ])->get();
        return response()->json($data, 200);
    }

    public function proses_edit_pphsendiri(Request $request, $id)
    {
        try {
            //code...
            $pajak_penghasilan = PajakPenghasilan::find($id);
            $pajak_penghasilan->jenis_bukti_penyetoran = $request->jenis_bukti_penyetoran;
            $pajak_penghasilan->ntpn = $request->ntpn;
            $pajak_penghasilan->nomor_pemindahbukuan = $request->nomor_pemindahbukuan;
            $pajak_penghasilan->masa_pajak = $request->masa_pajak;
            $pajak_penghasilan->jenis_pajak = $request->jenis_pajak;
            $pajak_penghasilan->jenis_setoran = $request->jenis_setoran;
            $pajak_penghasilan->kode_objek_pajak = $request->kode_objek_pajak;
            $pajak_penghasilan->jumlah_penghasilan_bruto = $request->jumlah_penghasilan_bruto;
            $pajak_penghasilan->jumlah_setor = $request->jumlah_setor;
            $pajak_penghasilan->tanggal_setor = $request->tanggal_setor;
            $pajak_penghasilan->save();
            return response()->json($pajak_penghasilan, 200);
        } catch (Exception $e) {
            //throw $th;
            return response()->json($e->getMessage(), 403);
        }
    }

    public function hapus_pphsendiri($id)
    {
        $pphsendiri = PajakPenghasilan::find($id);
        $pphsendiri->delete();
        return response()->json('sukses');
    }

    public function get_pajakpenghasilan($id)
    {
        $pajak_penghasilan = PajakPenghasilan::select(['pajak_penghasilan.*','dokumen_pphpasal.nama_dokumen','dokumen_pphpasal.no_dokumen','dokumen_pphpasal.tgl_dokumen'])->with(['pengaturan','objek_pajak'])
        ->leftJoin('dokumen_pphpasal', 'pajak_penghasilan.id', '=', 'dokumen_pphpasal.pajak_penghasilan_id')
        ->find($id);
        // $pphsendiri->edit(); 
        return response()->json($pajak_penghasilan, 200);
    }

    //pph pasal-----------------------------------------------------

    public function proses_tambah_pphpasal(Request $request, $user_id)
    {
        $hitung_data_hari_ini = PajakPenghasilan::select("pajak_penghasilan.id")
            ->join('dokumen_pphpasal', 'pajak_penghasilan.id', '=', 'dokumen_pphpasal.pajak_penghasilan_id')
            ->where('tgl_dokumen', date('d-m-Y', time()))
            ->get()->count();
        // $pphpasal= new Pphpasal();
        // $pphpasal->create($request->all());
        $data = [
            'tahun_pajak' => $request->tahun_pajak,
            'masa_pajak' => $request->masa_pajak,
            'nama' => $request->nama,
            'identitas' => $request->identitas,
            'no_identitas' => $request->no_identitas,
            'qq' => $request->qq,
            'kode_objek_pajak' => $request->kode_objek_pajak,
            'jenis_pajak' => '4111'.explode("-",$request->kode_objek_pajak)[0],
            'jenis_setoran' => explode("-",$request->kode_objek_pajak)[1],
            'fasilitas_pajak_penghasilan' => $request->fasilitas_pajak_penghasilan,
            'no_fasilitas' => $this->getNoFasilitas($request),
            'jumlah_penghasilan_bruto' => $request->jumlah_penghasilan_bruto,
            'tarif' => $request->tarif,
            'jumlah_setor' => $request->jumlah_setor,
            'pengaturan_id' => $request->pengaturan_id,
            'tipe' => 'pphpasal',
            'user_id' => $user_id,
            'no_bukti' => date('Ymd', time()) . str_pad(((int)$hitung_data_hari_ini += 1), 6, '0', STR_PAD_LEFT),
            // 'no_bukti' => '2',
            'status' => 'belum posting',
        ];

        // return response()->json($data,403);
        $pphpasal = new PajakPenghasilan();
        $pphpasal->create($data);



        $pphpasal = PajakPenghasilan::latest()->first();
        $dokumen = [
            'pajak_penghasilan_id' => $pphpasal->id,
            'nama_dokumen' => $request->nama_dokumen,
            'no_dokumen' => $request->no_dokumen,
            'tgl_dokumen' => $request->tgl_dokumen,
        ];
        // return response()->json([$pphnon,$dokumen]);    

        $dokumen_pph = new DokumenPphPasal();
        $dokumen_pph->create($dokumen);
        return response()->json('sukses');
    }

    public function update_posting(Request $request, $user_id){
        $pajak_penghasilan= PajakPenghasilan::where(['tahun_pajak' => $request->tahun_pajak, 'user_id' => $user_id, 'masa_pajak' => $request->masa_pajak])->update(['status'=>'sudah posting']);
        
        return response()->json('berhasil', 200);
    }

    public function getNoFasilitas(Request $request)
    {
        $tmp = null;
        if ($request->skb) {
            $tmp = $request->skb;
        }
        if ($request->dt) {
            $tmp = $request->dt;
        }
        if ($request->suket) {
            $tmp = $request->suket;
        }
        if ($request->lainnya) {
            $tmp = $request->lainnya;
        }
        return $tmp;
    }

    public function hapus_dokumen($id)
    {
        $dokumen_pph = DokumenPphPasal::find($id);
        $dokumen_pph->delete();
        return response()->json('sukses');
    }

    public function hapus_pphpasal($id)
    {
        $pphpasal = PajakPenghasilan::find($id);
        $pphpasal->delete();
        return response()->json('sukses');
    }

    public function get_pphpasal($userid)
    {
        $data = PajakPenghasilan::with(['objek_pajak'])->where(['tipe' => 'pphpasal', 'user_id' => $userid ])->get();
        return response()->json($data, 200);
    }

    public function proses_edit_pphpasal(Request $request, $id)
    {
        try {
            //code...
            $pajak_penghasilan = PajakPenghasilan::find($id);
            $pajak_penghasilan->tahun_pajak = $request->tahun_pajak;
            $pajak_penghasilan->masa_pajak = $request->masa_pajak;
            $pajak_penghasilan->nama = $request->nama;
            $pajak_penghasilan->identitas = $request->identitas;
            $pajak_penghasilan->no_identitas = $request->no_identitas;
            $pajak_penghasilan->qq = $request->qq;
            $pajak_penghasilan->kode_objek_pajak = $request->kode_objek_pajak;
            $pajak_penghasilan->fasilitas_pajak_penghasilan = $request->fasilitas_pajak_penghasilan;
            $pajak_penghasilan->no_fasilitas = $request->no_fasilitas;
            $pajak_penghasilan->jumlah_penghasilan_bruto = $request->jumlah_penghasilan_bruto;
            $pajak_penghasilan->tarif = $request->tarif;
            $pajak_penghasilan->jumlah_setor = $request->jumlah_setor;
            $pajak_penghasilan->pengaturan_id = $request->pengaturan_id;
            $pajak_penghasilan->save();
            DokumenPphPasal::where('pajak_penghasilan_id', $pajak_penghasilan->id)->update([
           'nama_dokumen' => $request->nama_dokumen,
           'tgl_dokumen' => $request->tgl_dokumen
        ]);
            // $dokumen_pph->save();
            return response()->json($pajak_penghasilan, 200);
        } catch (Exception $e) {
            //throw $th;
            return response()->json($e->getMessage(), 403);
        }
    }

    //pph non--------------------------------------------------

    public function get_pphnon($userid)
    {
        $data = PajakPenghasilan::where(['tipe' => 'pphnon' , 'user_id' => $userid ])->get();
        return response()->json($data, 200);
    }
    
    public function proses_tambah_pphnon(Request $request, $user_id)
    {
        //  dd($request->all());

        $hitung_data_hari_ini = PajakPenghasilan::select("pajak_penghasilan.id")
            ->join('dokumen_pphnon', 'pajak_penghasilan.id', '=', 'dokumen_pphnon.pajak_penghasilan_id')
            ->where('tgl_dokumen', date('d-m-Y', time()))
            ->get()->count();

        // $pph_nonresiden= new PphNon();
        // $pph_nonresiden->create($request->all());
        $no_fasilitas = 0;
        if (isset($request->skd)) {
            $no_fasilitas = $request->skd;
        }
        if (isset($request->skd)) {
            $no_fasilitas = $request->dtp;
        }
        if (isset($request->skd)) {
            $no_fasilitas = $request->lainnya;
        }
        $data = [
            'pengaturan_id' => $request->pengaturan_id,
            'tahun_pajak' => $request->tahun_pajak,
            'masa_pajak' => $request->masa_pajak,
            'tin' => $request->tin,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'negara' => $request->negara,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'no_paspor' => $request->no_paspor,
            'no_kitas' => $request->no_kitas,
            'kode_objek_pajak' => $request->kode_objek_pajak,
            'jenis_pajak' => '4111'.explode("-",$request->kode_objek_pajak)[0],
            'jenis_setoran' => explode("-",$request->kode_objek_pajak)[1],
            'fasilitas_pajak_penghasilan' => $request->fasilitas_pajak_penghasilan,
            'no_fasilitas' => $no_fasilitas,
            'jumlah_penghasilan_bruto' => $request->jumlah_penghasilan_bruto,
            'netto' => $request->netto,
            'tarif' => $request->tarif,
            'user_id' => $user_id,
            'jumlah_setor' => $request->jumlah_setor,
            'tipe' => 'pphnon',
            'no_bukti' => date('Ymd', time()) . str_pad(((int)$hitung_data_hari_ini += 1), 6, '0', STR_PAD_LEFT),
            // 'no_bukti' => '2',
            'status' => 'belum posting',
            'kelebihan_pemotongan' => $request->kelebihan_pemotongan,
            'pernyataan' => $request->pernyataan

        ];
        $pph_nonresiden = new PajakPenghasilan();
        $pph_nonresiden->create($data);
        $pph_nonresiden = PajakPenghasilan::latest()->first();
        $dokumen = [
            'pajak_penghasilan_id' => $pph_nonresiden->id,
            'nama_dokumen' => $request->nama_dokumen,
            'no_dokumen' => $request->no_dokumen,
            'tgl_dokumen' => $request->tgl_dokumen,
        ];
        $dokumen_pphnon = new DokumenPphNon();
        $dokumen_pphnon->create($dokumen);
        return response()->json('sukses');
    }

    public function getNoFasilitasNon(Request $request)
    {
        $tmp = null;
        if ($request->skdwpln) {
            $tmp = $request->skdwpln;
        }
        if ($request->dtp) {
            $tmp = $request->dtp;
        }
        if ($request->lainnya) {
            $tmp = $request->lainnya;
        }
        return $tmp;
    }

    public function hapus_pphnon($id)
    {
        $pph_nonresiden = PajakPenghasilan::find($id);
        $pph_nonresiden->delete();
        return response()->json('sukses');
    }

    public function proses_edit_pphnon(Request $request, $id)
    {
        try {
            //code...
            $pajak_penghasilan = PajakPenghasilan::find($id);
            $pajak_penghasilan->tahun_pajak = $request->tahun_pajak;
            $pajak_penghasilan->pengaturan_id = $request->pengaturan_id;
            $pajak_penghasilan->tahun_pajak = $request->tahun_pajak;
            $pajak_penghasilan->masa_pajak = $request->masa_pajak;
            $pajak_penghasilan->tin = $request->tin;
            $pajak_penghasilan->nama = $request->nama;
            $pajak_penghasilan->alamat = $request->alamat;
            $pajak_penghasilan->negara = $request->negara;
            $pajak_penghasilan->tempat_lahir = $request->tempat_lahir;
            $pajak_penghasilan->tgl_lahir = $request->tgl_lahir;
            $pajak_penghasilan->no_paspor = $request->no_paspor;
            $pajak_penghasilan->no_kitas = $request->no_kitas;
            $pajak_penghasilan->kode_objek_pajak = $request->kode_objek_pajak;
            $pajak_penghasilan->fasilitas_pajak_penghasilan = $request->fasilitas_pajak_penghasilan;
            $pajak_penghasilan->jumlah_penghasilan_bruto = $request->jumlah_penghasilan_bruto;
            $pajak_penghasilan->netto = $request->netto;
            $pajak_penghasilan->tarif = $request->tarif;
            $pajak_penghasilan->jumlah_setor = $request->jumlah_setor;
            $pajak_penghasilan->kelebihan_pemotongan = $request->kelebihan_pemotongan;
            $pajak_penghasilan->pernyataan = $request->pernyataan;
            $pajak_penghasilan->save();
            DokumenPphNon::where('pajak_penghasilan_id', $pajak_penghasilan->id)->update([
           'nama_dokumen' => $request->nama_dokumen,
           'tgl_dokumen' => $request->tgl_dokumen
        ]);
            // $dokumen_pph->save();
            return response()->json($pajak_penghasilan, 200);
        } catch (Exception $e) {
            //throw $th;
            return response()->json($e->getMessage(), 403);
        }
    }

    // Impordata
    public function importdata(Request $request)
    {
        $datas = [
            'tipe' => 'importdata'
        ];
        $pajak_penghasilan = PajakPenghasilan::create($datas);;
        $pajak_penghasilan->save();

        $data = $request->file('file');

        // $file = $request->file('file')->store('file');
        // return response()->json(storage_path('/app/' . $file),200);
        $import_data = new ImportData();
        $import_data->nama_file = $request->file('file')->getClientOriginalName();
        $import_data->ket_up = 'berhasil';
        $import_data->pajak_penghasilan_id = $pajak_penghasilan->id;
        $import_data->save();
        Excel::import(new DataDetailImport, $request->file('file'));

        // return redirect()->back();
        // $uniqueFileName = uniqid() . $request->get('uploadfile')->getClientOriginalName() . '.' . $request->get('uploadfile')->getClientOriginalExtension();

        // $request->get('uploadfile')->move(public_path('files') . $uniqueFileName);
        //dd($request);
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function hapus_importdata($id)
    {
        $import_data = ImportData::find($id);
        $import_data->delete();
        return response()->json('sukses');
    }
}
    
    // //posting-------------------------------------------------------------
    // public function get_posting(){
    //     $data = Posting::get();
    //     return response()->json($data,200);
    // }

    