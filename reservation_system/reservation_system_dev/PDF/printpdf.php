<?php  
 //filter.php  
require('fpdf.php');
include_once 'includes/dbh.inc.php';
session_start();

 if(isset($_POST["from_date"], $_POST["to_date"]))  
 {  

  $from = $_POST['from_date'];
  $to = $_POST['to_date'];

      $sql = "SELECT * FROM reports 
     where checkout BETWEEN '".$from."' AND '".$to."'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['reports'] = $queryResults;


class PDF extends fpdf{

  function header(){

       //$this->Image('logo.png',10,6,30);
       $this->SetFont('Times','B',15);
       $this->Cell(50);
       $this->Cell(0,0,'Summary Report of Rock Garden Resort',0,0,'L');

       $this->Ln(15);

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
    $this->SetLineWidth(.2);
    $this->SetFont('','B', 10);
  
    $this->Cell(10,15,'No.',1,0,'C',true); //nilalagay yung 'true' para makulayan ng SetFillColor(); 
    $this->Cell(38,15,'Customers Name',1,0,'C',true);
    $this->Cell(20,15,'Check-in',1,0,'C',true);
    $this->Cell(20,15,'Check-out',1,0,'C',true);
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


        $pdf->Ln();
        $pdf->Cell(0,0,'Printed by: '.$_SESSION['u_first'].' '.$_SESSION['u_last'],0,0,'L');
        $pdf->Ln(10);


        $TotalRate = 0;
        If($queryResults > 0){  
        $pdf->MyheaderTable();
        $pdf->SetFont('Arial','i',10);
        $n = 0;

        while($row = mysqli_fetch_assoc($result)){

        
         $cust_name= $row['cust_name'];
         $checkin= $row['checkin'];
         $checkout= $row['checkout'];
         $total_amount= $row['total_amount'];
         $amount_paid =$row['amount_paid'];
         $status =$row['status'];
         $user_incharge =$row['user_incharge'];


          $n++;
          $pdf->Cell(10,10,''.$n,1,0,'C');
          $pdf->Cell(38,10,''.$cust_name,1,0,'C');
          $pdf->Cell(20,10,''.$checkin,1,0,'L');
          $pdf->Cell(20,10,''.$checkout,1,0,'L');
          $pdf->Cell(23,10,'Php '.$total_amount.'',1,0,'L');
          $pdf->Cell(23,10,'Php '.$amount_paid.'',1,0,'L');
          $pdf->Cell(20,10,''.$status,1,0,'L');
          $pdf->Cell(40,10,''.$user_incharge,1,0,'C');
          $pdf->Ln();
          $TotalRate = $TotalRate +$total_amount;

      

         }



        $tax = $TotalRate *.12;
        $taxFree = $TotalRate - $tax;

        $pdf->Ln();
        $pdf->Cell(90,10,'Number of record/s: '.$_SESSION['reports'],2,0,'L');
        $pdf->Ln();
        $pdf->Cell(90,10,'VAT 12%: Php '.number_format($tax, 2),2,0,'L');
        $pdf->Ln();
        $pdf->Cell(90,10,'Total Profit: Php '.number_format($taxFree, 2),2,0,'L');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Output();



        }else{
          echo "No Data Found";
        }
 }

  
 ?>