<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $dataProvider = new EloquentDataProvider(Merchant::query());

        return view('cp.merchant.index', compact('dataProvider'));
    }

    public function add()
    {
        $output = [];
//        $output['providerOpt'] = selectOptionHtmlArrGeneratorByKey(ProviderEnum::toArray());
        return view('cp.merchant.add', $output);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'api_key' => 'required|string|min:5|max:255',
            'api_username' => 'required|string|min:5|max:255|unique:merchants,api_username',
        ]);

        $slug = Str::slug($data['name']);

        if (Merchant::where('slug', $slug)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Vendor with this name already exists.']);
        }

        $logo = $request->file('logo');
        $filename = Str::random(9).'-'.time().'.'.$logo->getClientOriginalExtension();

        $path = public_path('uploads/');

        $logo->move($path, $filename);
        $data['logo'] = $filename;
        $data['slug'] = $slug;

        $merchant = Merchant::create($data);

        return redirect()->route('admin.merchant.edit', ['merchant' => $merchant->id]);
    }

    public function edit(Merchant $merchant)
    {
        $output = [];
        $output['model'] = $merchant;

        return view('cp.merchant.edit', $output);
    }

    public function update(Request $request, Merchant $merchant)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'api_key' => 'nullable|string|min:5|max:255',
            'api_username' => 'nullable|string|min:5|max:255|unique:merchants,api_username,'.$merchant->id,
        ]);

        $slug = Str::slug($data['name']);

        if (Merchant::where('slug', $slug)->where('id','!=',$merchant->id)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Vendor with this name already exists.']);
        }

        if ($request->logo) {
            $logo = $request->file('logo');
            $filename = Str::random(9) . '-' . time() . '.' . $logo->getClientOriginalExtension();
            $path = public_path('uploads/');
            $logo->move($path, $filename);
            $data['logo'] = $filename;
        }

        if (!$request->api_endpoint) unset($data['api_endpoint']);
        if (!$request->api_key) unset($data['api_key']);

        $data['slug'] = $slug;
        $merchant->update($data);

        session()->flash('success', 'Successfully saved');
        return back();
    }
}
