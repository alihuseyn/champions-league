@extends('master')

@section('body')
    @component('components.navbar', [ 
        'title' => 'Settings',
        'route' => route('settings'),
        'menu' => [ 'settings' => false, 'home' => true ]
    ])
    @endcomponent
    <div class="container-fluid mt-3"> 
        <div class="row">
            <div class="col-12 bg-white">
                <p class="h4 p-2">@lang('setting.teams')</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>
                                    #
                                </td>
                                <td>
                                    Team Name
                                </td>
                                <td>
                                    Team Scoring Inddex
                                </td>
                                <td>
                                    Team Min Goal Score in a Match
                                </td>
                                <td>
                                    Team Max Goal Score in a Match
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $index => $team)
                                <tr>
                                    <td>{{ $index + 1}}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ number_format($team->strength, 2) }}%</td>
                                    <td>{{ $team->min_goal_in_match }}</td>
                                    <td>{{ $team->max_goal_in_match }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
