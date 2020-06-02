<?php

namespace Bishopm\Blog\Http\Controllers;

use Bishopm\Blog\Repositories\SettingsRepository;
use Bishopm\Blog\Models\Setting;
use Bishopm\Blog\Models\User;
use App\Http\Controllers\Controller;
use Bishopm\Blog\Http\Requests\CreateSettingRequest;
use Bishopm\Blog\Http\Requests\UpdateSettingRequest;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $setting;

    public function __construct(SettingsRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index($username)
    {
        $settings = $this->setting->all();
        foreach ($settings as $setting) {
            if ($setting->scope == 0) {
                $setting->scopename = "Global";
            } else {
                $setting->scopename = ucfirst(User::find($setting->scope)->name);
            }
        }
        return view('blog::settings.index', compact('settings', 'username'));
    }

    public function edit($username, Setting $setting)
    {
        $scopearray=array();
        $scopearray[]="Global";
        $users = User::orderBy('name')->get();
        foreach ($users as $user) {
            $scopearray[$user->id]=ucfirst($user->name);
        }
        return view('blog::settings.edit', compact('setting', 'scopearray', 'username'));
    }

    public function create($username)
    {
        $scopearray=array();
        $scopearray[]="Global";
        $users = User::orderBy('name')->get();
        foreach ($users as $user) {
            $scopearray[$user->id]=ucfirst($user->name);
        }
        return view('blog::settings.create', compact('scopearray', 'username'));
    }

    public function store($username, CreateSettingRequest $request)
    {
        $this->setting->create($request->all());

        return redirect()->route('settings.index', 'username')
            ->withSuccess('New setting added');
    }
    
    public function update($username, Setting $setting, UpdateSettingRequest $request)
    {
        $this->setting->update($setting, $request->all());
        return redirect()->route('settings.index', $username)->withSuccess('Setting has been updated');
    }
}
