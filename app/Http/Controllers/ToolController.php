<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{

    public function tools()
    {
        return view('tool.tool', ['tools' => Tool::all()]);
    }

    public function delete($id)
    {
        Tool::find($id)->delete();
        return "done ";
    }

    public function add(Request $request)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $tool = Tool::create($Data);
        return $tool;

    }


    public function edit(Request $request, $id)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $tool = Tool::find($id);
        $tool->update($Data);

        return $tool;
    }



}

