@section('js')
<script type="text/javascript">
    function checkLabStaffPermissions()
    {
        $('#isLabStaff').change(function() {
            if(this.checked) 
            {
                $('#labStaffEnviroment').show(1000);
                $('#patientEnviroment').hide(1000);
            }
        });

        $('#isUser').change(function() {
            if(this.checked) 
            {
                $('#patientEnviroment').show(1000);
                $('#labStaffEnviroment').hide(1000);
            }
        });

        $('#managePatients').change(function() {
            if(! this.checked) 
            {
                $('#generateSecurityCodes').prop('checked', false);
            }
        });

        $('#generateSecurityCodes').change(function() {
            if(this.checked && $('#managePatients').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_patients') }}");
                $('#generateSecurityCodes').prop('checked', false);
            }       
        });

        $('#manageDeterminations').change(function() {
            if(! this.checked) 
            {
                $('#manageReports').prop('checked', false);
            }       
        });

        $('#manageReports').change(function() {
            if(this.checked && $('#manageDeterminations').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_determinations') }}");
                $('#manageReports').prop('checked', false);
            }       
        });

        $('#manageProtocols').change(function() {
            if(! this.checked) 
            {
                $('#printWorksheets').prop('checked', false);
                $('#printProtocols').prop('checked', false);
                $('#managePractices').prop('checked', false);
                $('#signPractices').prop('checked', false);
            }       
        });

        $('#printWorksheets').change(function() {
            if(this.checked && $('#manageProtocols').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_protocols') }}");
                $('#printWorksheets').prop('checked', false);
            }       
        });

        $('#printProtocols').change(function() {
            if(this.checked && $('#manageProtocols').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_protocols') }}");
                $('#printProtocols').prop('checked', false);
            }       
        });

        $('#managePractices').change(function() {
            if(this.checked) 
            {
                if ($('#manageProtocols').prop('checked') === false)
                {
                    alert("{{ trans('roles.check_manage_protocols') }}");
                    $(this).prop("checked", false);
                }
            } else 
            {
                $('#signPractices').prop('checked', false);
            }    
        });

        $('#signPractices').change(function() {
            if(this.checked && $('#managePractices').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_practices') }}");
                $('#signPractices').prop('checked', false);
            }       
        });

        $('#manageSettings').change(function() {
            if(! this.checked) 
            {
                $('#manageParameters').prop('checked', false);
                $('#manageRoles').prop('checked', false);
            }    
        });

        $('#manageParameters').change(function() {
            if(this.checked && $('#manageSettings').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_settings') }}");
                $('#manageParameters').prop('checked', false);
            }       
        });

        $('#manageRoles').change(function() {
            if(this.checked && $('#manageSettings').prop('checked') === false) 
            {
                alert("{{ trans('roles.check_manage_settings') }}");
                $('#manageRoles').prop('checked', false);
            }       
        });
    }
</script>
@append

@section('environments')
    <div class="row" id="labStaffEnviroment">
        <div class="col-md-6 mt-3">
            <h4> {{ trans('patients.patients') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage patients" name="permissions[]" id="managePatients" @if (isset($role) && $role->permissions->where('name', 'manage patients')->first()) checked @endif>

                        <label class="form-check-label" for="managePatients">
                            {{ trans('roles.manage_patients') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="generate security codes" name="permissions[]" id="generateSecurityCodes" @if (isset($role) && $role->permissions->where('name', 'generate security codes')->first()) checked @endif>

                        <label class="form-check-label" for="generateSecutiryCodes">
                            {{ trans('roles.generate_security_codes') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4> Prescribers </h4>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage prescribers" name="permissions[]" id="managePrescribers" @if (isset($role) && $role->permissions->where('name', 'manage prescribers')->first()) checked @endif>

                        <label class="form-check-label" for="managePrescribers">
                            {{ trans('roles.manage_prescribers') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4> {{ trans('determinations.determinations') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage determinations" name="permissions[]" id="manageDeterminations" @if (isset($role) && $role->permissions->where('name', 'manage determinations')->first()) checked @endif>

                        <label class="form-check-label" for="manageDeterminations">
                            {{ trans('roles.manage_determinations') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage reports" name="permissions[]" id="manageReports" @if (isset($role) && $role->permissions->where('name', 'manage reports')->first()) checked @endif>

                        <label class="form-check-label" for="manageReports">
                            {{ trans('roles.manage_reports') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4> {{ trans('protocols.protocols') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage protocols" name="permissions[]" id="manageProtocols" @if (isset($role) && $role->permissions->where('name', 'manage protocols')->first()) checked @endif>

                        <label class="form-check-label" for="manageProtocols">
                            {{ trans('roles.manage_protocols') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="print worksheets" name="permissions[]" id="printWorksheets" @if (isset($role) && $role->permissions->where('name', 'print worksheets')->first()) checked @endif>

                        <label class="form-check-label" for="printWorksheets">
                            {{ trans('roles.print_worksheets') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="print protocols" name="permissions[]" id="printProtocols" @if (isset($role) && $role->permissions->where('name', 'print protocols')->first()) checked @endif>

                        <label class="form-check-label" for="printProtocols">
                            {{ trans('roles.print_protocols') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>   
            
        <div class="col-md-6 mt-3">
            <h4> {{ trans('practices.practices') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage practices" name="permissions[]" id="managePractices" @if (isset($role) && $role->permissions->where('name', 'manage practices')->first()) checked @endif>

                        <label class="form-check-label" for="managePractices">
                            {{ trans('roles.manage_practices') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="sign practices" name="permissions[]" id="signPractices" @if (isset($role) && $role->permissions->where('name', 'sign practices')->first()) checked @endif>

                        <label class="form-check-label" for="signPractices">
                            {{ trans('roles.sign_practices') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4> {{ trans('settings.settings') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage settings" name="permissions[]" id="manageSettings" @if (isset($role) && $role->permissions->where('name', 'manage settings')->first()) checked @endif>

                        <label class="form-check-label" for="manageSettings">
                            {{ trans('roles.manage_settings') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage parameters" name="permissions[]" id="manageParameters" @if (isset($role) && $role->permissions->where('name', 'manage parameters')->first()) checked @endif>

                        <label class="form-check-label" for="manageParameters">
                            {{ trans('roles.manage_parameters') }}
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manage roles" name="permissions[]" id="manageRoles" @if (isset($role) && $role->permissions->where('name', 'manage roles')->first()) checked @endif>

                        <label class="form-check-label" for="manageRoles">
                            {{ trans('roles.manage_roles') }}
                        </label>
                    </div>
                </div>  
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4> {{ trans('roles.other_permissions') }} </h4>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="view statistics" name="permissions[]" id="viewStatistics" @if (isset($role) && $role->permissions->where('name', 'view statistics')->first()) checked @endif>

                        <label class="form-check-label" for="viewStatistics">
                            {{ trans('roles.view_statistics') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="generate summaries" name="permissions[]" id="generateSummaries" @if (isset($role) && $role->permissions->where('name', 'generate summaries')->first()) checked @endif>

                        <label class="form-check-label" for="generateSummaries">
                            {{ trans('roles.generate_summaries') }}
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="view logs" name="permissions[]" id="viewLogs" @if (isset($role) && $role->permissions->where('name', 'view logs')->first()) checked @endif>

                        <label class="form-check-label" for="viewLogs">
                            {{ trans('roles.view_logs') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@append