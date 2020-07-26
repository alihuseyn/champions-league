@extends('master')

@section('body')
    @component('components.navbar', [
        'title' => trans('play.title'),
        'route' => route('home'),
        'icon'  => 'fas fa-medal'
    ])
    @endcomponent
    <div class="container-fluid play-container mt-3">
        <div class="alert-container"></div>
        <div class="row m-0" data-container="main">
            <div class="col-12 {{ !$matches->isEmpty() && isset($predictions) ? 'col-lg-8' : '' }}" data-container="league">
                <div class="row border bg-white">
                    <div class="col-12 col-lg-7 m-0 p-0">
                        <div class="border-bottom p-2 text-center h4">
                            <span>@lang('play.league_table')</span>
                        </div>
                        <div class="table-responsive mt-2 p-2">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">
                                            @lang('play.teams')
                                        </th>
                                        <th scope="col">
                                            @lang('play.points')
                                        </th>
                                        <th scope="col">
                                            @lang('play.played')
                                        </th>
                                        <th scope="col">
                                            @lang('play.won')
                                        </th>
                                        <th scope="col">
                                            @lang('play.draw')
                                        </th>
                                        <th scope="col">
                                            @lang('play.lose')
                                        </th>
                                        <th scope="col">
                                            @lang('play.goal_difference')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody data-controller="league">
                                    @foreach($points as $point)
                                        <tr>
                                            <td scope="col">
                                                {{ $point->team->name }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->points }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->played }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->won }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->draw }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->lose }}
                                            </td>
                                            <td scope="col">
                                                {{ $point->goal_difference }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 m-0 p-0">
                        <div class="border-bottom p-2 text-center h4">
                            <span>@lang('play.match_results')</span>
                        </div>
                        <div class="p-2" data-controller="matches">
                            @if(!$matches->isEmpty())
                                <div class="text-center">
                                    <span>
                                        @lang('play.week_match_result', [ 'week' => ordinal($matches->first()->week) ])
                                    </span>
                                </div>
                                <div class="matches">
                                    @foreach($matches as $match)
                                        <div class="match">
                                            <span class="text-left">{{ $match->home->name }}</span>
                                            <span class="text-center">{{ $match->home_team_score }} - {{ $match->away_team_score}}</span>
                                            <span class="text-right">{{ $match->away->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center">
                                    <b>
                                        <i class="fas fa-info-circle"></i>
                                        @lang('play.league_not_started')
                                    </b>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row bg-secondary">
                    <div class="col-12 p-2">
                        <div class="text-center {{ $matches->isEmpty() ? '': 'd-none' }}" data-menu="start">
                            <button class="btn btn-success" data-btn="play">
                                <i class="fas fa-play mr-1"></i>
                                @lang('play.play')
                            </button>
                        </div>
                        <div class="{{ $matches->isEmpty() ? 'd-none': 'd-flex' }} justify-content-between" data-menu="general">
                            <div>
                                <button class="btn btn-info mr-1" data-btn="all">
                                    <i class="fas fa-fast-forward mr-1"></i>
                                    @lang('play.play_all')
                                </button>
                                <button class="btn btn-info" data-btn="next">
                                    <i class="fas fa-step-forward mr-1"></i>
                                    @lang('play.next_week')
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-danger" data-btn="reset">
                                    <i class="fas fa-redo mr-1"></i>
                                    @lang('play.reset')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$matches->isEmpty() && isset($predictions))
                <div class="col-12 col-lg-4" data-container="prediction">
                    <div class="bg-white border p-2">
                        <p class="text-center">
                            @lang('play.prediction',[ 'week' => ordinal($matches->first()->week) ])
                        </p>
                        <div>
                            @foreach($predictions as $prediction)
                             <div class="d-flex justify-content-between">
                                <span>{{ $prediction['team'] }}</span>
                                <span>{{ $prediction['prediction'] }}%</span>
                              </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div> 
    </div>
@endsection
