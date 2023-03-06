@extends('layouts.app')

@include('partials.hide_scrollbar')
@include('partials.app_title')

@section('content')

<div class="slinks-main-container">
    <form class="slinks-form" method="POST" action="{{ route('edit', ['type' => $type, 'id' => $current_object->id]) }}">
        @csrf
        <!-- Title -->
        <h2>{{ __('common.edit_object') }}</h2>
        <!-- Object type -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Object type</span>
                </div>
                <select disabled class="form-select" id="object_type" name="object_type">
                    @if ($type == env('OBJ_TYPE_BLOCK'))
                    <option value="{{ env('OBJ_TYPE_BLOCK') }}">Block</option>
                    @elseif ($type == env('OBJ_TYPE_GROUP') )
                    <option value="{{ env('OBJ_TYPE_GROUP') }}">Group</option>
                    @else
                    <option value="{{ env('OBJ_TYPE_LINK') }}">Link</option>
                    @endif
                </select>
            </div>
        </div>
        @unless($type == env('OBJ_TYPE_BLOCK'))
        <!-- Block reference -->
        <div id="div_block" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Parent block</span>
                </div>
                <select id="parent_block" class="form-select" name="new_app_id" aria-label="Default select example">
                    @foreach ($blocks as $block)
                    @if ($type == env('OBJ_TYPE_GROUP'))
                    @if ($block->id == $current_object->block_id)
                    <option selected value="{{ $block->id }}">{{ $block->name }}</option>
                    @else
                    <option value="{{ $block->id }}">{{ $block->name }}</option>
                    @endif
                    @elseif($type == env('OBJ_TYPE_LINK'))
                    @if ($block->id == $current_object->group->block_id)
                    <option selected value="{{ $block->id }}">{{ $block->name }}</option>
                    @else
                    <option value="{{ $block->id }}">{{ $block->name }}</option>
                    @endif
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        @endunless
        @if ($type == env('OBJ_TYPE_LINK'))
        <!-- Group reference -->
        <div id="div_group" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Parent group</span>
                </div>
                <select class="form-select" name="new_group_id" id="group_reference"></select>
            </div>
        </div>
        @endif
        <!-- Name -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input id="inp_name" type="text" class="form-control" aria-label="Name" aria-describedby="Name of the object" name="new_name" value="{{ $current_object->name }}">
            </div>
        </div>
        @if ($type == env('OBJ_TYPE_BLOCK'))
        <!-- Archive -->
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="form-check">
                    @if ($current_object->archive)
                    <input checked name="new_archive" class="form-check-input" type="checkbox" id="inp_archive" onclick="this.value = this.checked;">
                    @else
                    <input name="new_archive" class="form-check-input" type="checkbox" id="inp_archive" onclick="this.value = this.checked;">
                    @endif
                    <label class="form-check-label" for="lb_archive">
                        Archive
                    </label>
                </div>
            </div>
        </div>
        @endif
        @if ($type == env('OBJ_TYPE_LINK'))
        <!-- Link -->
        <div id="div_link" class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Link</span>
                </div>
                <input id="inp_link" type="text" class="form-control" aria-label="Link" aria-describedby="Link of the group" name="new_link" value="{{ $current_object->link }}">
            </div>
        </div>
        @endif
        <!-- Edit button -->
        <div class="slinks-form-button">
            <button id="add_btn" type="submit" class="btn-slinks">Edit</button>
        </div>
        <!-- Back button -->
        <div class="slinks-form-button">
            <button style="margin-top: 1rem; width: 100%" id="back_btn" class="btn btn-secondary">Back</button>
        </div>
    </form>
</div>

<input hidden id="$parent_group_id" value="{{ isset($current_object->group_id) ? $current_object->group_id : null }}"></input>

<script src="{{ asset('js/slinksform.js') }}"></script>

@endsection