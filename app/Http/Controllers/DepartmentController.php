<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facolta;
use App\Models\Corso;

class DepartmentController extends Controller
{
    public function facolta()
    {
        $facolta = Facolta::all();
        return response()->json($facolta);
    }

    public function corso()
    {
        $corso = Corso::all();
        return response()->json($corso);
    }
}
