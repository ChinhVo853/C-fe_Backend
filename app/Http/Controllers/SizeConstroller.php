<?php

namespace App\Http\Controllers;

use App\Services\SizeServices;
use Illuminate\Http\Request;

class SizeConstroller extends Controller
{
    protected $sizeServices;
    public function __construct(SizeServices $sizeServices)
    {
        $this->sizeServices = $sizeServices;
    }

    public function Them(Request $request)
    {
        $this->sizeServices->ThemSize($request->size);
        return response([
            'message' => "thành công",
        ]);
    }
}
