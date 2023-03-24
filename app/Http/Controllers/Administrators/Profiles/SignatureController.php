<?php

namespace App\Http\Controllers\Administrators\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Contracts\Repository\UserRepositoryInterface;

use Lang;

class SignatureController extends Controller
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

        return view('administrators/profiles/signatures/edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'signature' => 'required|mimes:jpg,jpeg,png|max:1048',
        ]);

        $user = $this->userRepository->findOrFail($id);
      
        // signature_userid.ext
        $signature = $request->file('signature');
        $ext = $signature->guessExtension();
        $signature_name = "signature_$user->id.$ext";

        $user->signature = $signature_name;
        $user->saveOrFail();

        Storage::disk('public')->put("signatures/$signature_name",  File::get($signature));
        
        return redirect()->back()->with('user', $user)->with('success', [Lang::get('profiles.signature_upload_successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $user = $this->userRepository->findOrFail($id);

        if (! $this->userRepository->update(['signature' => null], $id))
        {
            return redirect()->back()->with('success', [Lang::get('forms.failed_transaction')]);
        }

        Storage::disk('public')->delete('signatures/'.$user->signature);

        return redirect()->back()->with('user', $user)->with('success', [Lang::get('profiles.signature_upload_successfully')]);
    }
}
