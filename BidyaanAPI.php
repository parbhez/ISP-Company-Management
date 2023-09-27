<?php







defined('BASEPATH') or exit('No direct script access allowed');







class Api extends CI_Controller

{



    public $source = 'C:\Users\Farhad\Desktop\A-image\source\20230176.jpg';

    public $destination = 'C:\Users\Farhad\Desktop\A-image\destination';

    public $quality = "90";



    // $d = compress($source_img, $destination_img, 90);





    public function compress($source, $destination, $quality) {



        echo "Hi";

        exit();



        $info = getimagesize($source);



        if ($info['mime'] == 'image/jpeg')

            $image = imagecreatefromjpeg($source);



        elseif ($info['mime'] == 'image/gif')

            $image = imagecreatefromgif($source);



        elseif ($info['mime'] == 'image/png')

            $image = imagecreatefrompng($source);



        imagejpeg($image, $destination, $quality);



        return $destination;

    }









    public function test()

    {

        //echo $date = date('Y-m-d H:i:s');

        date_default_timezone_set("Asia/dhaka");

        // print_r(date("H:i:s A"));

        //echo $punch_time = date("h:i:s A", strtotime($date));





        $this->db2 = $this->load->database('another_db', TRUE);

        $device =  $this->db->select('*')->from('device_setting')->where('device_for', 'student')->get()->row();

        // $tempData = $this->db2->select('*')->from('records')->where('device_serial_num', $device->serial_no)->get()->result();



        $tempData = $this->db2->select('*')->from('machine_command')->get()->result();



        echo "<pre>";

        print_r($tempData);





    }



  //Connect API

  public function get_api_student()

  {



      $service_url = "https://aimskafrul.bidyaan.com/cronjob/aims_student_list";

      $curl = curl_init($service_url);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

      //execute the session

      $curl_response = curl_exec($curl);

      //finish off the session

      curl_close($curl);

      $curl_jason = json_decode($curl_response, true);

     // echo "<pre>";

      //print_r($curl_jason);



      $students = $this->db->select("id,admission_no,photo, status_type")->from('students') ->where('status_type', 'regular')->get()->result();

      $AdmissionNO_array = array_column($students, 'admission_no');

      $AdmissionNO_array = array_unique($AdmissionNO_array);

      echo "<pre>";

      print_r($students);

      exit();



      $i = 0;

     foreach($curl_jason as $key=>$row){

          if(in_array($row['admission_no'], $AdmissionNO_array)){

              $i++;

              $this->db->where('admission_no', $row['admission_no']);

              $this->db->update('students', [

                  'photo' => $row['photo']

              ]);

          }

     }



     if($i > 0){

       echo "Total Update Row = " . $i;

     }else{

      echo "No update";

     }



  }





    public function studentPushInDevice()

    {



        // echo "Hi";

        // exit();

        //delete duplicate data from mysql table

        // DELETE S1 FROM enrollments AS S1 INNER JOIN enrollments AS S2 WHERE S1.id < S2.id AND S1.student_id = S2.student_id;



    $this->db2 = $this->load->database('another_db', TRUE);

    $deviceSn =  $this->db->select('*')->from('device_setting')->where('device_for','student')->get()->row()->serial_no;

    // $deviceSn =  'ZXQJ10012031';



    //Delete machine data

    $machinedata = $this->db2->select('*')->from('machine_command')->where('serial',$deviceSn)->get()->result();





    //  echo "<pre>";

    //  print_r($machinedata);

    //  exit();





    $get_all_students = $this->db->select('S.id, S.name, S.photo')

    ->from('students AS S')

    ->get()->result();



    //  echo "<pre>";

    //  print_r($get_all_students);

    //  exit();



    $i=0;

    foreach ($get_all_students as $key => $row) {



       //1st step

       $command['serial']=$deviceSn;

       $command['name']='setusername';

       $command['content']='{"cmd":"setusername","count":1,"record":[{"enrollid":'.$row->id.',"name":"'.$row->name.'"}]}';

       $command['status']=0;

       $command['send_status']=0;

       $command['err_count']=0;

       $command['gmt_crate']= date('Y-m-d H:i:s');

       $command['gmt_modified']= date('Y-m-d H:i:s');

       $this->db2->insert('machine_command',$command);



       // //2nd step

       if(isset($row->photo) && !empty($row->photo)){

        $file_tmp = base_url()."assets/uploads/student-photo/".$row->photo;

        $data = file_get_contents($file_tmp);

        $img = base64_encode($data);

        $command['serial']=$deviceSn;

        $command['name']='setuserinfo';

        $command['content']='{"cmd":"setuserinfo","enrollid":'.$row->id.',"name":"'.$row->name.'","backupnum":50,"admin":0,"record":"'.$img.'"}';

        $this->db2->insert('machine_command',$command);

       }

       $i++;

    }

     if($i > 0){

        echo "Total Store Student = ". $i;

    }else{

        echo "NO";

    }

}







}







