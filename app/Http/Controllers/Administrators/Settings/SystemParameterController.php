<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\SystemParameterRepositoryInterface;

use Lang;
use Session;

class SystemParameterController extends Controller
{
    /** @var \App\Contracts\Repository\SystemParameterRepositoryInterface */
    private $systemParameterRepository;

    public function __construct(SystemParameterRepositoryInterface $systemParameterRepository) 
    {
        $this->systemParameterRepository = $systemParameterRepository;
    }

    public function edit(Request $request)
    {
        $request->validate([
            'category' => 'required|string'
        ]);

        $system_parameters = $this->systemParameterRepository->findByCategory($request->category);
        
        return view('administrators.settings.system_parameters.edit')
            ->with('category', $request->category)
            ->with('system_parameters', $system_parameters);
    }

    public function update(Request $request) 
    {
        $system_parameters = $request->except(['_token', '_method']);
        
        DB::transaction(function () use ($system_parameters) {

            foreach ($system_parameters as $system_parameter_name => $system_parameter_value) 
            {
                $this->systemParameterRepository->updateParameterByKey($system_parameter_name, ['value' => $system_parameter_value]);
            }
        });

        Session::flash('success', [Lang::get('system_parameters.success_update_message')]);

        return redirect()->back();
    }
}
