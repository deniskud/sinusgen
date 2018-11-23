<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
   body {font-family: arial;}
  </style>
 </head>
 <body> 
<?php
$pi2=6.28318530718;  //2*pi
$pi05=1.57079632679; //1/2 * pi
$sr=@$_GET['sr'];
$msec=@$_GET['msec'];
$level=@$_GET['level'];
$n=@$_GET['n'];
$fname=@$_GET['fname'];
$deltafi=@$_GET['deltafi'];


if (!$sr) $sr=10000000;          // частота дискретизации
if (!$msec) $msec=1;                // длительность в милисек
if (!$level) $level=127;            // уровень синусоиды
if (!$n) $n=200;                // период в фреймах 
if (!$fname) $fname="iq/sinus.iq";  //name of file
if (!$deltafi) $deltafi=$pi05; //дельта фи (сдвиг фазы) - Пи/2

/////////////////////////////////////////////////
echo "использована команда:<br>
<font size=-2><i><b>sinus.php/?sr=$sr&msec=$msec&level=$level&deltafi=$deltafi&filename='$fname'</b></i></font><br><hr>
Частота дискретизации(sr): $sr (Hz) <br>
длительность в милисек.(msec): $msec <br>
уровень синусоид 0..127 (level): $level <br>
период синусуса разбит на (n): $n  фреймов <br>
здвиг по фазе (deltafi): $deltafi (в радианах)<br><hr>
";


$sizef=round($msec*$sr/1000);     //size in frame
$sizeb=$sizef*2/(1024*1024);    //size in Mbyte

$step=$pi2/$n;
$sinuscounter=0;

echo "Starting write $sizeb Mb in $fname <br>";
$c=$sizef;
$file = fopen($fname, "w+");

while ($c-- >0){
  $q=round($level*sin($sinuscounter));
  $i=round($level*sin($sinuscounter+$deltafi));
  fwrite($file,chr($i).chr($q));  
//  ($sinuscounter < $pi2) ? $sinuscounter=$step+$sinuscounter : $sinuscounter=0;

  if ($sinuscounter < $pi2) {$sinuscounter=$step+$sinuscounter;}
  else $sinuscounter=0;
}

fclose($file);
echo "write ok<br><a href='monitor.php'>monitor</a>";

?>
</body>
</html>
