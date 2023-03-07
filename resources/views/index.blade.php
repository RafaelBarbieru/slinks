@extends('layouts.app')

@include('partials.app_title')

@section('content')

<div id="filter-blocks" class="slinks-container">

    <input type="search" class="search" placeholder="Search block…" autofocus />

    <h1>{{ __('common.active_blocks') }}
        <a href="{{ route('new', ['type' => 'block']) }}" title="Add new block" class="slinks-link-a">
            <i class="fas fa-plus-square slinks-icon slinks-icon-add"></i>
        </a>
    </h1>

    <div class="searchable">
        <div class="sortable-block">
            @foreach ($active_blocks->sortBy('order') as $block)
            @include('partials.table')
            @endforeach
        </div>
    </div>

    <hr>

    <br><br>

    <!-- ARCHIVE -->
    <h1 class="slinks-archive">{{ __('common.archive_blocks') }}</h1>

    <div class="searchable">
        <div class="sortable-y">
            @foreach ($archived_blocks->sortBy('order') as $block)
            @include('partials.archive_table')
            @endforeach
        </div>
    </div>


</div>

<script src="{{ asset('js/filter.js') }}"></script>
<script src="{{ asset('js/scroll.js') }}"></script>
<script src="{{ asset('js/sort.js') }}"></script>

@endsection