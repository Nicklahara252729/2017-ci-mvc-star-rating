<?php
    $matrix = array(
        array('a', 1, 2),
        array('b', 3, 4),
        array('c', 5, 6),
        array('d', 7, 8)
    );
	echo $a = sizeof($matrix);
    $transpose = array_reduce(
        $matrix,
        function ($acum, $row) {
            array_walk(
                $row,
                function($column, $index, $acum) {
                    $acum[$index][] = $column;
                },$acum);
            return $acum;
        },array()
    );
    print_r($transpose);
    // Output:
    // -------
    // a b c d
    // 1 3 5 7
    // 2 4 6 8
?>

// Taste it!
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<style>
#body{ width:60%;}
h1{ color: #000; background-color: #cecece; border-bottom: 1px solid #D0D0D0; font-size: 19px; font-weight: bold; margin: 0 0 14px 0; padding: 14px 15px 10px 15px; }
h2{ color: green; border-bottom: 1px solid #D0D0D0; font-size: 19px; font-weight: bold; margin: 0; padding: 0}
p{ margin:0px 0px 20px 0px;}
ul{ margin:0; padding:0; }
li{ cursor:pointer; list-style-type: none; display: inline-block; color: #F0F0F0; text-shadow: 0 0 1px #666666; font-size:20px; }
.highlight, .selected { color:#F4B30A; }
	</style>
	
</head>
<body>
<div id="body">
<h1>Semua Berita</h1>
	<?php 
		foreach ($record->result_array() as $row) {
		echo "<h2>$row[judul]</h2>
				<div id='rate-$row[id_berita]'>
				<input type='text' name='rating' id='rating' value='$row[rating]'>
					<ul onMouseOut=\"resetRating($row[id_berita])\">";
					  	for($i=1; $i<=5; $i++) {
						  if($i <= $row["rating"]){ $selected = "selected"; }else{ $selected = ""; }
					  		echo "<li class='$selected' onmouseover=\"highlightStar(this,$row[id_berita])\" onmouseout=\"removeHighlight($row[id_berita]);\" onClick=\"addRating(this,$row[id_berita])\">&#9733;</li>"; 
					  	}
					echo "<ul>
				</div>
			  <p>$row[isi_berita]</p>";
	}
	?>
</div>
<?php echo anchor('berita/transfer','do it');
echo anchor('berita/recom','Recommendation');
echo"<br>".anchor('berita/sistem','Pengujian Sistem');	
 ?>
<script src="<?php echo base_url(); ?>asset/jquery-2.1.4.js" type="text/javascript"></script>
<script>
	function highlightStar(obj,id) {
		removeHighlight(id);		
		$('#rate-'+id+' li').each(function(index) {
			$(this).addClass('highlight');
			if(index == $('#rate-'+id+' li').index(obj)) {
				return false;	
			}
		});
	}

	// event yang terjadi pada saat kita mengarahkan kursor kita ke sebuah object
	function removeHighlight(id) {
		$('#rate-'+id+' li').removeClass('selected');
		$('#rate-'+id+' li').removeClass('highlight');
	}

	function addRating(obj,id) {
		$('#rate-'+id+' li').each(function(index) {
			$(this).addClass('selected');
			$('#rate-'+id+' #rating').val((index+1));
			if(index == $('#rate-'+id+' li').index(obj)) {
				return false;	
			}
		});
		$.ajax({
		url: "<?php echo base_url('berita/tambah_rating'); ?>",
		data:'id='+id+'&rating='+$('#rate-'+id+' #rating').val(),
		type: "POST"
		});
	}

	function resetRating(id) {
		if($('#rate-'+id+' #rating').val() != 0) {
			$('#rate-'+id+' li').each(function(index) {
				$(this).addClass('selected');
				if((index+1) == $('#rate-'+id+' #rating').val()) {
					return false;	
				}
			});
		}
	} 
	
	// saat mengarahkan kursor ke bintang maka bintang akan kuning
	function highlightStar(obj,id) {
		removeHighlight(id);		
		$('#rate-'+id+' li').each(function(index) {
			$(this).addClass('highlight');
			if(index == $('#rate-'+id+' li').index(obj)) {
				return false;	
			}
		});
	}
 
	// saat mengarahkan kursor ke bintang maka bintang akan transparant
	function removeHighlight(id) {
		$('#rate-'+id+' li').removeClass('selected');
		$('#rate-'+id+' li').removeClass('highlight');
	}
 
	// Aksi untuk proses rating ke database di saat bintang diklik
	function addRating(obj,id) {
		$('#rate-'+id+' li').each(function(index) {
			$(this).addClass('selected');
			$('#rate-'+id+' #rating').val((index+1));
			if(index == $('#rate-'+id+' li').index(obj)) {
				return false;	
			}
		});
		$.ajax({
		url: "<?php echo base_url('berita/tambah_rating'); ?>",
		data:'id='+id+'&rating='+$('#rate-'+id+' #rating').val(),
		type: "POST"
		});
	}
 
	// Ketika Kursor meninggalkan bintang maka kembali kepada keaadan awal
	function resetRating(id) {
		if($('#rate-'+id+' #rating').val() != 0) {
			$('#rate-'+id+' li').each(function(index) {
				$(this).addClass('selected');
				if((index+1) == $('#rate-'+id+' #rating').val()) {
					return false;	
				}
			});
		}
	} 
</script>

</body>
</html>