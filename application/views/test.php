
<?php
echo form_open('berita/ops');
$inpt = ['name'=>'lenght'];
echo form_input($inpt);
echo form_submit('submit','Enter');
echo form_close();
if(isset($sum_lima)){
?>
<table border=1>
<tr>
<th>top n </th>
<th>Hit Rate</th>
<th>Coverage</th>
</tr>
<tr>
<td>5</td>
<td><?php echo $hsum_lima; ?>%</td>
<td><?php echo $sum_lima; ?>%</td>
</tr>
<tr>
<td>9</td>
<td><?php echo $hsum_nine; ?>%</td>
<td><?php echo $sum_nine; ?>%</td>
</tr>
</table>
<?php
}else{
	?>
	<table border=1>
<tr>
<th>top n </th>
<th>Hit Rate</th>
<th>Coverage</th>
</tr>
<tr>
<td>5</td>
<td>0%</td>
<td>0%</td>
</tr>
<tr>
<td>9</td>
<td>0%</td>
<td>0%</td>
</tr>
</table>
	<?php
}
?>