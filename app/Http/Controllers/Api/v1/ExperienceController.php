<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::all();
        return response()->json(new DataResource(true, 'Seluruh data experience berhasil diambil', $experiences));
    }

    public function show($id)
    {
        $experience = Experience::find($id);
        if ($experience) {
            return response()->json(new DataResource(true, 'Data experience berhasil diambil', $experience));
        } else {
            return response()->json(new DataResource(false, 'Data experience tidak ditemukan', null), 404);
        }
    }
}
