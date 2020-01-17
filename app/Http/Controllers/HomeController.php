<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        $domains = Domain::all();

        return view('domain.index', [
            'domains' => $domains
        ]);
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
        $request->validate([
            'domain' => 'required',
            'type' => 'numeric',
            'preset' => 'nullable|string'

        ]);
        $options = [
            'name' => $request->input('domain'),
            '--type' => $request->input('type')
        ];

        if ($request->input('preset')) {
            $options['--preset'] = $request->input('preset');
        }

        if (!$request->input('nohost')) {
            $options['--no-host'] = true;
        }

        Artisan::call('windows:domain', $options);

        Domain::create([
            'root' => config('app.apache_root') . '/' . $request->input('domain'),
            'domain' => $request->input('domain'),
            'type' => $request->input('type')
        ]);

        return redirect()->route('create');
    }
}
