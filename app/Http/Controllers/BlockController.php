<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Block;

class BlockController extends Controller
{

    public function show()
    {

        // Getting all the active blocks
        $active_blocks = Block::active()->order()->get();

        // Getting all the archived blocks
        $archived_blocks = Block::archive()->order()->get();

        // Returning the index view
        return view("index", [
            'active_blocks' => $active_blocks,
            'archived_blocks' => $archived_blocks
        ]);
    }
}
