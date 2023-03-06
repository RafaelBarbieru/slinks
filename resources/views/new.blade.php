@extends('layouts.app')

@include('partials.hide_scrollbar')
@include('partials.app_title')

@section('content')

<div class="slinks-main-container">
    <form class="slinks-form" method="POST" action="{{ url('add') }}">
        @csrf
        <!-- Title -->
        <h2>{{ __('common.add_object') }}</h2>
        <!-- Object type -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Object type</span>
                </div>
                @if (empty($type))
                <select class="form-select" id="object_type" name="object_type">
                    <option value="{{ env('OBJ_TYPE_BLOCK') }}">Block</option>
                    <option value="{{ env('OBJ_TYPE_GROUP') }}">Group</option>
                    <option value="{{ env('OBJ_TYPE_LINK') }}">Link</option>
                </select>
                @else
                <select disabled class="form-select" id="object_type" name="object_type">
                    <option selected value="{{ env('OBJ_TYPE_' . strtoupper($type)) }}">{{ ucfirst($type) }}
                    </option>
                </select>
                @endif
            </div>
        </div>
        <!-- Block reference -->
        <div id="div_block" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Parent block</span>
                </div>

                @if (isset($parent_block) && !empty($parent_block))
                <select disabled id="parent_block" class="form-select" name="block_reference" aria-label="Default select example">
                    <option selected value="{{ $parent_block->id }}">{{ $parent_block->name }}</option>
                </select>
                @endif

            </div>
        </div>
        <!-- Group reference -->
        <div id="div_group" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Parent group</span>
                </div>
                @if (!isset($parent_group) && empty($parent_group))
                <select class="form-select" name="group_reference" id="group_reference"></select>
                @else
                <select disabled class="form-select" name="group_reference" id="group_reference">
                    <option selected value="{{ $parent_group->id }}">{{ $parent_group->name }}</option>
                </select>
                @endif
            </div>
        </div>
        <!-- Name -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input id="inp_name" type="text" class="form-control" aria-label="Name" aria-describedby="Name of the object" name="inp_name">
            </div>
        </div>
        <!-- Link -->
        <div id="div_link" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Link</span>
                </div>
                <input id="inp_link" type="text" class="form-control" aria-label="Link" aria-describedby="Link of the group" name="inp_link">
            </div>
        </div>
        <!-- Add button -->
        <div class="slinks-form-button">
            <button id="add_btn" type="submit" class="btn-slinks">Add</button>
        </div>
        <!-- Back button -->
        <div class="slinks-form-button">
            <button style="margin-top: 1rem; width: 100%" id="back_btn" class="btn btn-secondary">Back</button>
        </div>
    </form>
</div>

<input hidden name="type" value="{{ isset($type) ? $type : null }}"></input>
<input hidden id="$parent_block_name" value="{{ isset($parent_block->name) ? $parent_block->name : null }}"></input>
<input hidden id="$parent_group_name" value="{{ isset($parent_group->name) ? $parent_group->name : null }}"></input>

<script src="{{ asset('js/spryform.js') }}"></script>

@endsection