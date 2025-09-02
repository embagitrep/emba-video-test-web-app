<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\SmsLog;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class SmsLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SmsLog::query();
        $query->with('merchant');

        $output = [];
        $output['merchants'] = selectOptionArrGeneratorByKey(Merchant::select('id', 'name')->orderBy('name')->pluck('name', 'id')->toArray());
        $output['selectedMerchant'] = null;

        $filters = $request->get('filters');

        if (!empty($filters['merchant_id'])) {
            $output['selectedMerchant'] = $filters['merchant_id'];

            $query->where('merchant_id', $output['selectedMerchant']);
        }

        $dataProvider = new EloquentDataProvider($query);
        $output['dataProvider'] = $dataProvider;


        return view('cp.sms.index', $output);
    }
}
