<?php

namespace App\Http\Controllers\Administrators\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Contracts\Repository\UserRepositoryInterface;

use Lang;

class PasswordController extends Controller
{
    /** @var \App\Contracts\Repository\UserRepositoryInterface */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $user = $this->userRepository->findOrFail($id);

        return view('administrators.profiles.change_password.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $this->validate($request, [
            'current_password' => 'required|string|min:8',
        ]);

        $user = $this->userRepository->findOrFail($id);

        if (! Hash::check($request->get('current_password'), $user->password)) {
            // The passwords not matches
            return redirect()->back()->withErrors(Lang::get('auth.password_not_matches'));
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            // Current password and new password same
            return redirect()->back()->withErrors(Lang::get('auth.password_cannot_same_current_password'));
        }

        $validatedData = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $this->userRepository->update(['password' => Hash::make($request->get('new_password'))], $id);

        return redirect()->back()->with("success", [Lang::get('auth.password_sucessfully_changed')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
