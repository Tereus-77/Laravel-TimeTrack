<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Part;
use App\Models\Job;

class JobController extends Controller
{
    public function progressjob()
    {
        $active_main = 'job';
        $active_sub = 'job_progress';
        $total_time = '0 hrs 00 m';
        $diff = 0;

        $active_job = Job::where('user_id', Auth::user()->id)->where('active', 'Yes')->get();
        if(count($active_job) > 0) {
            $recorded_date = json_decode($active_job[0]->recorded_date);
            foreach($recorded_date as $each_date)                
                if(strtotime($each_date[1])) $diff += (strtotime($each_date[1]) - strtotime($each_date[0]));
                        
            $total_time = (int)floor($diff/3600) . ' hrs ' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';

            if (($diff/3600-floor($diff/3600))*60 < 10) {
                $total_time = (int)floor($diff/3600) . ' hrs ' . '0' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';
            }  
        }

        $jobs = Job::where('user_id', Auth::user()->id)->where('complete', 'No')->get();

        return view('job.progress', compact('active_main', 'active_sub', 'jobs', 'active_job', 'total_time'));
    }

    public function processjob()
    {
        $active_main = 'job';
        $active_sub = 'job_process';
        $jobs = Job::where('complete', 'No')->get();

        return view('job.process', compact('active_main', 'active_sub', 'jobs'));
    }

    public function startjob() 
    {
        $active_main = 'job';
        $active_sub = 'start';
        $machines = Machine::where('inactive', 'No')->orderBy('machinename', 'ASC')->get();
        $parts = Part::where('inactive', 'No')->orderBy('partnumber', 'ASC')->get();

        return view('job.start', compact('active_main', 'active_sub', 'machines', 'parts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'machinename' => 'required|string',
            'partnumber' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $started_date = $update_date = date('Y-m-d H:i:s');
            $user_id = Auth::user()->id;
            
            // pause old job
            $current_active_job = Job::where('user_id', $user_id)->where('active', 'Yes')->first();
            if ($current_active_job) {
                $current_recorded_date = json_decode($current_active_job->recorded_date);
                $last_date = $current_recorded_date[count($current_recorded_date)-1];
                $last_date[1] = $update_date;
                $current_recorded_date[count($current_recorded_date)-1] = $last_date;
    
                $current_active_job->recorded_date = json_encode($current_recorded_date);
                $current_active_job->active = 'No';
                $current_active_job->save();
            }
            
            // create new job.
            $active = 'Yes';
            $complete = 'No';
            $new_recorded_date = [
                [$started_date, null]
            ];

            Job::create([
                'user_id' => $user_id,
                'started_date' => $started_date,
                'machine_id' => $request->machinename,
                'partnumber_id' => $request->partnumber,
                'active' => $active,
                'complete' => $complete,
                'recorded_date' => json_encode($new_recorded_date),
            ]);

            $part = Part::find($request->partnumber);
            $part->inactive = 'Yes';
            $part->save();

            $machine = Machine::find($request->machinename);
            $machine->inactive = 'Yes';
            $machine->save();
        }

        return redirect()->route('job.progress');
    }

    public function update(Request $request)
    {
        $update_date = date('Y-m-d H:i:s');
        $info = Job::find($request->job);
        $recorded_date = json_decode($info->recorded_date);
        $diff = 0;

        if ($request->action == 'pause') {
            $last_date = $recorded_date[count($recorded_date)-1];
            $last_date[1] = $update_date;
            $recorded_date[count($recorded_date)-1] = $last_date;

            $info->recorded_date = json_encode($recorded_date);
            $info->active = 'No';
            $info->save();

            foreach($recorded_date as $each_date)
                $diff += (strtotime($each_date[1]) - strtotime($each_date[0]));
            
            $total_time = (int)floor($diff/3600) . ' hrs ' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';

            if (($diff/3600-floor($diff/3600))*60 < 10) {
                $total_time = (int)floor($diff/3600) . ' hrs ' . '0' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';
            }

            return json_encode($total_time);

        } else if ($request->action == 'select_item') {
            foreach($recorded_date as $each_date)
                $diff += (strtotime($each_date[1]) - strtotime($each_date[0]));
            
            $total_time = (int)floor($diff/3600) . ' hrs ' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';

            if (($diff/3600-floor($diff/3600))*60 < 10) {
                $total_time = (int)floor($diff/3600) . ' hrs ' . '0' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';
            }

            return json_encode($total_time);

        } else if ($request->action == 'continue') {
            foreach($recorded_date as $each_date)
                $diff += (strtotime($each_date[1]) - strtotime($each_date[0]));
            
            array_push($recorded_date, [$update_date, null]);
            $info->recorded_date = json_encode($recorded_date);            
            $info->active = 'Yes';
            $info->save();

            return json_encode(['hrs' => (int)floor($diff/3600), 'm' =>(int)(($diff/3600-floor($diff/3600))*60)]);

        } else if ($request->action == 'start_job') {
            foreach($recorded_date as $each_date)
                if(strtotime($each_date[1])) $diff += (strtotime($each_date[1]) - strtotime($each_date[0]));

            return json_encode(['hrs' => (int)floor($diff/3600), 'm' =>(int)(($diff/3600-floor($diff/3600))*60)]);            
        }

        return json_encode(true);
    }

    public function completejob($id) 
    {
        $active_main = 'job';
        $active_sub = 'complete';

        $update_date = date('Y-m-d H:i:s');
        $job = Job::find($id);
        $recorded_date = json_decode($job->recorded_date);
        $diff = 0;
        $last_date = $recorded_date[count($recorded_date)-1];
        $last_date[1] = $update_date;
        $recorded_date[count($recorded_date)-1] = $last_date;

        $job->recorded_date = json_encode($recorded_date);
        $job->save();

        foreach($recorded_date as $each_date)
            $diff += strtotime($each_date[1]) - strtotime($each_date[0]);
        
        $total_time = (int)floor($diff/3600) . ' hrs ' . (int)(($diff/3600-floor($diff/3600))*60) . ' m';

        return view('job.complete', compact('active_main', 'active_sub', 'job', 'total_time'));
    }

    public function savejob(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'job' => 'required',
            'good' => 'required',
            'bad' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {             
            $job = Job::find($request->job);
            $recorded_date = json_decode($job->recorded_date);
            $diff = 0;
            foreach($recorded_date as $each_date)
                $diff += strtotime($each_date[1]) - strtotime($each_date[0]);
            $total_time = number_format($diff/3600, 2);
            $request->good > 0 ? $part_hr = number_format($total_time/$request->good, 3) : $part_hr = 0;

            $job->qty_good = $request->good;
            $job->qty_bad = $request->bad;
            $job->time_to_complete = $total_time;
            $job->part_hr = $part_hr;
            $job->active = 'No';
            $job->complete = 'Yes';
            $job->save();

            $part = Part::find($job->part->id);
            $part->inactive = "No";
            $part->save();

            $machine = Machine::find($job->machine->id);
            $machine->inactive = "No";
            $machine->save();
        }

        return redirect()->route('job.progress');
    }
}
