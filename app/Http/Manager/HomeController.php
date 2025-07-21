<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Manager;

class HomeController extends Controller
{
    public function loginr(){
        return view('manager.login');
    }
    public function register(){
        return view('manager.register');
    }
    public function create(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'team_id' => 'nullable',
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
        return redirect()->route('manager.login');
    }
    // public function login(Request $request){
    //     $this->validate($request,[
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);
    //     $user = Manager::where('username',$request->username)->first();
    //     if($user!=NULL){
    //         if(Hash::check($request->password, $user->password)){
    //             Auth::guard('manager')->login($user);
    //             return redirect()->route('manager.dashboard');
    //         }
    //         else{
    //             Session()->flash('error','Please enter a correct password');
    //             return redirect()->back();
    //         }
    //     }
    //     else{
    //         Session()->flash('error','Manager does not exist');
    //         return redirect()->back();
    //     }
    // }
   public function login(Request $request){
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Manager::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        // Force logout from other guards
        Auth::guard('web')->logout();      // user
        Auth::guard('employer')->logout(); // employer

        Auth::guard('manager')->login($user);

        return redirect()->route('manager.dashboard');
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}


    public function logout(){
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }
}
