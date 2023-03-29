<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use App\Models\Apps;
use App\Models\Links;
use App\Models\Notifications;
use App\Models\CountryBlackList;
use App\Models\ProviderBlackList;
use App\Models\LanguageBlackList;
use App\Models\SimCarrierBlackList;
use App\Models\IsCapturedBlackList;
use App\Models\IsVpnBlackList;
use App\Models\IpBlackList;

class AppsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function apps():Renderable
    {
        $apps = Apps::where('user', Auth::id())->orderBy('id', 'desc')->get(['id', 'name'])->toArray();

        return view('app.apps', [
            'apps' => $apps,
        ]);
    }

    public function add(Request $request):RedirectResponse
    {
        $app = new Apps;
        $app->name = $request->get('name');
        $app->user = Auth::id();
        $app->save();

        return redirect()->route('dashboard.apps');
    }

    public function delete(Request $request):RedirectResponse
    {
        $user = Auth::user();
        if ($user['dangerous_actions_key'] !== $request->get('dangerous_actions_key')) {
            return redirect()->route('dashboard.apps')->with('error', 'Error: Wrong dangerous action key.');
        }

        $app = Apps
            ::where('id', $request->route('app_id'))
            ->where('user', Auth::id())
            ->limit(1);

        if ($app->count() === 0) {
            return redirect()->route('dashboard.apps')->with('error', 'Error: App not found.');
        }

        $app->delete();
        return redirect()->route('dashboard.apps')->with('status', 'Success: The App was deleted.');
    }

    public function app(Request $request):Renderable
    {
        $user = Auth::user();
        $app = Apps
            ::where('id', $request->route('app_id'))
            ->where('user', Auth::id())
            ->limit(1)
            ->get(['id', 'name'])
            ->toArray()[0];

        return view('app.app', [
            'token' => $user->api_token,
            'dangerous_actions_key' => $user->dangerous_actions_key,
            'app' => $app,
        ]);
    }

    public function statusUpdate(Request $request):RedirectResponse
    {
        Apps
            ::where('id', $request->route('app_id'))
            ->where('user', Auth::id())
            ->update(['status' => $request->get('status')]);

        return redirect()->route('dashboard.app', $request->route('app_id'));
    }

}
