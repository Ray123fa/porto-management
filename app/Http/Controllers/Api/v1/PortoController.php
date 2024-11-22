<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Porto;
use Illuminate\Http\Request;

class PortoController extends Controller
{
    public function index()
    {
        $portos = Porto::paginate(6);
        return response()->json(new DataResource(true, 'Seluruh data porto berhasil diambil', $portos));
    }

    public function show($id)
    {
        $porto = Porto::find($id);
        if ($porto) {
            return response()->json(new DataResource(true, 'Data porto berhasil diambil', $porto));
        } else {
            return response()->json(new DataResource(false, 'Data porto tidak ditemukan', null), 404);
        }
    }
}
