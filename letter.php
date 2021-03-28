<?php
    include 'components/authentication.php';
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
    
    
    require('award/fpdf/force_justify.php');
    $address = 'Advocatespedia, Greater Noida-201310 | Ph: 9560141504 | Mail: advocatespedia@gmail.com';

 $name = $rws["user_firstname"];
 $lname = $rws["user_lastname"];
    $college= $rws["user_college"];
     date_default_timezone_set('Asia/Calcutta');
     $date = date('d/m/Y h:i:s a', time());
     $serial= "Serial:".$rws["user_id"];
     $joiningdate= $rws["user_joiningdate"];
     $deadline= $rws["user_deadline"];
     $roll= $rws["user_username"];
     $duration= $rws["user_duration"];
     $email= $rws["user_email"];
      $topics= $rws["user_topics"];


    $pdf = new FPDF();
    $pdf -> AddPage();
    $pdf->Image('award/background.jpg', 25, 50, w,h);
$pdf->Image('award/Over APF Header1.png',26,6,160);


    $pdf->SetDrawColor(0,80,180);
  
    $pdf->SetTextColor(0,0,0);
    // Arial bold 15
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(25);
    $pdf->SetX((60-$w)/2);
$pdf->Cell($w, 13, $address,'B',15);
$pdf->Cell( 0, 10, $date, 0, 0, 'R' ); 
$pdf->Cell( 0, 20, $serial, 0, 0, 'R' ); 

    $pdf->SetLineWidth($w,1);

// Print 2 MultiCells
$y = $pdf->GetY();

$pdf->SetXY(30,$y);

$pdf->MultiCell(160,6,"




                                      TO WHOMESOEVER IT MAY CONCERN

This is to certify that $name $lname, a student of $college, worked with Advocates Pedia Foundation (A trust for the welfare of legal fraternity) in the capacity of the legal researcher for legal cases and article writing and publishing from $joiningdate to $deadline. For which Advocatespedia Standard Serial Number (ASSN) was allotted to prevent the duplicity of the content and for the identification of the contents contributed by the intern. To verify the ASSN this site can be used https://advocatespedia.com/Special:Redirect Over and above these assigned responsibilities, a legal researcher has to complete programmed tasks assigned for that tenure.

Advocatespedia was continuously impressed by the knowledge of $name $lname brought to the table and dedication to staying on top of the latest in the legal research field. $name $lname combines sharp analysis skills with a strong intuition, and Advocatespedia always knew and could rely on $name $lname to meet deadlines and exceed Advocatespedia expectations.

We are confident that the work helped the student develop on communication, leadership and interpersonal skills. We wish the student all the best for the future.



Adv. Faiyaz Khalid
President
Advocates Pedia Foundation
",'FJ');

$pdf->Image('award/Sign PNG.png',30,195,40);

// email stuff (change data below)
$to = $email; 
$from = "info@advocatespedia.com"; 
$subject = "Letter of Recommendation"; 
$message = "
<p>To</p>

<p>$name</p>
<p>$college</p>
<p>Roll Number: $roll</p>

<p>Dear $name</p>

<p>I am delighted & excited to inform you that your Letter of Recommendation has been granted.</p>


<p>Congratulations!</p>


<p>Please see the attachment.</p>

<p>Adv. Faiyaz Khalid</p>
<p>President</p>
<p>Advocates Pedia Foundation</p>



";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "$name.pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "This mail is regarding Letter of Recommendation.".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message
mail($to, $subject, $body, $headers);


$filename="membership/letter/$roll.pdf";
$pdf->Output($filename,'F');
header("location: award-certificate-extension.php");
 


?>


      

<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>


<?php 
    if($_GET["request"]=="profile-update" && $_GET["status"]=="success"){
        $dialogue="Your profile update was successful! ";
    }
    else if($_GET["request"]=="profile-update" && $_GET["status"]=="unsuccess"){
        $dialogue="Your profile update was not at all successful! ";
    }
    else if($_GET["request"]=="login" && $_GET["status"]=="success"){
        $dialogue="Welcome back again! ";
    }
?>

<?php          
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>  



