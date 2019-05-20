<?php

namespace App\Http\Controllers\Characters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Character;

class CharactersController extends Controller
{
    public function index()
    {
        $characters = $this->filter();

        return view('characters.index')->with([
            'characters' => $characters,
        ]);
    }

    public function filter()
    {
        return json_encode(Character::paginate(6));
    }
}
