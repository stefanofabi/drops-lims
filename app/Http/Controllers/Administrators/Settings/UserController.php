<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Repository\RoleRepositoryInterface;

use App\Mail\WelcomeEmail;

use Lang;
use Exception;
use Session;

class UserController extends Controller
{
    /** @var \App\Contracts\Repository\UserRepositoryInterface */
    private $userRepository;

    /** @var \App\Contracts\Repository\RoleRepositoryInterface */
    private $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $users = $this->userRepository->all();

        return view('administrators.settings.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $roles = $this->roleRepository->all();

        return view('administrators.settings.users.create')
            ->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        DB::beginTransaction();
        try {
            $new_password = Str::password();
            $user_data = array_merge($request->all(), ['password' => Hash::make($new_password)]);

            $user = $this->userRepository->create($user_data);
            $role = $this->roleRepository->findOrFail($request->role);
            $this->userRepository->syncRoles($role->name, $user->id);
            
            DB::commit();

            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (Exception $e) {
            DB::rollback();
            
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([UserController::class, 'edit'], ['id' => $user->id]);
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

        $roles = $this->roleRepository->all();

        return view('administrators.settings.users.edit')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        DB::beginTransaction();
        try {
            $this->userRepository->update($request->all(), $id);

            $this->userRepository->syncRoles($request->role, $id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([UserController::class, 'edit'], ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        if (! $this->userRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('users.success_destroy_message')]);

        return redirect()->action([UserController::class, 'index'], ['page' => 1]);
    }
}
