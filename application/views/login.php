<?php
echo form_open('berita/p_login');
$inpt = ['name'=>'username'];
$inpt2 = ['name'=>'password'];
echo form_input($inpt);
echo form_input($inpt2);
echo form_submit('enter','login');
echo form_close();
?>