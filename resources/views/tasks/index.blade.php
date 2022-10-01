@extends('layout.app')
@section('title')
    <h1 class="h2">Tasks</h1>
@endsection
@section('content')
    @livewire('task.task-list')
@endsection
