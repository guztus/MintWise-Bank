<?php

namespace App\Http\Controllers;

class AssetController extends Controller
{
    public function index()
    {
        return view('asset.index', [
            'assets' => auth()->user()->assets
        ]);
    }
}
