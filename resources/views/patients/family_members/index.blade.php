@extends('patients/default-template')

@section('title')
{{ trans('family_members.family_members') }}
@endsection

@section('active_family_members', 'active')

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
	    <li class="nav-item">
			<a class="nav-link" href="{{ route('patients/family_members/create') }}"> {{ trans('family_members.add_family_member') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-users"></i> {{ trans('family_members.family_members') }}
@endsection

@section('content-message')
{{ trans('family_members.related_patients') }}
@endsection

@section('content')
<div class="mt-3">
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th> {{ trans('patients.patient') }} </th>
                <th> {{ trans('patients.bonding_date') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }} </th>
            </tr>

            @forelse ($family_members as $family_member)
            <tr>
                <td> {{ $family_member->internalPatient->last_name }} {{ $family_member->internalPatient->name }} </td>
                <td> {{ date('d/m/Y', strtotime($family_member->created_at)) }} </td>

                <td class="text-end">
                    <a target="_blank" href="#" class="btn btn-primary btn-sm" title="{{ trans('protocols.print_report') }}"> <i class="fas fa-trash fa-sm"></i> </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">
                    {{ trans('forms.no_results') }}
                </td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
@endsection