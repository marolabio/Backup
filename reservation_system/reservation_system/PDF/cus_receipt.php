<?php
include_once 'includes/dbh.inc.php';

/*$sql = "SELECT * from reports
        INNER JOIN users
        ON reports.*";*/
  $sql ="select * from customers where cust_id = 1"; 
  $re = mysqli_query($conn,$sql);
//WHERE checkout =3";//*where id = '$pid'*/ "

  $sql2 = "SELECT customers.*, billing.*
            from customers
            FULL JOIN billing
            ON customers.cust_id = billing.cust_id";
  $re2 = mysqli_query($conn,$sql2);
   $n=0;
   $tax =0;
   $TotalRate =0;
   $allTotal=0;
   $pay=0;
   $balance=0;
   $checkin2 =20180215;
   $checkout2 =20180218;
   $amount =0;

   $date = Date('F j, Y');


class PDF extends fpdf{

	function header(){

     $this->SetFillColor(0);//ito ay para sa header ng table
    $this->SetTextColor(255,255,255);

			 //$this->Image('logo.png',10,6,30);
			 $this->SetFont('Times','B',15);

			 //$this->Cell(0);
			 $this->Cell(190,10,'INVOICE',1,0,'C',True);

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
	
		$this->Cell(105,10,'Item Name',1,0,'C',true); //nilalagay yung 'true' para makulayan ng SetFillColor(); 
		$this->Cell(25,10,'Price',1,0,'C',true);
		$this->Cell(30,10,'Night/s',1,0,'C',true);
		$this->Cell(30,10,'Amount',1,0,'C',true);
		$this->Ln();

	}
	

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(5);
$pdf->SetFont('Times','B',25);
$pdf->Cell(0,0,'Rock Garden Resort');
$pdf->Ln(10);
$pdf->SetFont('Arial','i',12);
$pdf->Cell(0,0,'Brgy. Arnedo, Bolinao');
$pdf->Ln(5);
$pdf->SetFont('Arial','i',12);
$pdf->Cell(0,0,'Pangasinan 2406 Philippines');
$pdf->Ln(5);
$pdf->SetFont('Arial','i',12);
$pdf->Cell(0,0,'Globe +63-917-983-6670 & Smart +63-920-413-9272');
$pdf->Ln(5);
$pdf->SetFont('Arial','i',12);
$pdf->Cell(0,0,'//www.rockgardenbolinoa.com');
$pdf->Ln(10);


while($row=mysqli_fetch_array($re))
  {
   $cust_id = $row['cust_id'];
   $cust_first =$row['cust_first'];
   $cust_last =$row['cust_last'];
   $transaction_id =$row['transaction_id'];
   $cust_email = $row['cust_email'];
   
      $pdf->Cell(90);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(40,10,'Customer Name:',1,0,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(60,10,''.$cust_first.' '.$cust_last,1,0,'R');
      $pdf->Ln(10);
      $pdf->Cell(90);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(40,10,'Transactio ID:',1,0,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(60,10,''.$transaction_id,1,0,'R');
      $pdf->Ln(10);
      $pdf->Cell(90);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(40,10,'Email:',1,0,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(60,10,''.$cust_email,1,0,'R');
      $pdf->Ln(10);
      $pdf->Cell(90);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(40,10,'Date:',1,0,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(60,10,''.$date,1,0,'R');
      $pdf->Ln(10);
      $pdf->Ln(5);

  
  }
$pdf->MyheaderTable();
$pdf->SetFont('Arial','',10);
 $sql1 ="select * from reservation where cust_id = '$cust_id'"; 
  $re2 = mysqli_query($conn,$sql1);
 
  while($row=mysqli_fetch_array($re2))
  {
    
    $nights = $row['nights'];
    $room_id = $row['room_id'];
    $quantity =$row['quantity'];
    $checkin = strtotime($row['checkin']);
    $checkout =strtotime($row['checkout']);

    $sql2 ="select * from rooms where room_id = '$room_id'"; 
  $re3 = mysqli_query($conn,$sql2);

    while($row=mysqli_fetch_array($re3))
  {
    $item_name =$row['room_type'];
   
    $price = $row['room_rate'];
}

    


    $pdf->Cell(105,10,$quantity.' x '.$item_name.' ('.date('F j, Y',$checkin).'-'.date('F j, Y',$checkout).')',1,0,'L');
    $pdf->Cell(25,10,'P '.$price,1,0,'L');


     $pdf->Cell(30,10,''.$nights,1,0,'L');

     $amount = $nights*$price;
      $pdf->Cell(30,10,'P '.$amount,1,0,'L');
       $pdf->Ln();
       $n++;
       $TotalRate = $TotalRate + $amount;

			
  }
  

$pdf->SetFont('Arial','i',10);

  $tax = $TotalRate *.12;

  $balance = $TotalRate-$tax;
  //$pdf->Cell(130);
  $pdf->SetFont('','B', 10);
  $pdf->Cell(160,10,'Total Payment:',1,0,'R');
  $pdf->SetFont('Arial','', 14);
  $pdf->Cell(30,10,'P '.$TotalRate,1,0,'L');

  $pdf->Ln();$pdf->Ln();
  $pdf->Cell(90,10,'Total Number of Customer/s: '.$n,1,0,'L');
  $pdf->Ln();
   $pdf->Cell(90,10,'VAT 12%: P '.$tax,1,0,'L');
   $pdf->Ln();
    $pdf->Cell(90,10,'Total Profit: P '.$balance,1,0,'L');
   $pdf->Ln();
  //$pdf->Cell(90,10,'Total Number of Rate: P'.$TotalRate.'.00',1,0,'L');
   $pdf->Ln();
 // $pdf->Cell(90,10,'All Total : P'.$allTotal.'.00',1,0,'L');
  //$pdf->Cell(90,10,'Balance : P'.$balance.'.00',1,0,'L');
$pdf->Output();

?>