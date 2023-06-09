@extends('layouts.admin')

@section('container-class')
    container
@endsection

@section('body-class')
    col-md-8
@endsection

@section('admin-title')
    <span><a class="btn btn-link p-0" href="{{ route('data') }}">Dashboard</a>/Data</span>
@endsection

@section('admin-body')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <strong>---Data:---</strong>
                <form class="row" method="POST" action="{{ route('data.add') }}" >
                    {{ csrf_field() }}
                    <input name="name" type="text" value="" placeholder="Data name" class="col-md-9" required>
                    <input type="submit" value="Add" class="col-md-3">
                </form>
                <div class="row border-bottom border-top bg-light">
                    <div class="col-md-9 border-start">Data</div>
                    <div class="col-md-3 border-start border-end"></div>
                </div>
                @foreach($data as $item)
                    <div class="row border-bottom align-items-center">
                        <div class="col-md-9 border-start">
                            <a class="btn btn-link" href="{{ route('data.item', $item['id']) }}">{{ $item['name'] }}</a>
                        </div>
                        <div class="col-md-3 border-start border-end">
                            <form method="POST" action="{{ route('data.delete', $item['id']) }}">
                                {{ csrf_field() }}
                                <input name="dangerous_actions_key" class="dangerous-action-key-value" type="text" value="" hidden>
                                <input class="col-md-12 pt-0 pb-0 dangerous-action-button" type="submit" value="Delete" disabled>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mt-5">
            <hr>
            <div class="col-md-12">
                @include('data.dangerous_action_form')
            </div>
        </div>
    </div>
@endsection
