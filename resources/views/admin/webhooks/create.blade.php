@extends('admin.layouts.admin')

@section('title', trans('serveurminecraftvote::admin.rewards.title-create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('serveurminecraftvote.admin.rewards.store') }}" method="POST">
                @include('serveurminecraftvote::admin.webhooks._form')

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ trans('messages.actions.save') }}</button>
            </form>
        </div>
    </div>
@endsection
