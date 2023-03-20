<?php

namespace App\Http\Middleware\Administrators\Settings\Roles;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Contracts\Repository\RoleRepositoryInterface;

use Lang;

class CheckSelfSabotage
{
    /** @var \App\Contracts\Repository\RoleRepositoryInterface */
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $this->roleRepository->findOrFail($request->id);
        $user_roles = auth()->user()->getRoleNames();

        // If you are modifying your own role, you should have these privileges to a minimum so as not to sabotage yourself
        if ($user_roles->contains($role->name)) 
        {
            if (! in_array('is lab staff', $request->permissions) || ! in_array('manage settings', $request->permissions) || ! in_array('manage roles', $request->permissions)) 
            {
                return redirect()->back()->withErrors(Lang::get('roles.minium_permissions'));
            }
        }

        return $next($request);
    }
}
