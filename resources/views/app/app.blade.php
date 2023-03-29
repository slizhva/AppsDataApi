@extends('layouts.admin')

@section('container-class')
    container-fluid
@endsection

@section('body-class')
    col-md-11
@endsection

@section('admin-title')
    <span><a class="btn btn-link p-0" href="{{ route('dashboard.apps') }}">Dashboard</a>/App/</span><strong>{{ $app['name'] }}</strong>
@endsection

@section('admin-body')
    <div class="row">
        <div class="col-md-12">
            <hr>
            <span>---App link---</span>
            <p class="mb-1">
                <strong id="appLinkText">{{ route('translations.get', [$app['id'], $token]) }}</strong>
            </p>
            <input style="display: none" id="copyLinkButton" type="submit" value="Copy Link">

            <hr>

        </div>
    </div>
@endsection
