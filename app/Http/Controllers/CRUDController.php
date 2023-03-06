<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Group;
use App\Models\Link;
use Illuminate\Http\Request;

class CRUDController extends Controller
{

    public function showAdd(Request $request)
    {
        switch ($request->type) {
            case env('OBJ_TYPE_GROUP'):
                $blockObj = Block::whereId($request->id)->first();
                $groupObj = null;
                break;
            case env('OBJ_TYPE_LINK'):
                $groupObj = Group::whereId($request->id)->first();
                $blockObj = Block::whereId($groupObj->block_id)->first();
                break;
            default:
                $blockObj = null;
                $groupObj = null;
                break;
        }
        $params = ['parent_block' => $blockObj, 'parent_group' => $groupObj, 'type' => $request->type];
        return view("new", $params);
    }

    public function showEdit(Request $request)
    {
        $obj = null;
        switch ($request->type) {
            case env('OBJ_TYPE_BLOCK'):
                $obj = Block::whereId($request->id)->first();
                break;
            case env('OBJ_TYPE_GROUP'):
                $obj = Group::whereId($request->id)->first();
                break;
            case env('OBJ_TYPE_LINK'):
                $obj = Link::whereId($request->id)->first();
                break;
            default:
                error_log('ERROR DEFAULT OBJECT TYPE @CRUDController:showEdit --> \'' . $request->object_type . '\'');
                break;
        }

        // Retrieving all the blocks from the database
        $blocks = Block::active()->orderBy('name', 'ASC')->get();

        // Returning the view with parameters
        return view("edit", ['blocks' => $blocks, 'current_object' => $obj, 'type' => $request->type]);
    }

    public function add(Request $request)
    {
        switch ($request->object_type) {
            case env('OBJ_TYPE_BLOCK'):
                $this->createBlock($request)->save();
                break;
            case env('OBJ_TYPE_GROUP'):
                $this->createGroup($request)->save();
                break;
            case env('OBJ_TYPE_LINK'):
                $this->createLink($request)->save();
                break;
            default:
                error_log('ERROR DEFAULT OBJECT TYPE @CRUDController:add');
                break;
        }

        return redirect('/');
    }

    public function edit(Request $request)
    {
        switch ($request->type) {
            case env('OBJ_TYPE_BLOCK'):
                $this->editBlock($request);
                break;
            case env('OBJ_TYPE_GROUP'):
                $this->editGroup($request);
                break;
            case env('OBJ_TYPE_LINK'):
                $this->editLink($request);
                break;
            default:
                error_log('ERROR DEFAULT OBJECT TYPE @CRUDController:edit --> \'' . $request->type . '\'');
                break;
        }

        return redirect('/');
    }

    public function remove(Request $request)
    {
        switch ($request->type) {
            case env('OBJ_TYPE_BLOCK'):
                $this->deleteBlock($request);
                break;
            case env('OBJ_TYPE_GROUP'):
                $this->deleteGroup($request);
                break;
            case env('OBJ_TYPE_LINK'):
                $this->deleteLink($request);
                break;
        }

        return redirect('/');
    }

    public function increaseOrder(Request $request)
    {
        $increase = true;
        switch ($request->type) {
            case env('OBJ_TYPE_BLOCK'):
                $this->changeOrderBlock($request, $increase);
                break;
            case env('OBJ_TYPE_GROUP'):
                $this->changeOrderGroup($request, $increase);
                break;
            case env('OBJ_TYPE_LINK'):
                $this->changeOrderLink($request, $increase);
                break;
        }

        return redirect('/');
    }

    public function decreaseOrder(Request $request)
    {
        $decrease = false;
        switch ($request->type) {
            case env('OBJ_TYPE_BLOCK'):
                $this->changeOrderBlock($request, $decrease);
                break;
            case env('OBJ_TYPE_GROUP'):
                $this->changeOrderGroup($request, $decrease);
                break;
            case env('OBJ_TYPE_LINK'):
                $this->changeOrderLink($request, $decrease);
                break;
        }

        return redirect('/');
    }

    public function changeBlockOrder(Request $request)
    {
        $apps = Block::all();
        foreach ($request->all() as $obj) {
            foreach ($apps as $app) {
                if ($app->id == $obj['id'] && $app->order != $obj['newOrder']) {
                    $app->order = $obj['newOrder'];
                    $app->save();
                }
            }
        }
    }

    public function changeGroupOrder(Request $request)
    {
        $groups = Group::all();
        foreach ($request->all() as $obj) {
            foreach ($groups as $group) {
                if ($group->id == $obj['id'] && $group->order != $obj['newOrder']) {
                    $group->order = $obj['newOrder'];
                    $group->save();
                }
            }
        }
    }

    public function changeLinkOrder(Request $request)
    {
        $links = Link::all();
        foreach ($request->all() as $obj) {
            foreach ($links as $link) {
                if ($link->id == $obj['id'] && $link->order != $obj['newOrder']) {
                    $link->order = $obj['newOrder'];
                    $link->save();
                }
            }
        }
    }

    private function changeOrderGroup(Request $request, bool $increase)
    {
        $currentGroup = Group::whereId($request->id)->first();
        $parentBlockId = $currentGroup->block->id;
        $firstOrder = Group::whereBlockId($parentBlockId)->order()->first()->order;
        $lastOrder = Group::whereBlockId($parentBlockId)->latestOrder()->first()->order;
        $possibleAdjacentOrder = null;
        $adjacentGroup = null;
        if ($increase) {
            $possibleAdjacentOrder = Group::whereBlockId($parentBlockId)->where('order', '>', $currentGroup->order)->min('order') ?? $firstOrder;
            $adjacentGroup = Group::whereOrder($possibleAdjacentOrder <= $lastOrder ? $possibleAdjacentOrder : $firstOrder)->first();
        } else {
            $possibleAdjacentOrder = Group::whereBlockId($parentBlockId)->where('order', '<', $currentGroup->order)->max('order') ?? $lastOrder;
            $adjacentGroup = Group::whereOrder($possibleAdjacentOrder > 0 ? $possibleAdjacentOrder : 1)->first();
        }
        $originalCurrentOrder = $currentGroup->order;
        $currentGroup->order = $adjacentGroup->order;
        $adjacentGroup->order = $originalCurrentOrder;
        $adjacentGroup->save();
        $currentGroup->save();
    }

    private function changeOrderLink(Request $request, bool $increase)
    {
        $currentLink = Link::whereId($request->id)->first();
        $parentGroupId = $currentLink->group->id;
        $firstOrder = Link::whereGroupId($parentGroupId)->order()->first()->order;
        $lastOrder = Link::whereGroupId($parentGroupId)->latestOrder()->first()->order;
        $possibleAdjacentOrder = null;
        $adjacentLink = null;
        if ($increase) {
            $possibleAdjacentOrder = Link::whereGroupId($parentGroupId)->where('order', '>', $currentLink->order)->min('order') ?? $firstOrder;
            $adjacentLink = Link::whereOrder($possibleAdjacentOrder <= $lastOrder ? $possibleAdjacentOrder : $firstOrder)->first();
        } else {
            $possibleAdjacentOrder = Link::whereGroupId($parentGroupId)->where('order', '<', $currentLink->order)->max('order') ?? $lastOrder;
            $adjacentLink = Link::whereOrder($possibleAdjacentOrder > 0 ? $possibleAdjacentOrder : 1)->first();
        }
        $originalCurrentOrder = $currentLink->order;
        $currentLink->order = $adjacentLink->order;
        $adjacentLink->order = $originalCurrentOrder;
        $adjacentLink->save();
        $currentLink->save();
    }

    public function getGroups($block_id)
    {
        $groups = Group::whereBlockId($block_id)->get();
        return response()->json(["response" => $groups]);
    }

    private function createBlock(Request $request)
    {
        $block = new Block;
        $block->name = $request->inp_name;
        $latest_block = Block::latestOrder()->first();
        $block->order = isset($latest_block) ? $latest_block->order + 1 : 1;
        $block->archive = false;
        return $block;
    }

    private function createGroup(Request $request)
    {
        $group = new Group;
        $group->name = $request->inp_name;
        $latest_group = Group::latestOrder()->first();
        $group->order = isset($latest_group) ? $latest_group->order + 1 : 1;
        $group->block_id = $request->block_reference;
        return $group;
    }

    private function createLink(Request $request)
    {
        $link = new Link;
        $link->name = $request->inp_name;
        $link->link = $request->inp_link;
        $latest_link = Link::latestOrder()->first();
        $link->order = isset($latest_link) ? $latest_link->order + 1 : 1;
        $link->group_id = $request->group_reference;
        return $link;
    }

    private function editBlock(Request $request)
    {
        $current_app = Block::whereId($request->id)->first();
        $current_app->name = $request->new_name;
        $current_app->archive = !empty($request->new_archive);
        $current_app->save();
    }

    private function editGroup(Request $request)
    {
        $current_group = Group::whereId($request->id)->first();
        $current_group->name = $request->new_name;
        $current_group->block_id = $request->new_app_id;
        $current_group->save();
    }

    private function editLink(Request $request)
    {
        $currentLink = Link::whereId($request->id)->first();
        $currentLink->name = $request->new_name;
        $currentLink->link = $request->new_link;
        $currentLink->group_id = $request->new_group_id;
        $currentLink->save();
    }

    private function deleteBlock(Request $request)
    {
        $block = Block::whereId($request->id)->first();
        $groups = $block->groups;
        foreach ($groups as $group) {
            $group->links->each->delete();
        }
        $groups->each->delete();
        $block->delete();
        $blocks = Block::order()->get();
        $i = 1;
        foreach ($blocks as $block) {
            $block->order = $i;
            $block->save();
            $i++;
        }
    }

    private function deleteGroup(Request $request)
    {
        $group = Group::whereId($request->id)->first();
        $group->links->each->delete();
        $group->delete();
    }

    private function deleteLink(Request $request)
    {
        Link::destroy($request->id);
    }
}
