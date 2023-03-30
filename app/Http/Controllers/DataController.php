<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use App\Models\Data;

class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data():Renderable
    {
        $data = Data::where('user', Auth::id())->orderBy('id', 'desc')->get(['id', 'name'])->toArray();
        return view('data.data', [
            'data' => $data,
        ]);
    }

    public function add(Request $request):RedirectResponse
    {
        $data = new Data;
        $data->name = $request->get('name');
        $data->user = Auth::id();
        $data->value = '';
        $data->save();

        return redirect()->route('data');
    }

    public function delete(Request $request):RedirectResponse
    {
        $user = Auth::user();
        if ($user['dangerous_actions_key'] !== $request->get('dangerous_actions_key')) {
            return redirect()->route('data')->with('error', 'Error: Wrong dangerous action key.');
        }

        $data = Data
            ::where('id', $request->route('data_id'))
            ->where('user', Auth::id())
            ->limit(1);

        if ($data->count() === 0) {
            return redirect()->route('data')->with('error', 'Error: Data item not found.');
        }

        $data->delete();
        return redirect()->route('data')->with('status', 'Success: The data item was deleted.');
    }

    public function dataItem(Request $request):Renderable
    {
        $user = Auth::user();
        $data = Data
            ::where('id', $request->route('data_id'))
            ->where('user', Auth::id())
            ->limit(1)
            ->get(['id', 'name', 'value'])
            ->toArray()[0];

        return view('data.data_item', [
            'token' => $user->api_token,
            'dangerous_actions_key' => $user->dangerous_actions_key,
            'data' => $data,
        ]);
    }

    public function dataValueUpdate(Request $request):RedirectResponse
    {
        Data
            ::where('id', $request->route('data_id'))
            ->where('user', Auth::id())
            ->update(['value' => $request->get('value')]);

        return redirect()->route('data.item', $request->route('data_id'));
    }

}
