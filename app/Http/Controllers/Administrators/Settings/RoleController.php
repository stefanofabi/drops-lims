<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\RoleRepositoryInterface;
use App\Contracts\Repository\PermissionRepositoryInterface;

use Session;
use Lang;

class RoleController extends Controller
{

    /** @var \App\Contracts\Repository\RoleRepositoryInterface */
    private $roleRepository;

    /** @var \App\Contracts\Repository\PermissionRepositoryInterface */
    private $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $roles = $this->roleRepository->all();

        return view('administrators.settings.roles.index')
        ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $permissions = $this->permissionRepository->all();
        
        return view('administrators.settings.roles.create')
            ->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
        ]);

        if (! $this->roleRepository->create($request->all())) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('roles.roles_created_successfully')]);
  
        return redirect()->action([RoleController::class, 'index']);
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

        $role = $this->roleRepository->findOrFail($id);

        return view('administrators.settings.roles.edit')->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $id) {
            $this->roleRepository->update($request->all(), $id);

            // revoke all permissions & add new permissions
            $this->roleRepository->syncPermissions($request->permissions, $id);
        });

        return redirect()->action([RoleController::class, 'edit'], ['id' => $id]);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        if (! $this->roleRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        Session::flash('success', [Lang::get('roles.roles_deleted_successfully')]);
      
        return redirect()->action([RoleController::class, 'index']);
    }
}
