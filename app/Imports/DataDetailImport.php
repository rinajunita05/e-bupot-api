<?php

namespace App\Imports;

use App\Models\ImportData;
use App\Models\ImportDataDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DataDetailImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $last_import_data = ImportData::latest()->first();
        return new ImportDataDetail([
            "import_data_id" => $last_import_data->id,
            "tgl_pemotongan" => $row [1] ?? '',
            "penerima_penghasilan" => $row [2] ?? '',
            "npwp" => $row[3] ?? '',
            "nik" => $row[4] ?? '',
            "nama_penerima"=> $row[5] ?? '',
            "qq" => $row[6] ?? '',
            "no_hp" => $row[7] ?? '',
            "kode_objek_pajak" => $row[8] ?? '',
            "penandatangan_bp" => $row[9] ?? '',
            "penandatangan_menggunakan" => $row[10] ?? '',
            "npwp_penandatangan" => $row[11] ?? '',
            "nik_penandatangan" => $row[12] ?? '',
            "namapenandatangan_sesuai_nik" => $row[13] ?? '',
            "penghasilan_bruto" => $row[14] ?? '',
            "fasilitas" => $row[15] ?? '',
            "no_skb" => $row[16] ?? '',
            "no_aturandtp" => $row[17] ?? '',
            "no_suketpp23" => $row[18] ?? '',
            "fasilitaspph_lainnya" => $row[19] ?? '',
            "tarifpph_berfaspph_lainnya" => $row[20] ?? '',
            "lb_diproses" => $row[21] ?? ''


            
        ]);
    }
    public function startRow(): int
    {
        return 3;
    }
}
