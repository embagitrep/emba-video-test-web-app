<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class TranslationController extends Controller
{
    private $post;

    public function __construct(Translation $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        $dataProvider = new EloquentDataProvider(Translation::query());

        return view('cp.translation.index', compact('dataProvider'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $translation = Translation::findOrfail($id);
        $languages = locales();

        if ($request->isMethod('post')) {
            $message = Message::where('translation_id', $translation->id)->where('lang', $request->lang)->first();
            if (isset($message)) {

                $message->value = $request->value;
                $message->update();
            } else {
                $message = new Message;
                $message->translation_id = $translation->id;
                $message->lang = $request->lang;
                $message->value = $request->value;
                $message->save();
            }
            Session::flash('success', 'Successfully updated');

            return back();
        }

        return view('cp.translation.edit', compact('translation', 'languages'));
    }

    public function add() {}
}
