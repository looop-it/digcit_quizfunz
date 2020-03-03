@extends('layouts.app')

@section('content')

    @if(Agent::isMobile())
    <competition-mobile / >
    @else
    <competition / >
    @endif
@endsection