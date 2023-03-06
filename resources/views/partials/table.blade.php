<table id="{{ 'block-order-' . $block->order }}" class="table table-bordered slinks-table">
    <thead class="sortable-block-handle">
        <tr>
            <th scope="col" colspan="2">

                <!-- BLOCK -->
                <div class="slinks-object" draggable="true">
                    <h5 class="block-name">{{ $block->name }}</h5>
                    <small hidden id="{{ 'block-id-' . $block->id }}" class="block-id"></small>
                    <span>
                        <a href="{{ route('new', ['type' => 'group', 'id' => $block->id]) }}" title="Add group to block" class="slinks-link-a"><i class="fas fa-plus-square slinks-icon-title slinks-icon-add"></i></a>
                        <a title="Edit block details" href="{{ route('modify', ['type' => 'block', 'id' => $block->id]) }}"><i class="fas fa-edit slinks-icon-title slinks-icon-edit" class="slinks-link-a"></i></a>
                        <a title="Remove block" href="{{ route('remove', ['type' => 'block', 'id' => $block->id]) }}" onclick="return confirm('{{ __('common.remove_alert') }}')"><i class="fas fa-trash slinks-icon-title slinks-icon-remove" class="slinks-link-a"></i></a>
                    </span>
                </div>
                <!--------->

            </th>
        </tr>
    </thead>
    <tbody class="sortable-group">
        @foreach ($block->groups->sortBy('order') as $group)
        <tr id="{{ 'group-order-' . $group->order }}" class="slinks-group">
            <th class="align-middle">

                <!-- GROUP -->
                <div class="slinks-object sortable-group-handle">
                    <span>{{ $group->name }}</span>
                    <small hidden id="{{ 'group-id-' . $group->id }}" class="group-id"></small>
                    <span>
                        <a title="Add link to group" class="slinks-link-a" href="{{ route('new', ['type' => 'link', 'id' => $group->id]) }}"><i class="fas fa-plus-square slinks-icon slinks-icon-add"></i></a>
                        <a title="Edit group details" class="slinks-link-a" href="{{ route('modify', ['type' => 'group', 'id' => $group->id]) }}"><i class="fas fa-edit slinks-icon slinks-icon-edit"></i></a>
                        <a title="Remove group" class="slinks-link-a" href="{{ route('remove', ['type' => 'group', 'id' => $group->id]) }}" onclick="return confirm('{{ __('common.remove_alert') }}')"><i class="fas fa-trash-alt slinks-icon slinks-icon-remove"></i></a>
                    </span>
                </div>
                <!--------->

            </th>
            <td>
                <div class="slinks-links sortable-link">
                    @foreach ($group->links->sortBy('order') as $link)

                    <!-- LINK -->
                    <div id="{{ 'link-order-' . $link->order }}" class="slinks-link">
                        <a class="slinks-link-a" href="{{ $link->link }}" target="_blank">{{ $link->name }}</a>
                        <small hidden id="{{ 'link-id-' . $link->id }}" class="link-id"></small>
                        <span>
                            <a class="slinks-link-a" href="{{ route('modify', ['type' => 'link', 'id' => $link->id]) }}"><i class="fas fa-edit slinks-icon slinks-icon-edit"></i></a>
                            <a class="slinks-link-a" href="{{ route('remove', ['type' => 'link', 'id' => $link->id]) }}" onclick="return confirm('{{ __('common.remove_alert') }}')"><i class="fas fa-trash-alt slinks-icon slinks-icon-remove"></i></a>
                            <a class="slinks-link-a"><i class="fas fa-arrows-alt slinks-icon slinks-icon-move sortable-link-handle"></i></a>
                        </span>
                    </div>
                    <!---------->

                    @endforeach
            </td>
        </tr>
        @endforeach
        </div>
    </tbody>
</table>