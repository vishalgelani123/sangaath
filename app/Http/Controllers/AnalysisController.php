<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\mytimesheet;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Auth;
use Mail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function user_timesheet_analysis()
    {
        $ro1 = DB::table('users')->where('status','Active')->get(['Reporting_officer','reporting1_email']);
        $ro2 = DB::table('users')->where('status','Active')->get(['Reporting_officer_2','reporting2_email'])->toArray();
        $ro1Arr = array();
        foreach ($ro1 as $key => $value1) {
            $ro1Arr[$key]['Name'] = $value1->Reporting_officer;
            $ro1Arr[$key]['email'] = $value1->reporting1_email;
        }
        $ro2Arr = array();
        foreach ($ro2 as $key => $value1) {
            $ro2Arr[$key]['Name'] = $value1->Reporting_officer_2;
            $ro2Arr[$key]['email'] = $value1->reporting2_email;
        }
        // $merged = array_merge($ro1Arr,$ro2Arr);
        $merged[] = array('Name'=>'Mukeshgiri Goswami', 'email'=>'mukeshgiri.goswami@deepakfoundation.org');
        $merged[] = array('Name'=>'Dr Jai Pawar', 'email'=>'jai.pawar@deepakfoundation.org');

        //get All RO1 and RO2 in one array
        $newROarr = array();
        foreach ($merged as $key3 => $value3) {
            $newROarr[$value3['email']]['Name'] = $value3['Name'];
            $newROarr[$value3['email']]['email'] = $value3['email'];
            // print_r($value3['Name']);
        }
        //Check for Team size to all reporting officer 1 & 2
        $getTeamEmails = new Collection();
        foreach ($newROarr as $key => $value) {
            $getTeamEmails[$key] = DB::table('users')->where('reporting1_email',$value['email'])->orWhere('reporting2_email',$value['email'])->get(['email']);
        }
        $AllTeamArr = array();
        $NotfillingArr = array();
        foreach ($getTeamEmails as $ro_key => $team) {
            $teamArr = new Collection();
            $mainArr = array();
            // $notfill = array();
            foreach ($team as $team_key => $team_email) {
                // print_r($team_email->email);
                $sdt = new Carbon('first day of this month');
                $edt = new Carbon('last day of this month');
                $start = '2022-01-01'; //$sdt->format('Y-m-d'); //changehere
                $end = '2022-03-22'; //$edt->format('Y-m-d'); //changehere
                $timesheet_data = DB::table('mytimesheet')->where('email',$team_email->email)
                ->whereBetween('Date',array($start,$end))->select('Date','task_code','Hours','email')->get();
                if (count($timesheet_data) <= 0) {
                    $notfill = DB::table('users')->where('email', $team_email->email)->get(['Emp_id','Name']);
                    $NotfillingArr[$ro_key][] = $notfill[0]; /// if data not found by email address
                }
                //     print_r($notfill);
                // exit();
                //Separate the code by ';' and create new array
                $data1 = array();
                $data2 = array();
                $email = '';
                foreach ($timesheet_data as $k => $v) {
                    $data1[$k] = explode(";", str_replace(' ','', $v->task_code));
                    $data2[$k] = explode(";", str_replace(' ','', $v->Hours));
                    $email = $v->email;
                }
                $finalarr = array();
                if ($data1 != null || $data2 != null) {
                    $result1 = call_user_func_array('array_merge',$data1);
                    $result2 = call_user_func_array('array_merge',$data2);
                    $code = new Collection($result1);
                    $hrs = new Collection($result2);
                    $unique = $code->unique();
                    $uniqueCode = $unique->values()->all();
                    $zipped = $code->zip($hrs);
                    $grp = $zipped->groupBy('0');
                    //put email address of team mmeber & create array
                    $finalarr[$email] = $grp->toArray();
                }
                //Now run count and analysis
                foreach ($finalarr as $key_email => $team_value) {
                    foreach ($team_value as $key_code => $value_code) {
                        $total = 0;
                        for ($i= 0; $i < sizeof($value_code); $i++) { 
                            $total  = $total + (float)$value_code[$i][1];
                            $mainArr[$key_email][$key_code] = $total;
                        }
                    }
                }
            }
            $AllTeamArr[$ro_key] = $mainArr;
        }
            // print_r($NotfillingArr);
        // exit();
        $finalTeamArray = array();
        foreach ($AllTeamArr as $key_ro => $value_ro) {
            // Create team wise analysis and generate new team array for html prininting
            $individualArr = array();
            foreach ($value_ro as $key1 => $value1) {
                $name = DB::table('users')->where('email',$key1)->get(['Name','id']);
                // Add Name of team members
                $individualArr[$key_ro][$key1][] = $name[0]->Name;// array position 0
                // Add Sum of total hours
                $array_total = array_sum($value1);
                $individualArr[$key_ro][$key1][] = $array_total; // array position 1 
                // Top thee Code and it's %, From Array
                arsort($value1); // Sort array based on value
                // print_r($value1);
                $taskcode = array(); // new array for task code ananlysis
                foreach ($value1 as $k1 => $v1) {
                    if ($v1 == 0) {
                        $percent1 = 0;
                        $taskcode[$k1] = round($percent1, 2);
                    }else{
                        $percent1 = (($v1/$array_total)*100);
                        $taskcode[$k1] = round($percent1, 2); 
                    }
                    // print_r(round($percent1, 2));
                }
                $array1 = array(); //for first three code
                $array2 = array(); //for remaining other coes
                if (sizeof($taskcode) > 3) {
                    $array1 = array_slice($taskcode, 0, 3);
                    $array2 = array_slice($taskcode, 3, sizeof($taskcode));
                    // print_r($sum);exit();
                }else{
                    $array1 = $taskcode;
                }
                // $sum = array_sum($array2);
                // array_merge($array1, array('Other'=>$sum));
                // print_r($array1);exit();
                // print_r($array1)
                $individualArr[$key_ro][$key1][] = json_encode($array1);
                //get top three project code details
                $sdt = new Carbon('first day of this month');
                $edt = new Carbon('last day of this month');
                $start = '2022-01-01'; //$sdt->format('Y-m-d'); //changehere
                $end = '2022-03-22'; //$edt->format('Y-m-d'); //changehere
                $data9 = DB::table('mytimesheet')->where('email',$key1)->whereBetween('Date',array($start,$end))->select('Project','Date')->get();
                $prj_str = '';
                $timesheetDays = array(); // array for no. of days timesheet filled
                foreach ($data9 as $prj_key => $prj_value) {
                    $prj_str .= $prj_value->Project.';';
                    $timesheetDays[$prj_value->Date][] = 1;
                }
                $individualArr[$key_ro][$key1][] = sizeof($timesheetDays); // array position 2 // add no of days timeshett filled. 
                //explode project string and run frequency
                $explodeArr = array();
                $explodeArr = explode(';', $prj_str);
                $valCount = array_count_values($explodeArr);
                arsort($valCount);
                $firstThree = json_encode(array_slice($valCount, 0, 3));
                $individualArr[$key_ro][$key1][] = $firstThree; // array position 3
                //Check monthly_planer table for monthly planning of this.
                $monthlyData = DB::table('monthly_planer')->where('user_id', $name[0]->id)->whereBetween('start',array($start,$end))->get(['id','start']);
                $monthlyplanDays = array();
                $monthlyplanActivities = array();
                foreach ($monthlyData as $key45 => $value45) {
                    $monthlyplanDays[$value45->start][] = 1;
                    $monthlyplanActivities[$value45->id][] = 1;
                }
                $individualArr[$key_ro][$key1][] = sizeof($monthlyplanDays); // array position 4
                $individualArr[$key_ro][$key1][] = sizeof($monthlyplanActivities); // array position 5
            }
            if ($individualArr != null) {
                    $finalTeamArray[] = $individualArr;
            }   
        }
        // print_r($finalTeamArray);
        // print_r($NotfillingArr);exit();
        //send mail to RO1 and RO2
        $pathimage='/logo/mail_logo.jpg';
        $pathimage2='/logo/analysis.png';
        $pathimage3='/logo/analysis2.png';
        $pathimage4='/logo/notfilling.png';
        $url=url("http://app.deepakfoundation.org");
    //   echo '<pre>';  print_r($finalTeamArray);die;
        foreach ($finalTeamArray as $key5 => $value5) {
            foreach ($value5 as $key6 => $value6) {
                unset($value6['srisailam.kosika@deepakfoundation.org']);
                unset($value6['abhaysahay24@gmail.com']);
                unset($value6['anufazalsri@gmail.com']);
                unset($value6['dr.pinky1980@gmail.com']);
                unset($value6['chrevathi7554@gmail.com']);
                unset($value6['subumishra@gmail.com']);
                
                 if ($key6 == "mukeshgiri.goswami@deepakfoundation.org") { // specific send mail
                    $ro1_team = DB::table('users')->where('status','Active')->where('reporting1_email',$key6)->count();
                    $ro2_team = DB::table('users')->where('status','Active')->where('reporting2_email',$key6)->count();
                    $no_of_filling = count($value6);
                    $teamdata = json_encode($value6);
                    if (array_key_exists($key6, $NotfillingArr)) {
                        $notFilledArr = json_encode($NotfillingArr[$key6]);
                    }else{
                        $notFilledArr = json_encode(array());
                    }
                    // $notFilledArr =json_encode(array());
                    $data=array(
                    'username'=>$key6, // HOD Name - add email of HOD instead of name
                    'useremail'=>$key6, //RO1 & RO2 mail  
                    'title'=>"Your Team Timesheet & Monthly Plan Analytics | Monthly Edition", 
                    'content'=>"Discover your team productivity", 
                    'url'=>$url,
                    'teamdata'=> $teamdata, 
                    'monthname'=> "Jan 2022 to March 2022", //change here
                    'ro1_team'=> $ro1_team, 
                    'ro2_team'=> $ro2_team, 
                    'no_of_filling'=> $no_of_filling, 
                    'notFilledArr'=> $notFilledArr, 
                    'pathimage'=>$pathimage, 
                    'pathimage2'=>$pathimage2,
                    'pathimage3'=>$pathimage3,
                    'pathimage4'=>$pathimage4
                    );
                // echo '<pre>';    print_r($data);
                    Mail::send('timesheet.email.monthlyanalysis', $data, function($message) use($data)
                    {
                        $message->from('support1@deepakfoundation.org','Timehseet & Monthly Plan Analytics | Monthly Edition');
                     //   $message->to($data['useremail'],$data['username']);
                     $message->to('rohit.gilbile@deepakfoundation.org',$data['username']);
                        $message->subject($data['title']);
                    }); 
                 } // if end for send mail
            }
        }
      //  print_r("Analysis of timesheet Mail Send!!!");
        exit();
        
    }//end of function
   

    public function timesheet_analysis()
    {
        $ro1 = DB::table('users')->where('status','Active')->get(['Reporting_officer','reporting1_email']);
        $ro2 = DB::table('users')->where('status','Active')->get(['Reporting_officer_2','reporting2_email'])->toArray();
        $ro1Arr = array();
        foreach ($ro1 as $key => $value1) {
            $ro1Arr[$key]['Name'] = $value1->Reporting_officer;
            $ro1Arr[$key]['email'] = $value1->reporting1_email;
        }
        $ro2Arr = array();
        foreach ($ro2 as $key => $value1) {
            $ro2Arr[$key]['Name'] = $value1->Reporting_officer_2;
            $ro2Arr[$key]['email'] = $value1->reporting2_email;
        }
        $merged = array_merge($ro1Arr,$ro2Arr);
        //get All RO1 and RO2 in one array
        $newROarr = array();
        foreach ($merged as $key3 => $value3) {
            $newROarr[$value3['email']]['Name'] = $value3['Name'];
            $newROarr[$value3['email']]['email'] = $value3['email'];
            // print_r($value3['Name']);
        }
        //Check for Team size to all reporting officer 1 & 2
        $getTeamEmails = new Collection();
        foreach ($newROarr as $key => $value) {
            $getTeamEmails[$key] = DB::table('users')->where('status','Active')->where('reporting1_email',$value['email'])->orWhere('reporting2_email',$value['email'])->get(['email']);
        }
        $AllTeamArr = array();
        $NotfillingArr = array();
        foreach ($getTeamEmails as $ro_key => $team) {
            $teamArr = new Collection();
            $mainArr = array();
            // $notfill = array();
            foreach ($team as $team_key => $team_email) {
              
                $sdt = new Carbon('first day of this month');
                $edt = new Carbon('last day of this month');
                $start = '2022-02-01'; //$sdt->format('Y-m-d'); //changehere
                $end = '2022-02-28'; //$edt->format('Y-m-d'); //changehere
                $timesheet_data = DB::table('mytimesheet')->where('email',$team_email->email)
                ->whereBetween('Date',array($start,$end))->select('Date','task_code','Hours','email')->get();
                if (count($timesheet_data) <= 0) {
                    $notfill = DB::table('users')->where('email', $team_email->email)->where('status','Active')->get(['Emp_id','Name']);
                    if(!empty($notfill[0])){
                        $NotfillingArr[$ro_key][] = $notfill[0]; /// if data not found by email address
                    }
                }
                //     print_r($notfill);
                // exit();
                //Separate the code by ';' and create new array
                $data1 = array();
                $data2 = array();
                $email = '';
                foreach ($timesheet_data as $k => $v) {
                    $data1[$k] = explode(";", str_replace(' ','', $v->task_code));
                    $data2[$k] = explode(";", str_replace(' ','', $v->Hours));
                    $email = $v->email;
                }
                $finalarr = array();
                if ($data1 != null || $data2 != null) {
                    $result1 = call_user_func_array('array_merge',$data1);
                    $result2 = call_user_func_array('array_merge',$data2);
                    $code = new Collection($result1);
                    $hrs = new Collection($result2);
                    $unique = $code->unique();
                    $uniqueCode = $unique->values()->all();
                    $zipped = $code->zip($hrs);
                    $grp = $zipped->groupBy('0');
                    //put email address of team mmeber & create array
                    $finalarr[$email] = $grp->toArray();
                }
                //Now run count and analysis
                foreach ($finalarr as $key_email => $team_value) {
                    foreach ($team_value as $key_code => $value_code) {
                        $total = 0;
                        for ($i= 0; $i < sizeof($value_code); $i++) { 
                            $total  = $total + (float)$value_code[$i][1];
                            $mainArr[$key_email][$key_code] = $total;
                        }
                    }
                }
            }
            $AllTeamArr[$ro_key] = $mainArr;
        }
        // echo '<pre>';       
        // print_r($AllTeamArr);
        // exit();
        $finalTeamArray = array();
        $i=1;
        foreach ($AllTeamArr as $key_ro => $value_ro) {
            // Create team wise analysis and generate new team array for html prininting
            $individualArr = array();
            foreach ($value_ro as $key1 => $value1) {
                $name = DB::table('users')->where('email',$key1)->where('status','Active')->get(['Name','id','reporting1_email','reporting2_email']);
                if(!empty($name[0])) {
                    // 01 Add Name of team members
                    // Add Sum of total hours
                    $array_total = array_sum($value1);
                    // Top thee Code and it's %, From Array
                    arsort($value1); // Sort array based on value
                    // print_r($value1);
                    $taskcode = array(); // new array for task code ananlysis
                    foreach ($value1 as $k1 => $v1) {
                        if ($v1 == 0) {
                            $percent1 = 0;
                            $taskcode[$k1] = round($percent1, 2);
                        }else{
                            $percent1 = (($v1/$array_total)*100);
                            $taskcode[$k1] = round($percent1, 2); 
                        }
                        // print_r(round($percent1, 2));
                    }
                    $array1 = array(); //for first three code
                    $array2 = array(); //for remaining other coes
                    if (sizeof($taskcode) > 3) {
                        $array1 = array_slice($taskcode, 0, 3);
                        $array2 = array_slice($taskcode, 3, sizeof($taskcode));
                        // print_r($sum);exit();
                    }else{
                        $array1 = $taskcode;
                    }
                   
                    //get top three project code details
                    $sdt = new Carbon('first day of this month');
                    $edt = new Carbon('last day of this month');

                    $start = '2022-02-01'; //$sdt->format('Y-m-d'); //changehere
                    $end = '2022-02-28'; //$edt->format('Y-m-d'); //changehere
                    $monthName = $sdt->format('Y-m');
                    $data9 = DB::table('mytimesheet')->where('email',$key1)->whereBetween('Date',array($start,$end))->select('Project','Date')->get();
                    $prj_str = '';
                    $timesheetDays = array(); // array for no. of days timesheet filled
                    foreach ($data9 as $prj_key => $prj_value) {
                        $prj_str .= $prj_value->Project.';';
                        $timesheetDays[$prj_value->Date][] = 1;
                    }
                    //explode project string and run frequency
                    $explodeArr = array();
                    $explodeArr = explode(';', $prj_str);
                    $valCount = array_count_values($explodeArr);
                    arsort($valCount);
                    $firstThree = json_encode(array_slice($valCount, 0, 3));
                    //Check monthly_planer table for monthly planning of this.
                    $monthlyData = DB::table('monthly_planer')->where('user_id', $name[0]->id)->whereBetween('start',array($start,$end))->get(['id','start']);
                    $monthlyplanDays = array();
                    $monthlyplanActivities = array();
                    foreach ($monthlyData as $key45 => $value45) {
                        $monthlyplanDays[$value45->start][] = 1;
                        $monthlyplanActivities[$value45->id][] = 1;
                    }
                    $newData = array(
                            'user_id'=>$name[0]->id,
                            'ro1_id'=>$name[0]->reporting1_email,
                            'ro2_id'=>$name[0]->reporting2_email,
                            'month'=>$monthName,
                            'days'=>sizeof($timesheetDays),
                            'hours'=>round($array_total,2),
                            'top3taskCode'=>json_encode($array1),
                            'top3project'=> $firstThree
                        );
                }
            }
            $ifExists = DB::table('timesheet_analysis')->where('user_id',$name[0]->id)->where('month',$monthName)->count();
            if($ifExists <= 0){
                DB::table('timesheet_analysis')->insert(
                $newData 
                );
            }
            if ($individualArr != null) {
                    $finalTeamArray[] = $individualArr;
            }
            $i++;
        }
        print_r("All members Analytics Store in DB Cron Ready");exit(); 
        // die;
        // print_r($finalTeamArray);exit();
        //send mail to RO1 and RO2
        $pathimage='/logo/mail_logo.jpg';
        $pathimage2='/logo/analysis.png';
        $pathimage3='/logo/analysis2.png';
        $pathimage4='/logo/notfilling.png';
        $url=url("http://app.deepakfoundation.org");
        foreach ($finalTeamArray as $key5 => $value5) {
            foreach ($value5 as $key6 => $value6) {
                // if ($key6 == "priya.chakraborty@deepakfoundation.org") { // specific send mail
                    $ro1_team = DB::table('users')->where('status','Active')->where('reporting1_email',$key6)->count();
                    $ro2_team = DB::table('users')->where('status','Active')->where('reporting2_email',$key6)->count();
                    $no_of_filling = count($value6);
                    $teamdata = json_encode($value6);
                    if (array_key_exists($key6, $NotfillingArr)) {
                        $notFilledArr = json_encode($NotfillingArr[$key6]);
                    }else{
                        $notFilledArr = json_encode(array());
                    }
                    // $notFilledArr = json_encode();
                    $data=array(
                    'username'=>$key6, // HOD Name - add email of HOD instead of name
                    'useremail'=>$key6, //RO1 & RO2 mail  
                    'title'=>"Your Team Timesheet & Monthly Plan Analytics | Monthly Edition", 
                    'content'=>"Discover your team productivity", 
                    'url'=>$url,
                    'teamdata'=> $teamdata, 
                    'monthname'=> "Feb 2022", //changehere
                    'ro1_team'=> $ro1_team, 
                    'ro2_team'=> $ro2_team, 
                    'no_of_filling'=> $no_of_filling, 
                    'notFilledArr'=> $notFilledArr, 
                    'pathimage'=>$pathimage, 
                    'pathimage2'=>$pathimage2,
                    'pathimage3'=>$pathimage3,
                    'pathimage4'=>$pathimage4
                    );
echo '<pre>';print_r($data);
echo '<br/>****************************************************************************** <br/>';
                  /*  Mail::send('timesheet.email.monthlyanalysis', $data, function($message) use($data)
                    {
                        $message->from('support1@deepakfoundation.org','Timehseet & Monthly Plan Analytics | Monthly Edition');
                        $message->to($data['useremail'],$data['username']);
                        // $message->to('rohit.gilbile@deepakfoundation.org',$data['username']);
                        $message->subject($data['title']);
                    }); */
  
                //  } // if end for send mail 
            }
        }
        die;
        print_r("Analysis of timesheet Mail Send!!!");
        exit();
        
    }//end of function

}//main function
