<?php

namespace App\Http\Controllers;

use App\Models\Service;

class LayananController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view('layanan.index', compact('services'));
    }
}