<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Profile extends Component
{
    public $state;
    public $password;
    public $password_confirmation;
    public $is_password = false;

    public function mount()
    {
        $this->state = Auth::user()->toArray();
    }

    public function render()
    {
        return view('livewire.profile');
    }

    public function saveData() {
        $user_id = Auth::id();
        $rules = [
            'state.name' => "required",
            'state.email' => "required|email|unique:users,email,$user_id",
            'password' => "nullable|required_if:is_password,true|min:8|max:15|confirmed",
            'password_confirmation' => "required_with:password",
        ];

        $this->validate($rules, ['state.name' => "Name is required", 'state.email' => "Email is required"]);

        $user = Auth::user();
        $user->name = $this->state['name'];
        $user->email = $this->state['email'];
        if($this->is_password) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        Session::flash('message.level', 'success');
        Session::flash('message.content', 'Profile updated successfully.');

        return redirect()->route('admin.profile');
    }
}
