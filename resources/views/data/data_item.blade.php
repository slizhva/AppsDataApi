@extends('layouts.admin')

@section('container-class')
    container-fluid
@endsection

@section('body-class')
    col-md-8
@endsection

@section('admin-title')
    <div>
        <span><a class="btn btn-link p-0" href="{{ route('data') }}">Dashboard</a>/Data/</span><strong>{{ $data['name'] }}</strong>
    </div>
@endsection

@section('admin-body')
    <div class="row">
        <div class="col-md-12">
            <hr>
            <span>---Data get link---</span>
            <p class="mb-1">
                <strong id="appLinkText">{{ route('data.get', [$data['id'], $token]) }}</strong>
            </p>
            <input style="display: none" id="copyLinkButton" type="submit" value="Copy Link">

            <hr class="mt-4 mb-4">

            <form method="POST" action="{{ route('data.item.value.update', $data['id']) }}">
                {{ csrf_field() }}
                <textarea rows="10" name="value" class="col-md-12">{{ $data['value'] }}</textarea>
                <input class="col-md-2 mt-1" type="submit" value="Save"/>
            </form>
        </div>
    </div>
@endsection
