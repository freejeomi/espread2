<?php
include "lib/util.php";


// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data=array();
if(isset($_POST['upload_date'])){
    $date=$_POST['upload_date'];
    if(isset($_POST['remark'])){
        $result_select=mysqli_query($conn,"SELECT status FROM upload_log WHERE (request=0 OR request=1) AND status=0 AND upload_date='$date'");
        if(mysqli_num_rows($result_select)>0){
            $remark=$_POST['remark'];
            $date=$_POST['upload_date'];
            $request=$_POST['request'];
            $result_update=mysqli_query($conn,"UPDATE upload_log SET remark='$remark',request=$request WHERE upload_date='$date'");
            if($result_update){
                $data['success']=true;
                $data['message']="Your request has been successfully sent";
            }
            else{
                $data['success']=false;
                $data['message']="Request not successfully sent";
            }
        }
        else{
            $data['success']=false;
            $data['message']="Request has been sent and approval received, system has been unlocked";
        }


    }
    if(isset($_POST['status'])){
        $status=$_POST['status'];
        $date=$_POST['upload_date'];
        $request=$_POST['request'];
        $result_update=mysqli_query($conn,"UPDATE upload_log SET status='$status',request=$request WHERE upload_date='$date'");
        if($result_update){
            $data['success']=true;
            $data['message']="Your request has been successfully approved.";
        }
        else{
            $data['success']=false;
            $data['message']="Approval not successful yet.";
        }
    }
    $table_record= "";
    $result_log= mysqli_query($conn, "select * from upload_log where request != 0 OR status != 0 order by upload_date DESC ");
    if (mysqli_num_rows($result_log) > 0) {
        while ($row= mysqli_fetch_assoc($result_log) ) {
            $date= $row['upload_date'];
            $remark= $row['remark'];
            $status= $row['status'];
            $request= $row['request'];

            if ($status == 0 && $request == 1) {
                $current_state= "pending";
            }
            else {
                $current_state= "approved";
            }
            $table_record.= '<tr><td>' . date("d-m-Y",strtotime($date)) . '</td><td>' . $remark . '</td><td>'. $current_state. '</td><td><button class="btn btn-primary btn-xs check_approval" onclick="do_request(this)"><input type="hidden"  value="'.$date.'">Check Approval</button></td></tr>';
        }
    }

}
$data['table']=$table_record;
echo json_encode($data);