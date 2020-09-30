@extends('layouts.competition')

@section('content')
    @if(Agent::isMobile())
    <competition-mobile / >
    @else
    <competition / >
    @endif
@endsection