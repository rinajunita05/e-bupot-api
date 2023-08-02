<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;
use App\Models\User;
class PengController extends Controller
{
    //
    public function get_pengaturan($id){
        $data = Pengaturan::with(['user'])->filter(request(['pilihsebagai','status']))->where('user_id', $id)->get();
        return response()->json($data,200);
    }
    public function ganti_status_peng($id){
        $pengaturan= Pengaturan::find($id);
        $pengaturan->status = $pengaturan->status ? 0 : 1;
        $pengaturan->save(); 
        return response()->json('sukses'); 
    }
        
    public function proses_tambah_pengaturan(Request $request, $id){
        if($request->identitas == 'npwp'){
            $data = [
                'bertindak_sebagai' => $request->bertindak_sebagai,
                'identitas' => $request->identitas,
                'status' => $request->status ?? 0,
                'npwp' => $request->npwp ?? 0,
                'nama' => $request->nama ?? 0,
                'user_id' => $id            
            ];
        }
        else{
            $data = [
                'bertindak_sebagai' => $request->bertindak_sebagai,
                'identitas' => $request->identitas,
                'status' => $request->status ?? 0,
                'nik' => $request->npwp ?? 0,
                'nama' => $request->nama ?? 0,
                'user_id' => $id            
            ];
        }
        //dd($request->all());
        $pengaturan= new Pengaturan();
        $pengaturan->create($data);
        return response()->json('sukses');    
    } 
    
    public function cek_nik(Request $request){
        $data = User::where('nik',$request->nik)->get();
        if($data->count() > 0){
            return response()->json($data,200);
            }
            return response()->json('Nik tidak valid',403);
        
    }

    public function authkey()
    {
        $data = [
            'npwp' => auth()->user()->npwp,
            'nama' => auth()->user()->name
        ];
        return view('authkey',$data);
    } 
}
