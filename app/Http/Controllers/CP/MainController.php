<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class MainController extends Controller
{
    public function index()
    {
        return view('cp.index.index');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('modelCache:clear');
        session()->flash('success', 'Cache cleared');

        return back();
    }

    public function translationsToFile()
    {
        Artisan::call('app:db-translations-to-file ');
        session()->flash('success', 'Translations added');

        return back();
    }
}
