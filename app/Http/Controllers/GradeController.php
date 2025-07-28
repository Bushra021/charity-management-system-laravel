<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

    public function grades()
    {
        return view('grade.grade', ['grades' => Grade::all()]);
    }

    public function delete($id)
    {
        Grade::find($id)->delete();
        return "done ";
    }

    public function add(Request $request)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $grade = Grade::create($Data);
        return $grade;

    }


    public function edit(Request $request, $id)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $grade = Grade::find($id);
        $grade->update($Data);

        return $grade;
    }

}
