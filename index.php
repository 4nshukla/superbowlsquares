<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
-->
<?php 
error_reporting(0);
require_once('config.php');  
$NFC = array();
$AFC = array();
$cnt = 0;
for ($i=1; $i<=10; $i++) {
	$NFC[$i]="";
	$AFC[$i]="";
}
$query="SELECT * FROM VNSB_numbers";
$result = mysql_query($query);
if (!$result) {
	echo mysql_error();
	exit;
}

while ($record = mysql_fetch_assoc($result)) {
	$cnt++;
	$NFC[$cnt]=$record['NFC'];
	$AFC[$cnt]=$record['AFC'];
}

$query="SELECT * FROM VNSB_settings";
$result = mysql_query($query);
if ($record = mysql_fetch_assoc($result)) {
	$BET = $record['Bet'];
	$WIN_FIRST = $record['Win_first'];
	$WIN_SECOND = $record['Win_second'];
	$WIN_THIRD = $record['Win_third'];
	$WIN_FINAL = $record['Win_final'];
	$FIRST = (100 * (int)$BET ) * ((int)$WIN_FIRST/100);
	$SECOND = (100 * (int)$BET ) * ((int)$WIN_SECOND/100);
	$THIRD = (100 * (int)$BET ) * ((int)$WIN_THIRD/100);
	$FINAL = (100 * (int)$BET ) * ((int)$WIN_FINAL/100);
} else {
	echo mysql_error();
	exit;
}

?>
<?php require "header.inc"; ?>
<!--<p align="center">This is the live demo.  Use real email to see the script at work.</p>-->
<table width="95%" border="1" cellspacing="1" cellpadding="5" style="font-family: Verdana,Ariel; font-size: 10px; color:#0066CC;">
  <tr>
  	<td align="center" style="border-top: none; border-left: none;"><img src="NFL-logo.gif" title="National Football League" border="0" /></td>
<?php
	for ($i=1; $i<=10; $i++) {
    	echo "<td align=\"center\" style=\"font-size:12px; color:#232B85; font-weight:bold\">".$NFC_TEAM."<br>".$NFC[$i]."</td>";
	}
?>
  </tr>
<tr>
<form name="sqSelect" method="post" action="signup.php">

<?php
$query="SELECT * FROM VNSB_squares ORDER BY SQUARE";
$result = mysql_query($query);
if (!$result) {
	echo mysql_error();
	exit;
}
$cnt_row = 0;
$i=0;
$closed=1;
while ($record = mysql_fetch_assoc($result)) {	
	if ($cnt_row==0) {$i++; echo"<td align=\"center\" style=\"font-size:12px; color:#DB2824; font-weight:bold\">".$AFC_TEAM."<br/>".$AFC[$i]."</td>";}
	if ($record['NAME'] == "AVAILABLE") { 
		$closed=0;
		echo "<td align=\"center\" width='10%' title='only $".$BET."'>".$record['SQUARE']." ".$record['NAME']."<br/>";
		echo "<input name=\"sqNum_".$record['SQUARE']."\" type=\"checkbox\" value=\"".$record['SQUARE']."\"></input>";
		//<a href=\"signup.php?square=".$record['SQUARE']."\">".stripslashes($record['NAME'])."<br/>".$record['SQUARE']."</a>
		echo "</td>";
	} else if ($record['NAME']!="AVAILABLE" && $record['CONFIRM']==1) {
		echo "<td width='10%' bgcolor='#99ff66' align='center' title=\"".$record['NOTES']."\"><strong>".stripslashes($record['NAME'])."</strong><br/>Confirmed</td>";
	} else {
		echo "<td width='10%' bgcolor='#ff9966' align='center' title=\"".$record['NOTES']."\"><strong>".stripslashes($record['NAME'])."</strong><br/>Pending</td>";
	}
	
	$cnt_row++;
	if ($cnt_row==10) {
		$cnt_row=0;
		echo "</tr><tr>";
	}
}
?>
</tr>
</table>
<?php
if ( !$closed ) {
?>
<p style="font-family: Verdana,Ariel; font-size: 10px; color:#0066CC; font-weight:bold">
Check all your desired squares and click Submit to enter your information<br />
<input type="submit" name="sqSelect_Submit" value="Submit" title="Submit your selection"></input>
</p>
<?php } ?>
</form>
<br/>
<table width="95%" cellspacing="5" cellpadding="5" style="font-family: Verdana,Ariel; font-size: 12px; border: #009900 1px solid">
<tr>
<td align="left" width="46%" valign="top">
<strong>The Rules:</strong><br/>
<li><strong>$<?=$BET?></strong> per square</li>
<li>This is cash only.</li>
<li>You can buy 5 squares per person.</li>
<li>Your square(s) is/are not guaranteed until Nilesh verifies it</li>
<li>Numbers will be randomly draw and assigned after all squares are taken</li>
<li>When confirmed, your square(s) will be changed to <font color="#009900"><strong>GREEN</strong></font></li>
</td>
<td align="center" width="27%" valign="top">
<table width="100%" style="font-family: Verdana,Ariel; font-size: 12px; border: #009900 1px solid">
<tr><td colspan="3" align="center"><strong>The Payout:</strong></td></tr>
<tr>
<td width="70%">
<li>End of first quarter:</li>
<li>End of second quarter:</li>
<li>End of third quarter:</li>
<li>Final Score:</li>
</td>
<td width="15%">
<dt><?=$WIN_FIRST?>%</dt>
<dt><?=$WIN_SECOND?>%</dt>
<dt><?=$WIN_THIRD?>%</dt>
<dt><?=$WIN_FINAL?>%</dt>
</td>
<td width="15%" align="right" style="font-weight: 600px">
<dt><strong>$<?=$FIRST?></strong></dt>
<dt><strong>$<?=$SECOND?></strong></dt>
<dt><strong>$<?=$THIRD?></strong></dt>
<dt><strong>$<?=$FINAL?></strong></dt>
</td>
</tr>
</table>
</td>
</tr>
</table>
</p>


