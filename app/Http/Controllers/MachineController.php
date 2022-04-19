<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Machine;

class MachineController extends Controller
{
    public function create() {
        $active_main = 'machine';
        $active_sub = 'machine_create';

        return view('machine.create', compact('active_main', 'active_sub'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'machinename' => 'required|string',
            'workcell' => 'required|string',
        ]);
        $inactive = isset($request->inactive) ? 'Yes' : 'No';
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
                    
            Machine::create([
                'machinename' => $request->machinename,
                'workcell' => $request->workcell,
                'inactive' => $inactive,
            ]);
        }

        return redirect()->route('machine.list');
    }

    public function list() {
        $active_main = 'machine';
        $active_sub = 'machine_list';
        $datas = Machine::all();

        return view('machine.list', compact('active_main', 'active_sub', 'datas'));
    }

    public function edit($id) {
        $active_main = 'machine';
        $active_sub = 'machine_edit';
        $data = Machine::find($id);

        return view('machine.edit', compact('active_main', 'active_sub', 'data'));
    }

    public function update(Request $request, $id)
    {
        $info = Machine::find($id);
        $validator = Validator::make($request->all(),[
            'machinename' => 'required|string',
            'workcell' => 'required|string',
        ]);
        $inactive = isset($request->inactive) ? 'Yes' : 'No';
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $info->machinename = $request->machinename;
            $info->workcell = $request->workcell;
            $info->inactive = $inactive;
            $info->save();

            return redirect()->route('machine.list');    
        }
    }
}
