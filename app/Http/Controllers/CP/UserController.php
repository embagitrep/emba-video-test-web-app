<?php

namespace App\Http\Controllers\CP;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CP\User\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class UserController extends Controller
{
    public function __construct(protected User $post, protected RoleService $roleService)
    {
        $this->post = $post;
    }

    public function add(Request $request)
    {

        $roles = $this->roleService->getRoleEnums();

        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'name' => 'required|min:5|max:50|',
                'username' => 'nullable|min:5|max:255|unique:users',
                'email' => 'required|email|min:5|max:255|unique:users',
                'phone' => 'nullable|digits:8',
                'password' => 'confirmed|min:6',
                'bank_id' => 'nullable|required_if:role,manager|exists:banks,id',
                'role' => 'required|in:'.implode(',', array_keys($roles)),
                'active' => 'nullable',
            ]);

            if ($request->file('image')) {

                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();

                $path = public_path('uploads/profiles/'.str_replace(' ', '', $validated['username']));

                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

                $image->move($path, $filename);
                $validated['image'] = $filename;
            }

            if ($request->password) {
                $validated['password'] = Hash::make($request->password);
            }

            $validated['active'] = isset($validated['active']);

            $user = User::create($validated);
            $user->assignRole($validated['role']);

            Session::flash('success', 'Successfully saved');

            return redirect()->route('user.edit', ['id' => $user->id]);
        }

        return view('cp.user.add', compact('roles'));
    }

    public function all(Request $request)
    {
        $query = User::query();
        $query->with('roles');

        if ($request->has('type')) {
            $type = $request->get('type');

            switch ($type) {
                case 'admin':
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', RoleEnum::ADMIN);
                    });
                    break;
                case 'manager':
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', RoleEnum::MANAGER);
                    });
                    break;
                case 'user':
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', RoleEnum::USER);
                    });
                    break;
            }
        }

        $dataProvider = new EloquentDataProvider($query);

        return view('cp.user.all', compact('dataProvider'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('success', 'Successfully deleted');

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $roles = $this->roleService->getRoleEnums();

        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'name' => 'required|min:5|max:50|',
                'username' => 'nullable|min:5|max:255|unique:users,username,'.$user->id,
                'email' => 'email|nullable|min:5|max:50|unique:users,email,'.$user->id,
                'phone' => 'nullable|digits:8',
                'password' => 'nullable|confirmed|min:6',
                'bank_id' => 'nullable|required_if:role,manager|exists:banks,id',
                'role' => 'required|in:'.implode(',', array_keys($roles)),
                'active' => 'nullable',
                'restricted' => 'nullable',
            ]);

            if ($request->password) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            if ($request->file('image')) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();

                $path = public_path('uploads/profiles/'.str_replace(' ', '', $validated['username']));

                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

                $image->move($path, $filename);
                $validated['image'] = $filename;
            }

            $validated['active'] = isset($validated['active']);
            $validated['restricted'] = isset($validated['restricted']);

            $user->update($validated);

            $user->assignRole($validated['role']);

            Session::flash('success', 'Successfully saved');

            return back();

        }

        return view('cp.user.edit', compact('user', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reset(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);
            $data = $request->all();
            if (Hash::check($data['old_password'], $user->password)) {
                $user->password = Hash::make($data['password']);
                $user->active = 1;
                if ($user->update()) {
                    Session::flash('success', 'Password successfully changed');

                    return back();
                }
            } else {
                Session::flash('error', 'Old password not matched');

                return back();
            }

        }

        return view('cp.auth.reset', compact('user'));
    }
}
