<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function create()
    {
        $presets = glob(base_path() . '/resources/presets/*' , GLOB_ONLYDIR);
        return view('domain.create', [
            'presets' => $presets
        ]);
    }

    public function handle(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'domain' => 'required',
            'type' => 'numeric',
            'preset' => 'nullable|string'

        ]);
        $job = Artisan::call('windows:domain', [
            'name' => $request->input('domain'),
            '--preset=' => $request->input('preset'),
            '--type=' => $request->input('type')
        ]);
        return redirect()->route('create');
    }
}
