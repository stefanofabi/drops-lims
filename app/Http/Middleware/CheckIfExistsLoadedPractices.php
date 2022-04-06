<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use Lang;

class CheckIfExistsLoadedPractices
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    public function __construct (ProtocolRepositoryInterface $protocolRepository)
    {
        $this->protocolRepository = $protocolRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $protocol = $this->protocolRepository->findOrFail($request->id);

        if ($protocol->practices->isEmpty())
        {
            return redirect()->back()->withErrors(Lang::get('protocols.not_loaded_practices'));
        }

        return $next($request);
    }
}
