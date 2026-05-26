@extends('layouts.app')

@section('content')

<div class="bg-gray-200 min-h-screen pb-3">

    @include('layouts.panelHeading')
    @include('layouts.headingContent')

    <div class="bg-white shadow rounded-lg p-4 m-4">
        <div class="blog_body"></div>
    </div>

    <div class="pagination-container mt-4 flex justify-center">
        <ul class="pagination flex gap-2"></ul>
    </div>

</div>

@endsection



@push('scripts')
    @vite('resources/js/dashboard/dashboard.js')
@endpush