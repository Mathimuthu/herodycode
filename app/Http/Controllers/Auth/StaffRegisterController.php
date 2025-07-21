<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StaffRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('staff.auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $staff = $this->create($request->all());

        Auth::guard('staff')->login($staff);

        return redirect()->route('staff.login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return Staff::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}


