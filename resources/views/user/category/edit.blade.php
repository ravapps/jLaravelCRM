@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
        </div>
    </div>
    <!-- ./ notifications -->
    @include('user/'.$type.'/_form')
    @if($user_data->inRole('admin'))
        <fieldset>
            <legend>{{trans('profile.history')}}</legend>
            <ul>
                @foreach($category->revisionHistory as $history )
                    <li>{{ $history->userResponsible()->first_name }} changed {{ $history->fieldName() }}
                        from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
                @endforeach
            </ul>
        </fieldset>
    @endif
@stop

@section('scripts')
    <script>
    </script>
@endsection