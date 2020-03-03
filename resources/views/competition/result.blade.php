@extends('layouts.app')

@section('content')
    @if(Agent::isMobile())
    <competition-mobile-result />
    @else
    <competition-result />
    @endif
@endsection