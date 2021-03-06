@extends('backpack::layout')

@section('header')
<section class="content-header">
    <h1>
        @lang('Human Resources')
    </h1>
</section>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                        @lang('Human Resources')
                </div>
                <div class="box-tools pull-right">
                    <!-- Period selection dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $selected_period->name }} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($periods as $period)
                                <li><a href="{{ url()->current() }}/?period={{ $period->id }}">{{ $period->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <div class="box-body">           
                
                <table class="table table-striped responsive">
                    <thead>
                        <tr>
                            <th>@lang('Teacher')</th>
                            <th>@lang('Remote Work')</th>
                            <th>@lang('Planned Hours')</th>
                            <th>@lang('Period Max')</th>
                            <th><strong>@lang('Period Total')</strong></th>
                            <th>@lang('Worked Hours')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($teachers as $teacher)
                        @php
                            $max_hours = $teacher->period_max_hours($selected_period);
                            $period_hours = $teacher->period_planned_hours($selected_period);
                            $remote_hours = $teacher->periodRemoteHours($selected_period);
                        @endphp
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ number_format($remote_hours, 2, '.', ',') }} h</td>
                            <td>{{ number_format($period_hours, 2, '.', ',') }} h</td>
                            <td>{{ number_format($max_hours, 2, '.', ',') }} h</td>

                            <td>
                                <strong>{{ number_format($period_hours + $remote_hours, 2, '.', ',') }} h</strong>
                                ({{ number_format(100 * ($period_hours + $remote_hours)/$max_hours, 0) }}%)
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-red" style="width: {{100 * ($period_hours + $remote_hours)/$max_hours}}%"></div>
                              </div>
                            </td>
                            <td>{{ number_format($teacher->period_worked_hours($selected_period), 2, '.', ',') }} h</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
