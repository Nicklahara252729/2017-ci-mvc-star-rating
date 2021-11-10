<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Berita extends CI_Controller {
	public function index(){
		$data['record'] = $this->model_app->view('berita');
		$this->load->view('view_berita',$data);
	}

	function tambah_rating(){
		if ($this->input->post('rating')!=''){
	        $data = array('rating'=>$this->input->post('rating'));
	        $where = array('id_berita' => $this->input->post('id'));
			$this->model_app->update('berita', $data, $where);
		}
	}
	
	function transfer(){
		$input = ['name'=>'cari'];
		echo form_open('berita/cari/',['method'=>'get']);
		echo form_input($input);
		echo form_close();
		$get_gender = $this->model_app->get_gender()->result();
		 echo $get_gender2 = $this->model_app->get_gender()->num_rows()."<br>";
		 $get_view = $this->model_app->get_view()->num_rows()."<br>";
		$get_view2 = $this->model_app->get_view2()->result();
		$no=0;
		$tgl = "30/11/1984";
		foreach($get_gender as $row){
			/*if($no%=2){
				$gender = "laki - laki";
			}else{
				$gender = "perempuan";
			}*/
			echo $no." ";
			echo $row->Nama_user."<br>";
			//echo $row->Tanggal_lahir."<br>";
			$this->db->where('reviewerID',$row->reviewerID)
						 ->update('user',['Tanggal_lahir'=>$tgl]);
			$no++;
		}
		/*$no=1;
		foreach($get_view as $rows){
			echo $no." - ";
			echo $rows->reviewerName." | ".$rows->reviewerID."<br>";
			$no++;
		}*/
		//echo"<table>";
		//foreach($get_view2 as $rowss){
			/*$key = $rowss->reviewerName;
                $pisah = explode(" ",$key);
                 $sambung = $pisah[0];
			echo "<tr><td>".$rowss->reviewerID."</td>";
			echo "<td>".$rowss->jumlah."</td>";		
			echo "<td>".$rowss->reviewerName."</td>";			
			echo "<td>".$sambung."</td>";
			echo "<td>".sha1(123)."</td>";
			echo "<td>".$sambung."@gmail.com</td></tr>";	
			$pass = sha1(123);*/
			//$no=1;
			//foreach($get_gender as $row){
			//for($i=1;$i<=$get_view;$i++){
			//echo $no." ";
			//echo $row->Gender." ";
			//echo $row->Tanggal_lahir."<br>";
			//$this->db->where('reviewerID',$row->reviewerID)
				//	 ->update('user',['Gender'=>$row->Gender,'Tanggal_lahir'=>$row->Tanggal_lahir]);
			//}
			//$no++;
			
			//}
			//$this->db->insert('user',['reviewerID'=>$rowss->reviewerID,'Nama_user'=>$rowss->reviewerName,'Username'=>$sambung,'Email'=>$sambung."@gmail.com",'Password'=>$pass]);
			//$this->db->where('reviewerID',$rowss->reviewerID)
			//		 ->update('user',['status'=>'member']);	
		//}
		//echo"</table>";
		
	}
	
	function cari(){
		$inpt = $this->input->get('cari');
		$cari = $this->model_app->cari($inpt)->result();
		echo"<table>";
		foreach($cari  as $row){
			echo"<tr><td>".$row->reviewerID."</td>";
			echo"<td>".$row->reviewerName."</td>";
			echo "<td>".anchor('berita/hapus/'.$row->id,'hapus')."</td>";
		}
		echo"</table>";
	}
	
	function hapus(){
		$id = $this->uri->segment(3);
		$hapus = $this->model_app->hapus($id);
		redirect(site_url('berita/transfer'));
	}
	
	function rating(){
		$rate = $this->db->get('rating');
		$no = 1;
		foreach($rate->result() as $row){
			echo $no." ";
			echo $row->ID_User."<br>";
		$no++;
		}
	}
	
	function login(){
		$this->load->view('login');
	}
	
	function p_login(){
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		if(isset($_POST['enter'])){
        $checked = $this->model_app->login($user,$pass);
        if($checked==1){          
          $result = $this->model_app->take_sess($user,$pass)->row();
  				$this->session->set_userdata(array('status_login'=>TRUE,'reviewer_id'=>$result->reviewerID,'username'=>$result->username));
			redirect(site_url('berita/new_recom'));
        }else{
          redirect(site_url('berita/login'));
        }
      }else{
      }
	}
	
	function new_recom(){
	$user = $this->session->userdata('reviewer_id');
	$u = $this->db->get('n_user')->num_rows();
    $i = $this->db->get('n_item')->num_rows();
    $s = $u + $i;
	echo "<table border=1>";
    for($i=0;$i<$s;$i++){
		echo "<tr>";
      if($i >= $u){
		 for($j=0;$j<$s;$j++){
			 echo"<td>";
			 if($j >= $u){
				echo "0"; 
			 }else{
				$dbase = $this->db->get('n_rate');
				$dbuser = $this->db->get('n_user');
                $iditem = " ";
				foreach($dbuser->result() as $use){
					foreach($dbase->result() as $row){
					  if($iditem == $row->Amazon_id){
						if($row->reviewerID == $use->reviewerID){
						 echo $row->rating;
						}else{
						 echo "0";
						}
					  }else{
						if($row->reviewerID == $use->reviewerID){
						  echo $row->rating;
						}else{
						  echo "0";
						}
						//$a[i][j] = $nilai;
					  }
					}
				}
			 }			
			  echo"</td>";
		 }
	  }
	  else{
            for($j=0;$j<$s;$j++){
				 echo"<td>";
				 if($j >= $u){
					$dbase = $this->db->get('n_rate');
					$dbuser =  $this->db->get('n_user');
					$iditem = " ";
					foreach($dbuser->result() as $use){
						foreach($dbase->result() as $row){
						  if($iditem == $row->Amazon_id){
							if($row->reviewerID == $use->reviewerID){
							 echo $row->rating;
							}else{
							 echo"0";
							}
						  }else{
							if($row->reviewerID == $use->reviewerID){
							  echo $row->rating;
							}else{
							  echo"0";
							}
							//$a[i][j] = $nilai;
						  }
						}
				 }
			 	
				 }else{
					 echo"0";
				 }			
				echo"</td>";
			}				
          }
		  echo "</tr>";
		}
		echo "</table>";
	}
	
	function new_recom_dua(){
	$user = $this->session->userdata('reviewer_id');
	$u = $this->db->get('n_user')->num_rows();
    $i = $this->db->get('n_item')->num_rows();
    $s = $u + $i;
	echo "<table border=1>";
    for($i=0;$i<$s;$i++){
		echo "<tr>";
      if($i >= $u){
		 for($j=0;$j<$s;$j++){
			 echo"<td>";
			 if($j >= $u){
				echo $nilai = 0; 
			 }else{
				echo $nilai = 2;
			 }			
			  echo"</td>";
			  $a[$i][$j] = $nilai;
		 }
	  }
	  else{
            for($j=0;$j<$s;$j++){
				 echo"<td>";
				 if($j >= $u){
					echo $nilai = 1;
				 }else{
					 echo $nilai = 0;
				 }			
				echo"</td>";
				$a[$i][$j] = $nilai;
			}				
          }
		  echo "</tr>";
		}
		echo "</table>";
		
		echo"<table>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				 $trans[$i][$j] = $a[$j][$i];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table>";
		
		echo"<table border=1>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $trans[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
		
		
		for($i=0;$i<$s;$i++){
      		for($j=0;$j<$s;$j++){
				$kali[$i][$j] = 0;
				for($k=0;$k<$s;$k++){
					$temp = $a[$i][$k] * $trans[$k][$j];
					$kali[$i][$j] = $kali[$i][$j] + $temp;
				}		
					$pangkat[$i][$j] = pow($kali[$i][$j],2);
			}			
		}
		
		for($i=0;$i<$s;$i++){
      		for($j=0;$j<$s;$j++){
				$hasil[$i][$j] = 0;
				for($k=0;$k<$s;$k++){
					$temp = $pangkat[$i][$k]* $a[$k][$j];
					$hasil[$i][$j] = $hasil[$i][$j] + $temp;
				}		
			}			
		}
		
		for($i=0;$i<$s;$i++){
			for($j=0;$j<$s;$j++){
				
			}
		}
		
		/*for($i=0;$i<$s;$i++){
      		for($j=0;$j<$s;$j++){
				
			}			
		}*/
		
		
		echo"<table border=1>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $pangkat[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
		
		echo"<table border=1>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $hasil[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
	}
	
	function new_recom_tiga(){
	$user = $this->session->userdata('reviewer_id');
	$u = $this->db->get('n_user')->num_rows();
    $i = $this->db->get('n_item')->num_rows();
    $s = $u + $i;
	$drate = $this->db->get('n_rate')->result();
	$duser = $this->db->get('n_user')->result();
	$ditem = $this->db->get('n_item')->result();
	$drate_sc = $this->db->get_where('n_rate',['Amazon_id'=>'i7'])->row();
	$o = 0;
	foreach($drate as $rates){
		$ama[$o] = $rates->Amazon_id;
		$rev[$o] = $rates->reviewerID;
		$rat[$o] = $rates->rating;
		$o++;
	}
	$i=0;
	foreach($duser as $usr){
		$a[$i] = $usr->reviewerID;
		$i++;
	}
	$j= 0;
	foreach($ditem as $itm){
		$b[$j] = $itm->Amazon_id;
		$j++;
	}
	for($f=0;$f<sizeof($a);$f++){
		//echo $a[$f];
	}
	
	//$a = ['u1','u2','u3'];
	//$b = ['ss','pp','qq'];
	for($l=0;$l<sizeof($a);$l++){
		for($y=0;$y<sizeof($rev);$y++){
			 if($a[$l]==$rev[$y]){
				 for($m=0;$m<sizeof($b);$m++){
					 if($b[$m] == $ama[$y]){
						 echo $d[$m] = $rat[$y];
					 }else{
						 echo $d[$m] = 0;
					 }
				 }
			 }
		}
	}
				
	
	//---- tahap 1--------------
	echo "<table border=1>";
	echo"
	<tr>
	<td colspan=13>TAHAP 1</td>
	</tr>";
    for($i=0;$i<$s;$i++){
		echo "<tr>";
      if($i >= $u){
		 for($j=0;$j<$s;$j++){
			 echo"<td>";
			 if($j >= $u){
				echo $nilai = 0; 
			 }else{
				 echo $nilai = 2;
			 }			
			  echo"</td>";
			  $a[$i][$j] = $nilai;
		 }
	  }
	  else{
            for($j=0;$j<$s;$j++){
				 echo"<td>";
				 if($j >= $u){
					echo $nilai = 1;
				 }else{
					 echo $nilai = 0;
				 }			
				echo"</td>";
				$a[$i][$j] = $nilai;
			}				
          }
		  echo "</tr>";
		}
		echo "</table><br><br>";
		//------------------- end tahap 1 -------------------
		
		
		
		//-------------------- tahap 3 ----------------------
		
		echo "<table border=1>";
		echo"
		<tr>
		<td colspan=13>TAHAP 3</td>
		</tr>";
		for($i=0;$i<$s;$i++){
			echo "<tr>";
		  if($i >= $u){
			 for($j=0;$j<$s;$j++){
				 echo"<td>";
				 if($j >= $u){
					echo $nilai = 0; 
				 }else{
					  echo $nilai = 2 ;
				 }			
				  echo"</td>";
				  $a[$i][$j] = $nilai;
			 }
		  }
		  else{
				for($j=0;$j<$s;$j++){
					 echo"<td>";
					 if($j >= $u){
						echo $nilai = 1;
					 }else{
						 echo $nilai = 0;
					 }			
					echo"</td>";
					$a[$i][$j] = $nilai;
				}				
			  }
			  echo "</tr>";
			}
		echo "</table><br><br>";
		
		//-------------------- end tahap 3 ------------------
		
		//-------------------- tahap 4 = k -------------------
		$t_item = $this->db->get_where('n_rate',['reviewerID'=>'3'])->num_rows();
		echo "<table border=1>";
		echo"
		<tr>
		<td colspan=13>TAHAP 4</td>
		</tr>
		<tr>
		<td>";
		echo "Penentuan K & N <br>";
		if($t_item%2==0){
			echo "nilai K = ";
			 echo $k = $t_item - 1;
			 echo"<br>";
		}else{
			echo "nilai K = ";
			 echo $k = $t_item;
			 echo"<br>";

		}
			 echo "nilai N = ";
		     echo $n = ($k - 1)/2;
			 
			 echo "</td></tr></table><br><br>";
		
		//-------------------- end tahap 4--------------------
		
		
		//----------- transpose -----------------------------
		
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				 $trans[$i][$j] = $a[$j][$i];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table>";
		
		echo"<table border=1>";
		echo"<table>";
		echo "<table border=1>";
		echo"
		<tr>
		<td colspan=13>TAHAP 5 TRANSPOSE</td>
		</tr>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $trans[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
		//------------------- end transpose----------
		
		//------------------ pangkat ----------------
		for($i=0;$i<$s;$i++){
      		for($j=0;$j<$s;$j++){
				$kali[$i][$j] = 0;
				for($k=0;$k<$s;$k++){
					$temp = $a[$i][$k] * $trans[$k][$j];
					$kali[$i][$j] = $kali[$i][$j] + $temp;
				}		
					$pangkat[$i][$j] = pow($kali[$i][$j],2);
			}			
		}
		
		echo"<table border=1>";
		echo"<table>";
		echo "<table border=1>";
		echo"
		<tr>
		<td colspan=13>TAHAP 6</td>
		</tr>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $pangkat[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
		//------------------ end pangkat ------------
		
		//--------------------- hasil akhir ---------
		for($i=0;$i<$s;$i++){
      		for($j=0;$j<$s;$j++){
				$hasil[$i][$j] = 0;
				for($k=0;$k<$s;$k++){
					$temp = $pangkat[$i][$k]* $a[$k][$j];
					$hasil[$i][$j] = $hasil[$i][$j] + $temp;
				}		
			}			
		}
		
		
		
		echo"<table border=1>";
		echo"<table>";
		echo "<table border=1>";
		echo"
		<tr>
		<td colspan=13>TAHAP 7</td>
		</tr>";
		for($i=0;$i<$s;$i++){
		echo "<tr>";
      		for($j=0;$j<$s;$j++){
				echo "<td>";
				
				echo $hasil[$i][$j];
				echo "</td>";
			}				
		  echo "</tr>";
		}
		echo"</table> <br><br>";
		//----------------------- end hasil -------------
		

	}
	
	function recom(){
		
		$num =  $this->model_app->tester()->num_rows();
    $num_sec =  $this->model_app->t_item()->num_rows();
    $ber = $this->model_app->tester()->result();
    $num_s =  $this->model_app->t_item()->result();
	$num_s2 = array(0,0,0,0,0,5,0,3,0,0,0,4,0,1,0);
	 $tot_array = sizeof($num_s2);
    $n=0;
    /*foreach($num_s as $key) {
      $n = $key->rate; 
	 if($n>=3){
		 $n = 1;
	 }elseif($n>0 && $n<=2){
		 $n = -1;
	 }
	 echo $n;
      $n++;
    }*/
	for($i=0;$i<$tot_array;$i++){
		 $num_s3 = $num_s2[$i];
		if($num_s3>=3){
			$num_s3 = 1;
		}elseif($num_s3>0 && $num_s3<=2){
			$num_s3 = -1 ;
		}elseif($num_s3==0){
			$num_s3 = 0;
		}
		 $num_s3;
		 echo $num_s4 = $num_s3 * -1;
	}

	
	  $angka = array(
	  0,0,0,0,0,1,0,1,0,0,0,1,0,-1,0, 
	  0,0,0,0,0,1,0,0,0,-1,0,1,0,0,0, 
	  0,0,0,0,0,0,1,1,1,0,-1,0,0,0,-1,
	  0,0,0,0,0,0,0,0,0,0,-1,0,-1,1,1,
	  0,0,0,0,0,0,1,-1,0,1,0,-1,0,1,0,
	  -1,-1,0,0,0,0,0,0,0,0,0,0,0,0,0,
	  0,0,-1,0,-1,0,0,0,0,0,0,0,0,0,0,
	  -1,0,-1,0,1,0,0,0,0,0,0,0,0,0,0,
	  0,0,-1,-1,0,0,0,0,0,0,0,0,0,0,0,
	  0,1,0,0,-1,0,0,0,0,0,0,0,0,0,0,
	  0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,
	  -1,-1,0,0,1,0,0,0,0,0,0,0,0,0,0,
	  0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,
	  1,0,0,-1,-1,0,0,0,0,0,0,0,0,0,0,
	  0,0,1,-1,0,0,0,0,0,0,0,0,0,0,0
	  );
      $no=0;

      echo "<table border=1>";
      for($i=0; $i <15; $i++){
           echo "<tr>";
           for($j=0; $j<15; $j++){
                 echo "<td>";
				 
                 $angkabaru[$i][$j]=$angka[$no];
                 $angkabaru1[$j][$i]=$angkabaru[$i][$j];
                  echo $angkabaru[$i][$j];
                 echo "</td>";
                 $no++;
           }
      }
      echo "</table>";

      echo "Nilai Maksimal berdasarakan kolom: <br>";
      for($i=0; $i < 15; $i++){
           $jumlah[$i]=array_sum($angkabaru[$i]);
           echo $jumlah[$i]. ",";
      }
	  echo"<br>";
	  /*$data1 = array(array(1,2,3),array(4,5,6));
	  $data2 = array(array(7,8,9),array(10,11,12));
	  $temp = array(1,2,3);
		array_push($data2, $temp);
		$temp = array(4,5,6);
		array_push($data2, $temp);
		echo "<p>Hasil penjumlahannya :</p>";
		echo "<table cellpadding=’5′ border=’5′>";

		for($f=0;$f<=1;$f++){
		echo "<tr>";

		for($g=0;$g<=2;$g++){

		echo "<td>",($data1[$f][$g] + $data2[$f][$g]), "</td>";

		}
		print"</tr>";
		}
		echo "</table>";
		 $batas = 5;
		 echo '<table>';
		 for ($i=1;$i<=$batas;$i++){
		 echo '<tr>';
		 for ($j=1;$j<=$batas;$j++){
		 echo '<td>';
		 echo $i.$j;
		 echo '</td>';
		 }
		 echo '</tr>';
		 }
		echo '</table>';*/
		$matriksA = array(2,3,1,2);
$matriksB = array(4,2,1,2);
//Matriks C untuk menyimpan hasil penjumlahan antara Matriks A dan B
$matriksC = array();
 
//inisialiasi jumlah baris dan kolom. Untuk penjumlahan matriks jumlah baris dan kolom kedua-dua matriksnya harus sama
$baris = 2;
$kolom = 2;
/*inisialisasi nilai masing-masing matriks A dan B
$matriksA[0][0] = 2;
$matriksA[0][1] = 3;
$matriksA[1][0] = 1;
$matriksA[1][1] = 2;
$matriksB[0][0] = 4;
$matriksB[0][1] = 2;
$matriksB[1][0] = 1;
$matriksB[1][1] = 2;*/
 
for( $i = 0; $i < $baris; $i++ ) :
    for( $j = 0; $j < $kolom; $j++ ) :
		echo $matriksA[$i][$j];
		echo $matriksB[$i][$j];
        $matriksC[$i][$j] = $matriksA[$i][$j] + $matriksB[$i][$j];
    endfor;
endfor;
 
//Menampilkan hasil penjumlahan matriks yang telah disimpan di dalam Matriks C
for( $i = 0; $i < $baris; $i++ ) :
    for( $j = 0; $j < $kolom; $j++ ) :
        echo $matriksC[$i][$j]."&nbsp;&nbsp;&nbsp";
    endfor;
    echo "
";
endfor;
		
		 /*$a=array();
		 $a[] = array(5,0,3,0,0,0,4,0,-1,0);
		 $a[] = array(5,0,0,0,2,0,4,0,0,0);
		 $a[] = array(0,3,4,5,0,2,0,0,0,1);
		 $a[] = array(0,0,0,0,0,1,0,2,5,4);
		 $a[] = array(0,3,2,0,4,0,1,0,5,0);
		 
		 $b=array();
		 $b[] = array(5,0,3,0,0,0,4,0,-1,0);
		 $b[] = array(5,0,0,0,2,0,4,0,0,0);
		 $b[] = array(0,3,4,5,0,2,0,0,0,1);
		 $b[] = array(0,0,0,0,0,1,0,2,5,4);
		 $b[] = array(0,3,2,0,4,0,1,0,5,0);
			
			$hasil = array();
			for ($i=0; $i<sizeof($a); $i++) {
				for ($j=0; $j<sizeof($b[0]); $j++) {
					$temp = 0;
					for ($k=0; $k<sizeof($b); $k++) {
						$temp += $a[$i][$k] * $b[$k][$j];
					}
					$hasil[$i][$j] = $temp;
				}
			}
		// $hasil = perkalian_matriks($a, $b);
			echo "<table border='1' cellspacing='0' cellpadding='5'>";
			for ($i=0; $i<sizeof($hasil); $i++) {
				echo "<tr>";
				for ($j=0; $j<sizeof($hasil[$i]); $j++) {
					echo "<td>". round($hasil[$i][$j], 4) ."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			 $angka=array(1,0,1,0,0,0,1,0,-1,0);
				$no=0;

				echo "<table border=1>";
				for($i=0; $i <1; $i++){
					  echo "<tr>";
					  for($j=0; $j<10; $j++){
							echo "<td>";
							$angkabaru[$i][$j]=$angka[$no];
							echo $angkabaru1[$j][$i]=$angkabaru[$i][$j];
							//echo $angkabaru[$i][$j];
							echo "</td>";
							$no++;
					  }
				}
				echo "</table>";

				echo "Nilai Maksimal berdasarakan kolom: <br>";
				for($i=0; $i < 10; $i++){
					  $jumlah[$i]=array_sum($angkabaru1[$i]);
					  echo $jumlah[$i]. ",";
				}
				
		/*$data1 = array(array(1,2,3),array(4,5,6));
        $data2 = array(array(7,8,9),array(10,11,12));
        $temp = array(1,2,3);
        array_push($data2, $temp);
        $temp = array(4,5,6);
        array_push($data2, $temp);
                    echo "<p>Hasil penjumlahannya :</p>";
                    echo "<table cellpadding='5' border='5'>";
                                                                   
                    for($f=0;$f<=1;$f++){
                                echo "<tr>";
                                
                                for($g=0;$g<=2;$g++){
                                                                                                                                                   
                                        echo "<td>",($data1[$f][$g] + $data2[$f][$g]), "</td>";
                                                                                                                                     
                                }
                           print"</tr>";
                     
                        }
                        echo "</table>";*/
                     
         $trans = array(
    array(1, 2),
    array(3, 4),
    array(5, 6)
);

array_unshift($trans, null);
$trans = call_user_func_array('array_map', $trans);
var_dump($trans);  

$trans = array(
    array(1, 2),
    array(3, 4),
    array(5, 6)
);

$trans = array_map(null, ...$trans);
var_dump($trans);


$matrix = [
    ['a', 1, 2],
    ['b', 3, 4],
    ['c', 5, 6],
    ['d', 7, 8]
];

print_r(array_map(NULL, ...$matrix));


            
	}
	
	public function new(){
		$this->load->view('matriks');
	}
	public function top_five(){
		$get_user = $this->model_app->get_user()->result();
		foreach($get_user as $k){
		$id = $k->reviewerID;
		$top_five = $this->model_app->top_five($id);
			foreach($top_five->result() as $r){
				$rec = $r->recommend;
				$cek_top = $this->db->get_where('top_five',['reviewerID'=>$id])->num_rows();
				$in = $this->model_app->in_tfive($id,$rec);
				/*if($cek_top <=0){
					
				}else{
					$up = $this->model_app->up_tfive($id,$rec);
				}*/
				
			}
		}
		echo"oke";
		//redirect(site_url('berita/top_nine'));
	}
	
	public function hit_five(){
		$get_user = $this->model_app->get_user()->result();
		foreach($get_user as $k){
		$id = $k->reviewerID;
		$top_five = $this->model_app->top_five($id);
			foreach($top_five->result() as $r){
				$rec = $r->recommend;
				$cek_top = $this->db->get_where('hit_five',['reviewerID'=>$id])->num_rows();
				$in = $this->model_app->in_hfive($id,$rec);
				/*if($cek_top <=0){
					
				}else{
					$up = $this->model_app->up_tfive($id,$rec);
				}*/
				
			}
		}
		echo"oke";
		//redirect(site_url('berita/top_nine'));
	}
	
	public function top_nine(){
		$get_user = $this->model_app->get_user()->result();
		foreach($get_user as $k){
		$id = $k->reviewerID;
		$top_nine = $this->model_app->top_nine($id);
			foreach($top_nine->result() as $r){
				$rec = $r->recommend;
				$in = $this->model_app->in_tnine($id,$rec);
			}
		}
		//echo"oke";
		redirect(site_url('berita/sistem'));
	}
	
	public function hit_nine(){
		$get_user = $this->model_app->get_user()->result();
		foreach($get_user as $k){
		$id = $k->reviewerID;
		$top_nine = $this->model_app->top_nine($id);
			foreach($top_nine->result() as $r){
				$rec = $r->recommend;
				$in = $this->model_app->in_hnine($id,$rec);
			}
		}
		//echo"oke";
		redirect(site_url('berita/sistem'));
	}
	
	public function sistem(){
		$get_user = $this->model_app->get_user()->row();
		$id = $get_user->reviewerID;
		$get_topn['hasil'] = $this->model_app->topn($id);
		$get_topn['num'] = $this->model_app->topn($id)->num_rows();
		$get_topn['top_five'] = $this->model_app->top_five($id);
		$get_topn['top_nine'] = $this->model_app->top_nine($id);
		$top_five = $this->model_app->top_five($id);
		$get_topn['top_nine'] = $this->model_app->top_nine($id);
		$get_topn['yes']= $this->model_app->cove_five($id)->num_rows();
		$get_topn['yes_dua']= $this->model_app->cove_nine($id)->num_rows();
		$this->load->view('pengujian',$get_topn);
	}
	
	public function test_sis(){
		$this->load->view('test');
	}
	
	public function ops(){
		error_reporting(0);
		if(isset($_POST['submit'])){
			$inpt = $this->input->post('lenght');
			if($inpt==3){				
				$user = $this->model_app->user()->result();
				foreach($user as $k ){
				$id = $k->reviewerID;
				 $num = $this->model_app->hasil_recom($id)->num_rows()."<br>";
				if($num==3 or $num==4){
					 $get_topnum = $this->model_app->topn($id)->num_rows();
					 $get_hitnum = $this->model_app->hitn($id)->num_rows();
					 $get_topn= $this->model_app->cove_five($id)->num_rows();
					 $get_hitn= $this->model_app->hit_five($id)->num_rows();
					 $get_topnine= $this->db->get_where('top_nine',['reviewerID'=>$id,'top_nine'=>'YES'])->num_rows();
					 $get_hitnine= $this->db->get_where('hit_nine',['reviewerID'=>$id,'hit_nine'=>'NO'])->num_rows();
					 $get_temp = $this->model_app->temp($id)->num_rows();
					 $get_htemp = $this->model_app->temp_hit($id)->num_rows();
					  $cove = $get_topn/$get_topnum ;
					  $cove_nine = $get_topnine/$get_topnum;
					  $hit = $get_hitn/$get_hitnum;
					  $hit_nine = $get_hitnine/$get_hitnum;
					 if($get_temp <= 0){
						 $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
					  }
					  if($get_htemp <= 0){
						 $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
					  }
					  
					}
				}
				$get_sum = $this->model_app->sum_five()->row();
				$get_sum_n = $this->model_app->sum_nine()->row();
				$get_bnyk_user = $this->model_app->b_user()->num_rows();
				
				$get_hsum = $this->model_app->hsum_five()->row();
				$get_hsum_n = $this->model_app->hsum_nine()->row();
				$get_hbnyk_user = $this->model_app->hb_user()->num_rows();
				if($get_sum->cove_lima >0 and $get_sum_n->cove_nine>0){
				 $sum['sum_lima'] = round(($get_sum->cove_lima/$get_bnyk_user)*100);
				 $sum['sum_nine'] = round(($get_sum_n->cove_nine/$get_bnyk_user)*100);
				}else{
					$sum['sum_lima'] = 0;
					$sum['sum_nine'] = 0;
				}
				
				if($get_hsum->hit_lima >0 and $get_hsum_n->hit_nine>0){
				 $sum['hsum_lima'] = round(($get_hsum->hit_lima/$get_hbnyk_user)*100);
				 $sum['hsum_nine'] = round(($get_hsum_n->hit_nine/$get_hbnyk_user)*100);
				}else{
					$sum['hsum_lima'] = 0;
					$sum['hsum_nine'] = 0;
				}
				$this->load->view('test',$sum);
			}
			elseif($inpt==5){
				$user = $this->model_app->user()->result();
				foreach($user as $k ){
				$id = $k->reviewerID;
				 $num = $this->model_app->hasil_recom($id)->num_rows()."<br>";
				if($num==5 or $num==6){
					 $get_topnum = $this->model_app->topn($id)->num_rows();
					 $get_hitnum = $this->model_app->hitn($id)->num_rows();
					 $get_topn= $this->model_app->cove_five($id)->num_rows();
					 $get_hitn= $this->model_app->hit_five($id)->num_rows();
					 $get_topnine= $this->db->get_where('top_nine',['reviewerID'=>$id,'top_nine'=>'YES'])->num_rows();
					 $get_hitnine= $this->db->get_where('hit_nine',['reviewerID'=>$id,'hit_nine'=>'NO'])->num_rows();
					 $get_temp = $this->model_app->temp($id)->num_rows();
					 $get_htemp = $this->model_app->temp_hit($id)->num_rows();
					  $cove = $get_topn/$get_topnum ;
					  $cove_nine = $get_topnine/$get_topnum;
					  $hit = $get_hitn/$get_hitnum;
					  $hit_nine = $get_hitnine/$get_hitnum;
					 if($get_temp <= 0){
						 $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
					  }else{
						  $del = $this->model_app->del($id);
						  if($del){
							  $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
						  }
					  }
					  
					  if($get_htemp <= 0){
						 $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
					  }else{
						  $del = $this->model_app->del_hit($id);
						  if($del){
							  $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
						  }
					  }
					}
				}
				$get_sum = $this->model_app->sum_five_sc()->row();
				$get_sum_n = $this->model_app->sum_nine_sc()->row();
				$get_bnyk_user = $this->model_app->b_user_sc()->num_rows();
				
				$get_hsum = $this->model_app->hsum_five_sc()->row();
				$get_hsum_n = $this->model_app->hsum_nine_sc()->row();
				$get_hbnyk_user = $this->model_app->hb_user_sc()->num_rows();
				if($get_sum->cove_lima >0 and $get_sum_n->cove_nine>0){
				 $sum['sum_lima'] = round(($get_sum->cove_lima/$get_bnyk_user)*100);
				 $sum['sum_nine'] = round(($get_sum_n->cove_nine/$get_bnyk_user)*100);
				}else{
					$sum['sum_lima'] = 0;
					$sum['sum_nine'] = 0;
				}
				
				if($get_hsum->hit_lima >0 and $get_hsum_n->hit_nine>0){
				 $sum['hsum_lima'] = round(($get_hsum->hit_lima/$get_hbnyk_user)*100);
				 $sum['hsum_nine'] = round(($get_hsum_n->hit_nine/$get_hbnyk_user)*100);
				}else{
					$sum['hsum_lima'] = 0;
					$sum['hsum_nine'] = 0;
				}
				$this->load->view('test',$sum);
			}
			elseif($inpt==7){
				$user = $this->model_app->user()->result();
				foreach($user as $k ){
				$id = $k->reviewerID;
				 $num = $this->model_app->hasil_recom($id)->num_rows()."<br>";
				if($num==7 or $num==8){
					 $get_topnum = $this->model_app->topn($id)->num_rows();
					 $get_hitnum = $this->model_app->hitn($id)->num_rows();
					 $get_topn= $this->model_app->cove_five($id)->num_rows();
					 $get_hitn= $this->model_app->hit_five($id)->num_rows();
					 $get_topnine= $this->db->get_where('top_nine',['reviewerID'=>$id,'top_nine'=>'YES'])->num_rows();
					 $get_hitnine= $this->db->get_where('hit_nine',['reviewerID'=>$id,'hit_nine'=>'NO'])->num_rows();
					 $get_temp = $this->model_app->temp($id)->num_rows();
					 $get_htemp = $this->model_app->temp_hit($id)->num_rows();
					  $cove = $get_topn/$get_topnum ;
					  $cove_nine = $get_topnine/$get_topnum;
					  $hit = $get_hitn/$get_hitnum;
					  $hit_nine = $get_hitnine/$get_hitnum;
					 if($get_temp <= 0){
						 $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
					  }else{
						  $del = $this->model_app->del($id);
						  if($del){
							  $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
						  }
					  }
					  
					  if($get_htemp <= 0){
						 $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
					  }else{
						  $del = $this->model_app->del_hit($id);
						  if($del){
							  $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
						  }
					  }
					}
				}
				$get_sum = $this->model_app->sum_five_rd()->row();
				$get_sum_n = $this->model_app->sum_nine_rd()->row();
				$get_bnyk_user = $this->model_app->b_user_rd()->num_rows();
				
				$get_hsum = $this->model_app->hsum_five_rd()->row();
				$get_hsum_n = $this->model_app->hsum_nine_rd()->row();
				$get_hbnyk_user = $this->model_app->hb_user_rd()->num_rows();
				if($get_sum->cove_lima >0 and $get_sum_n->cove_nine>0){
				 $sum['sum_lima'] = round(($get_sum->cove_lima/$get_bnyk_user)*100);
				 $sum['sum_nine'] = round(($get_sum_n->cove_nine/$get_bnyk_user)*100);
				}else{
					$sum['sum_lima'] = 0;
					$sum['sum_nine'] = 0;
				}
				
				if($get_hsum->hit_lima >0 and $get_hsum_n->hit_nine>0){
				 $sum['hsum_lima'] = round(($get_hsum->hit_lima/$get_hbnyk_user)*100);
				 $sum['hsum_nine'] = round(($get_hsum_n->hit_nine/$get_hbnyk_user)*100);
				}else{
					$sum['hsum_lima'] = 0;
					$sum['hsum_nine'] = 0;
				}
				$this->load->view('test',$sum);
			}
			elseif($inpt==9){
				$user = $this->model_app->user()->result();
				foreach($user as $k ){
				$id = $k->reviewerID;
				 $num = $this->model_app->hasil_recom($id)->num_rows()."<br>";
				if($num==9 or $num==10){
					 $get_topnum = $this->model_app->topn($id)->num_rows();
					 $get_topn= $this->model_app->cove_five($id)->num_rows();
					 $get_topnine= $this->db->get_where('top_nine',['reviewerID'=>$id,'top_nine'=>'YES'])->num_rows();
					 $get_temp = $this->model_app->temp($id)->num_rows();
					  $cove = $get_topn/$get_topnum ;
					  $cove_nine = $get_topnine/$get_topnum;
					 if($get_temp <= 0){
						 $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
					  }else{
						  $del = $this->model_app->del($id);
						  if($del){
							  $in_temp = $this->model_app->in_temp($id,$num,$cove,$cove_nine);
						  }
					  }
					  
					  if($get_htemp <= 0){
						 $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
					  }else{
						  $del = $this->model_app->del_hit($id);
						  if($del){
							  $in_temp = $this->model_app->in_htemp($id,$num,$hit,$hit_nine);
						  }
					  }
					}
				}
				$get_sum = $this->model_app->sum_five_fth()->row();
				$get_sum_n = $this->model_app->sum_nine_fth()->row();
				$get_bnyk_user = $this->model_app->b_user_fth()->num_rows();
				
				$get_hsum = $this->model_app->hsum_five_fth()->row();
				$get_hsum_n = $this->model_app->hsum_nine_fth()->row();
				$get_hbnyk_user = $this->model_app->hb_user_fth()->num_rows();
				if($get_sum->cove_lima >0 and $get_sum_n->cove_nine>0){
				 $sum['sum_lima'] = round(($get_sum->cove_lima/$get_bnyk_user)*100);
				 $sum['sum_nine'] = round(($get_sum_n->cove_nine/$get_bnyk_user)*100);
				}else{
					$sum['sum_lima'] = 0;
					$sum['sum_nine'] = 0;
				}
				if($get_hsum->hit_lima >0 and $get_hsum_n->hit_nine>0){
				 $sum['hsum_lima'] = round(($get_hsum->hit_lima/$get_hbnyk_user)*100);
				 $sum['hsum_nine'] = round(($get_hsum_n->hit_nine/$get_hbnyk_user)*100);
				}else{
					$sum['hsum_lima'] = 0;
					$sum['hsum_nine'] = 0;
				}
				$this->load->view('test',$sum);
			}
		}else{
			$this->load->view('test');
		}
		
	}
}
