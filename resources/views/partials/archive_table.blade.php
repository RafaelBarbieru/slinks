<table id="{{ 'block-order-' . $block->order }}" class="table table-bordered slinks-table">
    <thead class="sortable-block-handle">
        <tr>
            <th scope="col" colspan="2">

                <!-- BLOCK -->
                <div class="slinks-object" draggable="true">
                    <h5 class="block-name"> {{ $block->name }} </h5>
                    <small hidden id="{{ 'block-id-' . $block->id }}" class="block-id"></small>
                    <span>
                        <a title="Edit block details" href="{{ route('modify', ['type' => 'block', 'id' => $block->id]) }}"><i class="fas fa-edit slinks-icon-title slinks-icon-edit" class="slinks-link-a"></i></a>
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
                        <small hidden id="{{ 'link-id-' . $link->id }}" class="link-id"></small>
                        <span>
                            <a class="slinks-link-a"><i class="fas fa-arrows-alt slinks-icon slinks-icon-move sortable-link-handle"></i></a>
                        </span>
                    </div>
                    <!---------->

                    @endforeach
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>