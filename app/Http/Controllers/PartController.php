<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Part;

class PartController extends Controller
{
    public function create() 
    {
        $active_main = 'part';
        $active_sub = 'part_create';

        return view('part.create', compact('active_main', 'active_sub'));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'partnumber' => 'required',
            'description' => 'required',
        ]);
        $inactive = isset($request->inactive) ? 'Yes' : 'No';
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            Part::create([
                'partnumber' => (int)$request->partnumber,
                'description' => $request->description,
                'inactive' => $inactive,
            ]);
        }

        return redirect()->route('part.list');
    }

    public function list() {
        $active_main = 'part';
        $active_sub = 'part_list';
        $datas = Part::all();

        return view('part.list', compact('active_main', 'active_sub', 'datas'));
    }

    public function edit($id) {
        $active_main = 'part';
        $active_sub = 'part_edit';
        $data = Part::find($id);

        return view('part.edit', compact('active_main', 'active_sub', 'data'));
    }

    public function update(Request $request, $id)
    {
        $info = Part::find($id);
        $validator = Validator::make($request->all(),[
            'partnumber' => 'required',
            'description' => 'required',
        ]);
        $inactive = isset($request->inactive) ? 'Yes' : 'No';
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $info->partnumber = (int)$request->partnumber;
            $info->description = $request->description;
            $info->inactive = $inactive;
            $info->save();

            return redirect()->route('part.list');
        }
    }

    public function upload(Request $request)
    {
        $data = array();

        $validator = Validator::make($request->all(), [
           'file' => 'required|mimes:csv'
        ]);
        
        if ($validator->fails()) {
            $data = 'false';
        //    $data['success'] = 0;
        //    $data['error'] = $validator->errors()->first('file');// Error response
            return response()->json('failed');
        } else {
            if($request->file('file')) {
                Part::truncate();

                $file = $request->file('file');
                $contents = $this->csvToArray($file);
                
                for ($i = 0; $i < count($contents); $i ++) {
                    Part::create([
                        'partnumber' => (int)$contents[$i]['PartNumber'],
                        'description' => $contents[$i]['PartDescription'],
                        'inactive' => 'No',
                    ]);
                }
                
                return response()->json('true');
            } else {
                $data = 'false';
            }
        }
  
        return response()->json($data);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
