<?php
require('fpdf.php');
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "roda28";
$dbName = "reservation_system";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword,$dbName);

/*$sql = "SELECT * from reports
        INNER JOIN users
        ON reports.*";*/

if(ISSET($_POST['filter'])){

  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

       $from_date1 = str_replace("-","",$from_date);
       $to_date1 = str_replace("-","",$to_date);

  $sql ="select * from reports"; 
  $re = mysqli_query($conn,$sql);
//WHERE checkout =3";//*where id = '$pid'*/ "
 $userst = "<a href='users.php' class='list-group-item'><span class='' aria-hidden='true'></span> Users <span class='badge'>";
                               
                $sql2 = "SELECT * FROM users where = 35";
                $result = mysqli_query($conn, $sql2);
                //$queryResults = mysqli_num_rows($result);
                //echo "$queryResults";
              
                $usersend = "</span></a>";
//$sql1 ="select * from customers where cust_id =10";
//$re1 = mysqli_query($conn,$sql1);

   $n=0;
   $tax =0;
   $TotalRate =0;
   $allTotal=0;
   $pay=0;
   $balance=0;
   $checkin2 =20180215;
   $checkout2 =20180218;


class PDF extends fpdf{

	function header(){

			 //$this->Image('logo.png',10,6,30);
			 $this->SetFont('Times','B',15);
			 $this->Cell(50);
			 $this->Cell(0,0,'Summary Report of Rock Garden Resort',0,0,'L');

			 $this->Ln(15);

	}

	function chapter(){

//hindi ko alam kung para saan itomg fucntion pero kapag dinelete mo siya wala namang mangyayari sa system
	}

	



	

	function Layout(){
//hindi ko alam kung para saan itomg fucntion pero kapag dinelete mo siya wala namang mangyayari sa system

	}

	function footer(){

			   $this->SetY(-15);
    // Arial italic 8
   			 $this->SetFont('Arial','I',8);
    // Page number
   			 $this->Cell(0,10,'Page '.$this->PageNo()/*Kapag nilagay mo yung {nb} nagkakaroon ng duplicate number 1 sa footer*/,0,0,'R');

	}
	function MyheaderTable(){
		$this->SetFillColor(255,255,255);//ito ay para sa header ng table
    $this->SetTextColor(0);//ito naman yung para sa text ng lahat
    	//$this->SetDrawColor(128,192,0);//ito naman para sa line ng table
    $this->SetLineWidth(.3);
    $this->SetFont('','B', 10);
	
		$this->Cell(10,15,'No.',1,0,'C',true); //nilalagay yung 'true' para makulayan ng SetFillColor(); 
		$this->Cell(38,15,'Customers Name',1,0,'C',true);
		$this->Cell(20,15,'Checkin',1,0,'C',true);
		$this->Cell(20,15,'Checkout',1,0,'C',true);
		$this->Cell(23,15,'Total Amount',1,0,'C',true);//C for Center 'L' for Left 'R' for right
		$this->Cell(23,15,'Amount Paid',1,0,'C',true);
		$this->Cell(20,15,'Status',1,0,'C',true);
		$this->Cell(40,15,'Incharge',1,0,'C',true);
		$this->Ln();

	}
	

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

while($row=mysqli_fetch_array($result))
  {
   $user_id = $row['user_id'];
   $user_first= $row['user_first'];
   $user_last= $row['user_last'];
  // $cust_contact= $row['cust_contact'];
   //$cust_email= $row['cust_email'];

 
    /*$cin_date = $row['cin'];
    $cout_date = $row['cout'];
    $nodays = $row['nodays'];*/
        //$pdf->Cell(0,10,''.$CId,1,0,'L');
        $pdf->Ln();
      $pdf->Cell(0,0,'Printed by: '.$user_first.' '.$user_last,0,0,'L');
      $pdf->Ln(10);
      //$pdf->Cell();
      
      
  
  }

/*while($row=mysqli_fetch_array($re1))
  {
   $cust_id = $row['cust_id'];
   $cust_first= $row['cust_first'];
   $cust_last= $row['cust_last'];
   $cust_contact= $row['cust_contact'];
   $cust_email= $row['cust_email'];

 
    /*$cin_date = $row['cin'];
    $cout_date = $row['cout'];
    $nodays = $row['nodays'];*/
    		//$pdf->Cell(0,10,''.$CId,1,0,'L');
    		//$pdf->Ln();
			//$pdf->Cell(0,0,'Printed by: '.$cust_first.' '.$cust_last,0,0,'L');
			//$pdf->Ln(10);
			//$pdf->Cell();
			
			
  
  
$pdf->MyheaderTable();
$pdf->SetFont('Arial','i',10);
 while($row=mysqli_fetch_array($re))
  {
   $rep_id = $row['rep_id'];
   $cust_name= $row['cust_name'];
   $checkin= $row['checkin'];
   $checkout= $row['checkout'];
   $total_amount= $row['total_amount'];
   $amount_paid =$row['amount_paid'];
   $cash_rendered =$row['cash_rendered'];
   $status =$row['status'];
   $user_incharge =$row['user_incharge'];

   $checkout1 = str_replace("-","",$checkout);
   $checkin1 = str_replace("-","",$checkin);

   //$n++;
   //$TotalRate = $TotalRate + $roomRate;
   //$allTotal = $allTotal+($roomRate *$checkout);
    /*$cin_date = $row['cin'];
    $cout_date = $row['cout'];
    $nodays = $row['nodays'];*/
   // if($checkin >= $checkin1){
    if($checkout1 <= $from_date1 || $to_date1 <=$checkout1 ){
    	 	$n++;
    		$pdf->Cell(10,10,''.$n,1,0,'L');
			$pdf->Cell(38,10,''.$cust_name,1,0,'L');
			$pdf->Cell(20,10,''.$checkin,1,0,'L');
			$pdf->Cell(20,10,''.$checkout,1,0,'L');
			$pdf->Cell(23,10,'P'.$total_amount.'.00',1,0,'L');
			$pdf->Cell(23,10,'P'.$amount_paid.'.00',1,0,'L');
			//$pdf->Cell(10,10,''.$cash_rendered.'.00',1,0,'L');
			$pdf->Cell(20,10,''.$status,1,0,'L');
			$pdf->Cell(40,10,''.$user_incharge,1,0,'L');
			$pdf->Ln();
			$TotalRate = $TotalRate +$total_amount;

			
  }//}
  }
//for($i=1;$i<=40;$i++)
    //$pdf->Cell(0,10,'Printing line number '.$i,0,1);
//$pdf->headerTable();
 // $balance = $allTotal-$pay;
  $tax = $TotalRate *.12;

  $balance = $TotalRate-$tax;
  $pdf->Ln();
  $pdf->Ln();
  $pdf->Cell(90,10,'Total Number of Customer/s: '.$n,2,0,'L');
  $pdf->Ln();
   $pdf->Cell(90,10,'VAT 12%: P'.$tax,2,0,'L');
   $pdf->Ln();
    $pdf->Cell(90,10,'Total Profit: P'.$balance,2,0,'L');
   $pdf->Ln();
  //$pdf->Cell(90,10,'Total Number of Rate: P'.$TotalRate.'.00',1,0,'L');
   $pdf->Ln();
 // $pdf->Cell(90,10,'All Total : P'.$allTotal.'.00',1,0,'L');
  //$pdf->Cell(90,10,'Balance : P'.$balance.'.00',1,0,'L');
$pdf->Output();
}
else{
      echo 'Update error.';

    }
?>