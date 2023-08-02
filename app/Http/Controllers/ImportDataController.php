<?php

namespace App\Http\Controllers;

use App\Models\ImportDataDetail;
use Illuminate\Http\Request;

class ImportDataController extends Controller
{
    // public function get_detail_importdata (Request $request,$userid) {
            
    //     $detaildataimport= ImportDataDetail::join('import_data', 'import_data_details.import_data_id', '=', 'import_data.id')->where('import_data.user_id',$userid)->get();
    //     return response()->json($detaildataimport,200);

    // }
}
