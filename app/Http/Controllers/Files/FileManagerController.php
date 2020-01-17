<?php


namespace App\Http\Controllers\Files;


use App\Classes\File\Directory;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function index($domain, Request $request)
    {
        $domain = Domain::where('domain', $domain)->firstOrFail();

        $path = $request->query('path') ?? '/';
        $files = [];
        if ($path && $path !== '/') {
            $files = new Directory($domain->root . "/{$path}");
        } else {
            $files = new Directory($domain->root);
        }

        if ($files->files === null) return abort(404);

        return view('domain.files.index', [
            'domain' => $domain,
            'files' => $files,
            'path' => $path
        ]);
    }

    public function edit($domain, Request $request)
    {
        $domain = Domain::where('domain', $domain)->firstOrFail();
        if (!$request->has('file') || !$request->has('path')) return abort(404);
        $path = $request->query('path');
        $file = $request->query('file');
        $pathToFile = $domain->root . $path . '/' . $file;

        if (!file_exists($pathToFile)) return abort(404);

        return view('domain.files.edit', [
            'domain' => $domain,
            'file' => [
                'name' => $file,
                'content' => file_get_contents($pathToFile)
            ],
            'path' => $path,
        ]);
    }
}
