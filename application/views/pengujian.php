<?php

/*$data = array('n','n','n','y','y');
    $jenis[]=null;
    $cek="";
    $i=0;
    for($j=0;$j<count($data);$j++)
    {
        $index2=array_search($data[$j],$jenis);
        if($index2 == "")
        {    
            $jenis[$i]=$data[$j];
            $i++;
        }
    }

    cari($data, $jenis);
    
    function cari($data, $data2)
    {
        
        for($K=0;$K<count($data);$K++)
        {    
            echo $data2[$K]." => ".cariyangsama($data,$data2[$K])."<br/>";
        }
    }
    
    function cariyangsama($data,$dupval) {
        $nb= 0;
        foreach($data as $key => $val)
        if ($val==$dupval) $nb++;
        return $nb;
    }   */


?>

<html>
<head></head>
<body>
<table  border=1>
<tr>
<th>Top N</th>
<th>Id Item</th>
<th>Rating</th>
<th>Item yg di rekomendasi</th>
<th>Hasil</th>
</tr>
<?php
$no=1;
foreach($hasil->result() as $row){
	?>
	<tr>
	<td><?php echo $no; ?></td>
	<td><?php echo $row->amazon_id; ?></td>
	<td><?php echo $row->rating; ?></td>
	<td><?php echo $row->recommend; ?></td>
	<td><?php echo $row->hasil	; ?></td>
	</tr>
	<?php
	$no++;
}
?>
</table>


<table  border=1>
<tr>
<th colspan=5>Top 5 U1</th>
</tr>
<tr>
<th>Top N</th>
<th>Id Item</th>
<th>Rating</th>
<th>Item yg di rekomendasi</th>
<th>Hasil</th>
</tr>
<?php
$no=1;
foreach($top_five->result() as $row){
	?>
	<tr>
	<td><?php echo $no; ?></td>
	<td><?php echo $row->amazon_id; ?></td>
	<td><?php echo $row->rating; ?></td>
	<td><?php echo $row->recommend; ?></td>
	<td><?php echo $row->hasil	; ?></td>
	</tr>
	<?php
	$no++;
}
?>
<tr>
<td colspan=5>Coverage (5) = <?php echo $yes/$num; ?></td>
</tr>
</table>


<table  border=1>
<tr>
<th colspan=5>Top 9 U1</th>
</tr>
<tr>
<th>Top N</th>
<th>Id Item</th>
<th>Rating</th>
<th>Item yg di rekomendasi</th>
<th>Hasil</th>
</tr>
<?php
$no=1;
foreach($top_nine->result() as $row){
	?>
	<tr>
	<td><?php echo $no; ?></td>
	<td><?php echo $row->amazon_id; ?></td>
	<td><?php echo $row->rating; ?></td>
	<td><?php echo $row->recommend; ?></td>
	<td><?php echo $row->hasil	; ?></td>
	</tr>
	<?php
	$no++;
}
?>
<tr>
<td colspan=5>Coverage (9) = <?php echo $yes_dua/$num; ?></td>
</tr>
</table>
</body>
</html>