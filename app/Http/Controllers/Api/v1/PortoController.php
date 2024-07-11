<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortoResource;
use App\Models\Porto;
use Illuminate\Http\Request;

class PortoController extends Controller
{
    public function index()
    {
        $portos = Porto::paginate(6);
        return response()->json(new PortoResource(true, 'Seluruh data porto berhasil diambil', $portos));
    }

    public function show($id)
    {
        $porto = Porto::find($id);
        if ($porto) {
            return response()->json(new PortoResource(true, 'Data porto berhasil diambil', $porto));
        } else {
            return response()->json(new PortoResource(false, 'Data porto tidak ditemukan', null), 404);
        }
    }
}
