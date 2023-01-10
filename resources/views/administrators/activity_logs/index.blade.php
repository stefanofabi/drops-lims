<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Activity log viewer</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <style>
        body {
            padding: 25px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        #table-log {
            font-size: 0.85rem;
        }

        .sidebar {
            font-size: 0.85rem;
            line-height: 1;
        }

        .btn {
            font-size: 0.7rem;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 75px;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }

        .list-group-item {
            word-break: break-word;
        }

        .folder {
            padding-top: 15px;
        }

        .div-scroll {
            height: 80vh;
            overflow: hidden auto;
        }
        .nowrap {
            white-space: nowrap;
        }



        /**
        * DARK MODE CSS
        */

        body[data-theme="dark"] {
            background-color: #151515;
            color: #cccccc;
        }

        [data-theme="dark"] a {
            color: #4da3ff;
        }

        [data-theme="dark"] a:hover {
            color: #a8d2ff;
        }

        [data-theme="dark"] .list-group-item {
            background-color: #1d1d1d;
            border-color: #444;
        }

        [data-theme="dark"] a.llv-active {
            background-color: #0468d2;
            border-color: rgba(255, 255, 255, 0.125);
            color: #ffffff;
        }

        [data-theme="dark"] a.list-group-item:focus, [data-theme="dark"] a.list-group-item:hover {
            background-color: #273a4e;
            border-color: rgba(255, 255, 255, 0.125);
            color: #ffffff;
        }

        [data-theme="dark"] .table td, [data-theme="dark"] .table th,[data-theme="dark"] .table thead th {
            border-color:#616161;
        }

        [data-theme="dark"] .page-item.disabled .page-link {
            color: #8a8a8a;
            background-color: #151515;
            border-color: #5a5a5a;
        }

        [data-theme="dark"] .page-link {
            background-color: #151515;
            border-color: #5a5a5a;
        }

        [data-theme="dark"] .page-item.active .page-link {
            color: #fff;
            background-color: #0568d2;
            border-color: #007bff;
        }

        [data-theme="dark"] .page-link:hover {
            color: #ffffff;
            background-color: #0051a9;
            border-color: #0568d2;
        }

        [data-theme="dark"] .form-control {
            border: 1px solid #464646;
            background-color: #151515;
            color: #bfbfbf;
        }

        [data-theme="dark"] .form-control:focus {
            color: #bfbfbf;
            background-color: #212121;
            border-color: #4a4a4a;
        }

    </style>

    <script>
        function initTheme() {
            const darkThemeSelected =
                localStorage.getItem('darkSwitch') !== null &&
                localStorage.getItem('darkSwitch') === 'dark';
            darkSwitch.checked = darkThemeSelected;
            darkThemeSelected ? document.body.setAttribute('data-theme', 'dark') :
                document.body.removeAttribute('data-theme');
        }

        function resetTheme() {
            if (darkSwitch.checked) {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('darkSwitch', 'dark');
            } else {
                document.body.removeAttribute('data-theme');
                localStorage.removeItem('darkSwitch');
            }
        }
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col sidebar mb-3">
            <h1><i class="fa fa-calendar" aria-hidden="true"></i> Activity Log Viewer</h1>
            <p class="text-muted"><i>Thanks to Spatie & Rap2h</i></p>

            <div class="custom-control custom-switch" style="padding-bottom:20px;">
                <input type="checkbox" class="custom-control-input" id="darkSwitch">
                <label class="custom-control-label" for="darkSwitch" style="margin-top: 6px;">Dark Mode</label>
            </div>

            <div class="list-group div-scroll">
                <!-- list of log_name here -->
            </div>
        </div>
        <div class="col-10 table-container">
            @if ($activities === null)
                <div>
                    No data
                </div>
            @else
                <table id="table-log" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Causer</th>
                            <th>Affected model</th>
                            <th>Event</th>
                            <th>Attributes affected</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td class="text"> {{ date_format($activity->updated_at, 'd/m/Y H:i') }}Hs. </td>

                            <td class="nowrap">
                                @if (!empty($activity->causer_type) && $activity->causer_type::find($activity->causer_id)->name)
                                    {{ \App\Models\User::find($activity->causer_id)->name }}
                                @else
                                    System
                                @endif
                            </td>

                            <td class="date">
                                @if ($activity->subject_type::find($activity->subject_id))
                                    {{ $activity->subject_type }}  #{{ $activity->subject_type::find($activity->subject_id)->id }}
                                @endif
                            </td>

                            <td>
                                {{ $activity->event }}
                            </td>

                            <td class="text">
                                @if ($activity->properties->has('attributes'))
                                    @foreach($activity->changes['attributes'] as $key => $val)

                                        @if (isset($activity->changes['old']) && $val == $activity->changes['old'][$key])
                                            @continue
                                        @endif

                                        @if ($key == 'created_at' || $key == 'updated_at')
                                            @continue
                                        @endif

                                        <strong> {{"$key"}} </strong>

                                        @if (isset($activity->changes['old']) && $val != $activity->changes['old'][$key])
                                            @if (is_array($activity->changes['old'][$key]))
                                                @if (empty($activity->changes['old'][$key])) from [] @else from {{ implode(',', $activity->changes['old'][$key]) }} @endif
                                            @else
                                                from "{{ $activity->changes['old'][$key] }}"
                                            @endif
                                        @endif

                                        @if (is_array($val))
                                            @if (empty($val)) to [] @else {{ implode(',', $val) }} @endif
                                        @else 
                                            to "{{ $val }}"
                                        @endif

                                        <br>
                                    @endforeach
                                @elseif ($activity->properties->has('old'))
                                    @foreach($activity->changes['old'] as $key => $val)
                                        @if ($key == 'created_at' || $key == 'updated_at')
                                            @continue
                                        @endif
                                        <strong> {{"$key"}} </strong>

                                        => "{{ $val}}"

                                        <br>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif

        </div>
    </div>
</div>
<!-- jQuery for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- FontAwesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script>

    // dark mode by https://github.com/coliff/dark-mode-switch
    const darkSwitch = document.getElementById('darkSwitch');

    // this is here so we can get the body dark mode before the page displays
    // otherwise the page will be white for a second...
    initTheme();

    window.addEventListener('load', () => {
        if (darkSwitch) {
            initTheme();
            darkSwitch.addEventListener('change', () => {
                resetTheme();
            });
        }
    });

    // end darkmode js

    $(document).ready(function () {
        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });
        $('#table-log').DataTable({
            "order": [$('#table-log').data('orderingIndex'), 'desc'],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            }
        });
        $('#delete-log, #clean-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });
    });
</script>
</body>
</html>
