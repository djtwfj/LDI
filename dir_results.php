<?php
//session_start();
$other=$_REQUEST['other'];
$city=$_REQUEST['city'];
$tow=$_REQUEST['tow'];
$output;
$output = "<table border=0 align=center cellpadding=0 cellspacing=0 width=600px>";
$file_members = fopen("data/members.txt", "r") or exit("Unable to open file!");

$output = $output . "<tr><td class=bodyFormat colspan=2>Total records found: @@recs@@</td></tr>\n";
$output = $output . "<tr><td class=bodyFormat colspan=2>Search results for: ";

if (empty($other))
	$other = 0;	
if (empty($city))
	$city = 0;	
if (empty($tow))
	$tow = 0;		
if (strcasecmp('All',$city) == 0)
	$city = 0;	
if (strcasecmp('All',$tow) == 0)
	$tow = 0;

if ($other!==0 && $city!==0 && $tow!==0)
	$output = $output . "$other - $city - $tow";
elseif ($other!==0 && $city!==0)
	$output = $output . "$other - $city";
elseif ($city!==0 && $tow!==0)
	$output = $output . "$city - $tow";
elseif ($other!==0 && $tow!==0)
	$output = $output . "$other - $tow";	
elseif ($other!==0)
	$output = $output . "$other";
elseif ($city!==0)
	$output = $output . "$city";	
elseif ($tow!==0)
	$output = $output . " $tow";	
$output = $output . "</td></tr>\n";

$td = 1;
$total_recs = 0;
while(!feof($file_members)) {
	//read a line from file
	$line = fgets($file_members);
	
	//Return all records
	if ($city === 0 && $tow === 0 && $other === 0){
		$lineArr = explode("\t",$line);
		/*Build TD only if there is a record available*/
		if (strlen(trim($lineArr[0])) > 0){
			print_row($lineArr,1);
			$total_recs++;
		}	
		//$output = $output . "1";
	}//Return all records where city, tow, and other matches
	elseif ($city !== 0 && $tow !== 0 && $other !== 0){
	if (strpos($line,$city) && strpos($line,$tow) && stristr($line,trim($other))){
		$lineArr = explode("\t",$line);
		print_row($lineArr,2);
		//$output = $output . "2";
		$total_recs++;
	}}//Return records where city, and tow matches
	elseif ($city !== 0 && $tow !== 0){
	if (strpos($line,$city) && strpos($line,$tow)){
		$lineArr = explode("\t",$line);
		print_row($lineArr,3);
		//$output = $output . "3";
		$total_recs++;
	}}//return records where city and other matches
	elseif ($city !== 0 && $other !== 0){
	if (strpos($line,$city) && stristr($line,trim($other))){
		$lineArr = explode("\t",$line);
		print_row($lineArr,4);
		//$output = $output . "4";
		$total_recs++;
	}}//return records where tow and other matches
	elseif ($tow !== 0 && $other !== 0){
	if (strpos($line,$tow) && stristr($line,trim($other))){
		$lineArr = explode("\t",$line);
		print_row($lineArr,5);
		//$output = $output . "5";
		$total_recs++;
	}}//return records where city matches
	elseif ($city !== 0){
	if (strpos($line,$city)){
		$lineArr = explode("\t",$line);
		print_row($lineArr,6);
		//$output = $output . "6";
		$total_recs++;
	}}//return records where tow matches
	elseif ($tow !== 0){
	if (strpos($line,$tow)){
		$lineArr = explode("\t",$line);
		print_row($lineArr,7);
		//$output = $output . "7";
		$total_recs++;
	}}//return records where other matches
	elseif ($other !== 0){
	if (stristr($line,trim($other))){
		$lineArr = explode("\t",$line);
		print_row($lineArr,8);
		//$output = $output . "8";
		$total_recs++;
	}}
}
$output = $output . "</table><font class='abold'>";
echo str_replace('@@recs@@',$total_recs,$output);
//$_SESSION = array ();
//session_destroy ();
fclose($file_members);
	
function print_row($p_line,$r){
	global $td;
	global $total_recs;
	global $recs;
	global $output;

	$recs++;
	if ($td === 1){
		$output = $output . "<tr><td><table  border=0 width=600px cellpadding=0 cellspacing=0><tr>\n<td class=dotted>\n";
		$output = $output . "<table width='100%' border=0><tr>\n<td class=bodyFormat width='50%'>\n";
		$td=2;
	}elseif ($td === 2){
		$output = $output . "<td class=bodyFormat width='50%'>\n";
		$td = 3;
	}
	for ($i=0;$i<=6;$i++){
		//Email has to be in 5th position in the members.txt counting from 0
		if (strlen(trim($p_line[$i])) > 0 && $i==5){
			$output = $output . "<a class=mailto href=mailto:$p_line[$i]>$p_line[$i]</a> <br />\n";
		}elseif (strlen(trim($p_line[0])) > 0 && strlen(trim($p_line[6])) > 0 && $i==0){
			$output = $output . "<a class=aboldunder href=http://$p_line[6] target=_blank>$p_line[0]</a> <br />\n";
		}elseif (strlen(trim($p_line[0])) > 0 && strlen(trim($p_line[6])) == 0 && $i==0){
			$output = $output . "<font class=abold>$p_line[0]</font> <br />\n";			
		}elseif (strlen(trim($p_line[$i])) > 0 && $i!=6){
			$output = $output . "$p_line[$i] <br />\n";
		}
	}
	$output = $output . "\n</td>\n";
	if ($td === 3){
		if ($recs >= 40){
			$recs = 0;
			$output = $output . "</tr></table>\n</td></tr></table>
				<div id=backTop><a href='#pagetop' >Back to top</a></font></div></td></tr>";
		}else{		
			$output = $output . "</tr></table>\n</td></tr></table></td></tr>";
		}
		$td=1;
	}	
}
?>