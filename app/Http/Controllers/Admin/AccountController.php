<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AccountService;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class AccountController extends Controller
{
    private $service;
    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'users' => $this->service->getList($search, false, 'is_admin DESC'),
            'search' => $search,
        ];
        return view('admin.account.index', $data);
    }

    public function input(Request $request)
    {
        return view('admin.account.register');
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'is_admin' => ['required'],
            ]);
            if ($validator->fails()) {
                session()->flash('error', 'validate invalid');
                return redirect()->route('register')->withErrors($validator)->withInput();
            }
            User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'is_admin' => $data['is_admin'],
            ]);
            return redirect()->route('users');
        } catch (Exception $e) {
            session()->flash('error', 'Internal server error');
            return redirect()->route('register')->withInput();
        }
    }

    public function delete(Request $request, $id)
    {
        //delete user
        try {
            DB::beginTransaction();
            $user = User::where('id', $id)->first();
            if (empty($user)) {
                session()->flash('error', 'Not have this account.');
                return redirect()->route('users');
            }
            $user_name = data_get($user, 'name');
            $user->delete();
            DB::commit();
            session()->flash('success', 'Delete account "'.$user_name.'" success.');
            return redirect()->route('users');
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            session()->flash('error', 'Delete fail! Internal server error.');
            return redirect()->route('users');
        }
    }

    public function changePass(Request $request, $id)
    {
        //show form edit pass
        return view('admin.account.change-pass', ['id' => $id]);
    }

    public function updatePass(Request $request, $id)
    {
        //update password
        try {
            $data = $request->all();
            $password = data_get($data, 'password');
            $validator = Validator::make($data, [
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            if ($validator->fails()) {
                session()->flash('error', 'validate invalid');
                return redirect()->route('user.change_pass', $id)->withErrors($validator)->withInput();
            }
            $user = User::where('id', $id)->first();
            if (empty($user)) {
                session()->flash('error', 'Not have this account.');
                return redirect()->route('users');
            }
            $user_name = data_get($user, 'name');
            $newPass = Hash::make($password);
            $user->update(['password' => $newPass]);
            session()->flash('success', 'Update password account "'.$user_name.'" success.');
            return redirect()->route('users');
        } catch (Exception $e) {
            session()->flash('error', 'Internal server error');
            return redirect()->route('user.change_pass', $id)->withInput();
        }
    }
}