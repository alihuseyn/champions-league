@extends('master')

@section('body')
    @component('components.navbar', [ 
        'title' => 'Settings',
        'route' => route('settings'),
        'menu' => [ 'settings' => false, 'home' => true ]
    ])
    @endcomponent
    <div class="container"> 
        <div class="row">
            <h3>@lang('setting.teams')</h3>
        </div>
    </div>
@endsection
