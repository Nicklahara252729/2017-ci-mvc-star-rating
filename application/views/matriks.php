<!DOCTYPE html>
<html>
<head></head>
<body>
<table border=1>
<tr>
<td>ID User</td>
<td>ID Item</td>
<td>Nama user</td>
<td>Rating</td>
</tr>
<tr>
<td>u1</td>
<td>i1</td>
<td>Andi Wijaya</td>
<td>5</td>
</tr>
<tr>
<td>u1</td>
<td>i3</td>
<td>Andi Wijaya</td>
<td>3</td>
</tr>
<tr>
<td>u1</td>
<td>i7</td>
<td>Andi Wijaya</td>
<td>4</td>
</tr>
<tr>
<td>u1</td>
<td>i9</td>
<td>Andi Wijaya</td>
<td>1</td>
</tr>
<tr>
<td>u2</td>
<td>i1</td>
<td>Ube Ibnul</td>
<td>5</td>
</tr>
<tr>
<td>u2</td>
<td>i5</td>
<td>Ube Ibnul</td>
<td>2</td>
</tr>
<tr>
<td>u2</td>
<td>i7</td>
<td>Ube Ibnul</td>
<td>4</td>
</tr>
<tr>
<td>u3</td>
<td>i2</td>
<td>Ekky Lbs</td>
<td>3</td>
</tr>
<tr>
<td>u3</td>
<td>i3</td>
<td>Ekky Lbs</td>
<td>4</td>
</tr>
<tr>
<td>u3</td>
<td>i4</td>
<td>Ekky Lbs</td>
<td>5</td>
</tr>
<tr>
<td>u3</td>
<td>i6</td>
<td>Ekky Lbs</td>
<td>2</td>
</tr>
<tr>
<td>u3</td>
<td>i10</td>
<td>Ekky Lbs</td>
<td>1</td>
</tr>	

<tr>
<td>u4</td>
<td>i6</td>
<td>Popey</td>
<td>1</td>
</tr>
<tr>
<td>u4</td>
<td>i8</td>
<td>Popey</td>
<td>2</td>
</tr>
<tr>
<td>u4</td>
<td>i9</td>
<td>Popey</td>
<td>5</td>
</tr>
<tr>
<td>u4</td>
<td>i10</td>
<td>Popey</td>
<td>4</td>
</tr>

<tr>
<td>u5</td>
<td>i2</td>
<td>Usman</td>
<td>3</td>
</tr>
<tr>
<td>u5</td>
<td>i3</td>
<td>Usman</td>
<td>2</td>
</tr>
<tr>
<td>u5</td>
<td>i5</td>
<td>Usman</td>
<td>4</td>
</tr>
<tr>
<td>u5</td>
<td>i7</td>
<td>Usman</td>
<td>1</td>
</tr>
<tr>
<td>u5</td>
<td>i9</td>
<td>Usman</td>
<td>5</td>
</tr>	
</table>
<br><br>
<?php
$angka = array(
	  '','U1','U2','U3','U4','U5','I1','I2','I3','I4','I5','I6','I7','I8','I9','I10', 
	  'U1',0,0,0,0,0,5,0,3,0,0,0,4,0,1,0, 
	  'U2',0,0,0,0,0,5,0,0,0,2,0,4,0,0,0, 
	  'U3',0,0,0,0,0,0,3,4,5,0,2,0,0,0,1,
	  'U4',0,0,0,0,0,0,0,0,0,0,1,0,2,5,4,
	  'U5',0,0,0,0,0,0,3,2,0,4,0,1,0,5,0,
	  'i1',5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,
	  'i2',0,0,3,0,3,0,0,0,0,0,0,0,0,0,0,
	  'i3',3,0,4,0,2,0,0,0,0,0,0,0,0,0,0,
	  'i4',0,0,5,0,0,0,0,0,0,0,0,0,0,0,0,
	  'i5',0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,
	  'i6',0,0,2,1,0,0,0,0,0,0,0,0,0,0,0,
	  'i7',4,4,0,0,1,0,0,0,0,0,0,0,0,0,0,
	  'i8',0,0,0,2,0,0,0,0,0,0,0,0,0,0,0,
	  'i9',1,0,0,5,5,0,0,0,0,0,0,0,0,0,0,
	  'i10',0,0,1,4,0,0,0,0,0,0,0,0,0,0,0
	  );
      $no=0;

      echo "<table border=1>";
      for($i=0; $i <15; $i++){
           echo "<tr>";
           for($j=0; $j<16; $j++){
                 echo "<td>";
				 
                 $angkabaru[$i][$j]=$angka[$no];
                 $angkabaru1[$j][$i]=$angkabaru[$i][$j];
                 echo $angkabaru[$i][$j];
                 echo "</td>";
                 $no++;
           }
      }
      echo "</table>";
?>
<br><br>
<?php
	  $angka = array();
	  $angka[0] = array('','U1','U2','U3','U4','U5','I1','I2','I3','I4','I5','I6','I7','I8','I9','I10');
	  $angka[1] = array('U1',0,0,0,0,0,5,0,3,0,0,0,4,0,1,0);
      $no=0;

      echo "<table border=1>";
      for($i=0; $i <2; $i++){
           echo "<tr>";
           for($j=0; $j<16; $j++){
                 echo "<td>";
				 
                 $angkabaru[$i][$j]=$angka[$no];
                 //$angkabaru1[$j][$i]=$angkabaru[$i][$j];
                 echo $angkabaru[$i][$j];
                 echo "</td>";
                 $no++;
           }
      }
      echo "</table>";
?>
</body>
</html>