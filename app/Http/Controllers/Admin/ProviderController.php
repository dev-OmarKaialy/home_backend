<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = User::paginate(10);
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(ProviderRequest $request)
    {
        $data = $request->validated();
        $data['type'] = 'provider';

        // تشفير كلمة المرور لو أرسلت جديدة
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $provider = User::create($data);

        // رفع الصورة باستخدام Media Library
        if ($request->hasFile('profile_photo_path')) {
            $provider->addMediaFromRequest('profile_photo_path')
                ->toMediaCollection('profile_photo');
        }

        return redirect()->route('providers.show', $provider->id)
            ->with('success', 'Provider created successfully');
    }

    public function show($id)
    {
        $provider = User::where('type', 'provider')->findOrFail($id);
        return view('providers.show', compact('provider'));
    }

    public function edit($id)
    {
        $provider = User::where('type', 'provider')->findOrFail($id);
        return view('providers.edit', compact('provider'));
    }

    public function update(ProviderRequest $request, $id)
    {
        $provider = User::where('type', 'provider')->findOrFail($id);

        $data = $request->validated();

        // تحديث كلمة المرور فقط إذا أُرسلت
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $provider->update($data);

        // تحديث الصورة
        if ($request->hasFile('profile_photo_path')) {
            $provider->clearMediaCollection('profile_photo');
            $provider->addMediaFromRequest('profile_photo_path')
                ->toMediaCollection('profile_photo');
        }

        return redirect()->route('providers.index')->with('success', 'Provider updated successfully');
    }

    public function destroy($id)
    {
        $provider = User::where('type', 'provider')->findOrFail($id);

        $provider->clearMediaCollection('profile_photo');
        $provider->delete();

        return redirect()->route('providers.index')->with('success', 'Provider deleted successfully');
    }
}
