<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use App\Models\Part;

class ReportController extends Controller
{
    public function employee() {
        $active_main = 'report';
        $active_sub = 'report_employee';
        $jobs = Job::where('complete', 'Yes')->where('qty_good', '!=', 0)->where('part_hr', '!=', 0)->get();
        $users = User::all();
        $datas = $each_items =[];
        $sub_count = 0;
        $sub_total = $total = array(
            'user' => array('name' => 'Subtotal/Avg'),
            'updated_at' => '',
            'machine' =>  array('machinename' => '', 'workcell' => ''),
            'part' =>  array('partnumber' => ''),
            'qty_good' => 0,
            'qty_bad' => 0,
            'time_to_complete' => 0,
            'part_hr' => 0
        );
        $total['user']['name'] = 'Total/Avg';

        foreach ($users as $user) {
            foreach ($jobs as $job) {
                if ($user->id == $job->user_id) {
                    $sub_total['time_to_complete'] += $job->time_to_complete;
                    $sub_total['part_hr'] += $job->part_hr;
                    $sub_total['qty_bad'] += $job->qty_bad;
                    $sub_total['qty_good'] += $job->qty_good;
                    array_push($datas, $job);
                }
            }
            if (count($datas) > 0) {
                if ($datas[count($datas)-1]['user']['name'] != 'Subtotal/Avg') {
                    array_push($datas, $sub_total);
                }
            }
            $total['time_to_complete'] += $sub_total['time_to_complete'];
            $total['qty_bad'] += $sub_total['qty_bad'];
            $total['qty_good'] += $sub_total['qty_good'];
            
            $sub_total['time_to_complete'] = 0;
            $sub_total['part_hr'] = 0;
            $sub_total['qty_bad'] = 0;
            $sub_total['qty_good'] = 0;
        }

        foreach ($datas as $data) {
            if ($data['user']['name'] == 'Subtotal/Avg') {
                $sub_count ++;
            }
        }

        if ($sub_count > 1) {
            $total['part_hr'] = number_format($total['time_to_complete'] / $total['qty_good'], 3);
            array_push($datas, $total);
        } else if ($sub_count == 1) {
            $temp = $datas[count($datas)-1];
            unset($datas[count($datas)-1]);
            $temp['user']['name'] = 'Total/Avg';
            $temp['part_hr'] = number_format($temp['time_to_complete'] / $temp['qty_good'], 3);
            array_push($datas, $temp);
        }
        
        return view('report.employee', compact('active_main', 'active_sub', 'datas'));
    }

    public function filteremployee(Request $request) {
        $active_main = 'report';
        $active_sub = 'report_employee';
        $from_date = date('Y-m-d H:i:s', strtotime($request->from_date . ' 00:00:00'));
        $to_date = date('Y-m-d H:i:s', strtotime($request->to_date . ' 23:59:59'));
        $results = Job::where('complete', 'Yes')->where('qty_good', '!=', 0)->where('part_hr', '!=', 0)->whereBetween('updated_at', [$from_date, $to_date])->get();
        foreach ($results as $result) {
            $result->employee = $result->user->name;
            $result->date = date('Y/m/d', strtotime($result->updated_at));
            $result->machinename = $result->machine->machinename;
            $result->workcell = $result->machine->workcell;
            $result->partnumber = $result->part->partnumber;
        }

        return json_encode($results);
    }

    public function partnumber() {
        $active_main = 'report';
        $active_sub = 'report_partnumber';
        $jobs = Job::where('complete', 'Yes')->where('qty_good', '!=', 0)->where('part_hr', '!=', 0)->get();
        $parts = Part::all();
        $datas = $each_items =[];
        $sub_count = 0;
        $sub_total = $total = array(
            'id' => 0,
            'part' => array('partnumber' => 'Subtotal/Avg'),
            'updated_at' => '',
            'machine' =>  array('workcell' => ''),
            'user' =>  array('name' => ''),
            'qty_good' => 0,
            'qty_bad' => 0,
            'time_to_complete' => 0,
            'part_hr' => 0
        );
        $total['part']['partnumber'] = 'Total/Avg';

        foreach ($parts as $part) {
            foreach ($jobs as $job) {
                if ($part->id == $job->partnumber_id) {
                    $sub_total['id'] += $job->partnumber_id;
                    $sub_total['time_to_complete'] += $job->time_to_complete;
                    $sub_total['part_hr'] += $job->part_hr;
                    $sub_total['qty_bad'] += $job->qty_bad;
                    $sub_total['qty_good'] += $job->qty_good;
                    array_push($datas, $job);
                }
            }
            if (count($datas) > 0) {
                if ($datas[count($datas)-1]['part']['partnumber'] != 'Subtotal/Avg') {
                    array_push($datas, $sub_total);
                }
            }
            $total['time_to_complete'] += $sub_total['time_to_complete'];
            $total['qty_bad'] += $sub_total['qty_bad'];
            $total['qty_good'] += $sub_total['qty_good'];
            
            $sub_total['time_to_complete'] = 0;
            $sub_total['part_hr'] = 0;
            $sub_total['qty_bad'] = 0;
            $sub_total['qty_good'] = 0;
        }

        foreach ($datas as $data) {
            if ($data['part']['partnumber'] == 'Subtotal/Avg') {
                $sub_count ++;
            }
        }

        if ($sub_count > 1) {
            $total['part_hr'] = number_format($total['time_to_complete'] / $total['qty_good'], 3);
            array_push($datas, $total);
        } else if ($sub_count == 1) {
            $temp = $datas[count($datas)-1];
            unset($datas[count($datas)-1]);
            $temp['part']['partnumber'] = 'Total/Avg';
            $temp['part_hr'] = number_format($temp['time_to_complete'] / $temp['qty_good'], 3);
            array_push($datas, $temp);
        }

        return view('report.partnumber', compact('active_main', 'active_sub', 'datas', 'parts'));
    }

    public function filterpartnumber(Request $request) {
        $active_main = 'report';
        $active_sub = 'report_partnumber';
        $from_date = date('Y-m-d H:i:s', strtotime($request->from_date . ' 00:00:00'));
        $to_date = date('Y-m-d H:i:s', strtotime($request->to_date . ' 23:59:59'));
        $partnumber_id = $request->part_number;
        $results = Job::where('complete', 'Yes')->where('qty_good', '!=', 0)->where('part_hr', '!=', 0)->where('partnumber_id', $partnumber_id)->whereBetween('updated_at', [$from_date, $to_date])->get();
        foreach ($results as $result) {
            $result->employee = $result->user->name;
            $result->date = date('Y/m/d', strtotime($result->updated_at));
            $result->workcell = $result->machine->workcell;
            $result->partnumber = $result->part->partnumber;
        }

        return json_encode($results);
    }
    
    public function timesheet() {
        $active_main = 'report';
        $active_sub = 'report_timesheet';
        $jobs = Job::where('complete', 'Yes')->get();
        $users = User::all();
        $datas = $each_items =[];
        $sub_count = 0;
        $sub_total = $total = array(
            'user' => array('name' => 'Subtotal/Avg'),
            'updated_at' => '',
            'part' =>  array('partnumber' => ''),
            'qty_good' => 0,
            'qty_bad' => 0,
            'time_to_complete' => 0,
            'part_hr' => 0
        );
        $total['user']['name'] = 'Total/Avg';

        foreach ($users as $user) {
            foreach ($jobs as $job) {
                if ($user->id == $job->user_id) {
                    $sub_total['time_to_complete'] += $job->time_to_complete;
                    $sub_total['part_hr'] += $job->part_hr;
                    $sub_total['qty_bad'] += $job->qty_bad;
                    $sub_total['qty_good'] += $job->qty_good;
                    array_push($datas, $job);
                }
            }
            if (count($datas) > 0) {
                if ($datas[count($datas)-1]['user']['name'] != 'Subtotal/Avg') {
                    array_push($datas, $sub_total);
                }
            }
            $total['time_to_complete'] += $sub_total['time_to_complete'];
            $total['qty_bad'] += $sub_total['qty_bad'];
            $total['qty_good'] += $sub_total['qty_good'];
            
            $sub_total['time_to_complete'] = 0;
            $sub_total['part_hr'] = 0;
            $sub_total['qty_bad'] = 0;
            $sub_total['qty_good'] = 0;
        }

        foreach ($datas as $data) {
            if ($data['user']['name'] == 'Subtotal/Avg') {
                $sub_count ++;
            }
        }

        if ($sub_count > 1) {
            $total['part_hr'] = number_format($total['time_to_complete'] / $total['qty_good'], 3);
            array_push($datas, $total);
        } else if ($sub_count == 1) {
            $temp = $datas[count($datas)-1];
            unset($datas[count($datas)-1]);
            $temp['user']['name'] = 'Total/Avg';
            $temp['part_hr'] = number_format($temp['time_to_complete'] / $temp['qty_good'], 3);
            array_push($datas, $temp);
        }

        return view('report.timesheet', compact('active_main', 'active_sub', 'datas', 'users'));
    }

    public function filtertimesheet(Request $request) {
        $active_main = 'report';
        $active_sub = 'report_timesheet';
        $from_date = date('Y-m-d H:i:s', strtotime($request->from_date . ' 00:00:00'));
        $to_date = date('Y-m-d H:i:s', strtotime($request->to_date . ' 23:59:59'));
        $employee = $request->employee;
        $results = Job::where('complete', 'Yes')->where('user_id', $employee)->whereBetween('updated_at', [$from_date, $to_date])->get();
        foreach ($results as $result) {
            $result->employee = $result->user->name;
            $result->date = date('Y/m/d', strtotime($result->updated_at));
            $result->partnumber = $result->part->partnumber;
        }

        return json_encode($results);
    }
}
