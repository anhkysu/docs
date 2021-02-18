@extends('layout.layout_fluid')

@section('container')

<div class="row bg-white" style="height:calc(100vh - 100px)">
    <div class="col d-flex align-items-center justify-content-center">
        <h2 class="text-secondary">{{ trans('auth.unauthorized') }}</h2>
    </div>
</div>

    
</div>
@endsection


@section('script')
@endsection
