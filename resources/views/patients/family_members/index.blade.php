@extends('patients/default-filter')

@section('title')
{{ trans('home.family_members') }}
@endsection

@section('active_family_members', 'active')

@section('main-title')
<i class="fas fa-users"></i> {{ trans('home.family_members') }}
@endsection

@section('create-href')
{{ route('patients/family_members/create') }}
@endsection

@section('create-text')
<span class="fas fa-user-plus" ></span> {{ trans('patients.add_family_member') }}
@endsection

@section('card-filters')
    <div class="mt-3 mb-3 ml-3"> {{ trans('patients.related_patients') }} </div>
@endsection

@section('results')

    @if (!sizeof($family_members))
        <div class="col-md-12"> {{ trans('forms.no_results') }}</div>
    @else

        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th> {{ trans('patients.patient') }} </th>
                    <th class="text-right"> {{ trans('forms.actions') }} </th>
                </tr>

                @foreach ($family_members as $family_member)
                    <tr>
                        <td> {{ $family_member->full_name }} </td>

                        <td class="text-right">
                            <a target="_blank" href="#" class="btn btn-info btn-sm" title="{{ trans('protocols.print_report') }}"> <i class="fas fa-trash fa-sm"></i> </a>
                        </td>
                    </tr>
                @endforeach


                <tr>
                    <td colspan=7>
					<span class="float-right">

					</span>
                    </td>
                </tr>

            </table>
        </div>
    @endif
@endsection

@section('action_page')
{{ route('patients/protocols/index') }}
@endsection
