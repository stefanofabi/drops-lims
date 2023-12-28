<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\UserRepositoryInterface;

use Lang;

class BanController extends Controller
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

        $request->validate([
            'comment' => ['required', 'string']
        ]);

        if (! $ban = $this->userRepository->ban($request->all(), $request->id)) {
            return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
        }

        return response()->json($ban, 200);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Unban a user.
     */
    public function unban(string $user_id)
    {
        //
        
        $this->userRepository->unban($user_id);
    
        return redirect()->action([UserController::class, 'edit'], ['id' => $user_id]);
    }
}
