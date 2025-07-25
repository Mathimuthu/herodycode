<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index(){
        $managers = Manager::paginate(15);
        return view('admin.managers.index')->with([
            'managers' => $managers
        ]);
    }
    public function create(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'team_id' => 'required',
        ]);
        $manager = new Manager;
        $manager->name = $request->name;
        $manager->email = $request->email;
        $manager->username = $request->username;
        $manager->password = Hash::make($request->password);
        $manager->phone = $request->phone;
        $manager->team_id = $request->team_id;
        $manager->manager_id = "Manager_".$manager->id;
        $manager->save();
        $request->session()->flash('success', "Successfully Created");
        return redirect()->back();
    }
    public function delete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        Manager::find($request->id)->delete();
        $request->session()->flash('success', 'Deleted Successfully');
        return redirect()->back();
    }
    public function managerLogin(Request $request)
{
    $request->validate([
        'id' => 'required|exists:managers,id',
    ]);

    $manager = Manager::find($request->id);

    if (!$manager) {
        return redirect()->back()->with('error', 'Manager not found.');
    }

    // If already logged in, log out first
    if (Auth::guard('manager')->check()) {
        Auth::guard('manager')->logout();
    }

    Auth::guard('manager')->login($manager);
    return redirect()->route('manager.dashboard'); // Your manager dashboard route
}
}
