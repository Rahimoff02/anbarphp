<?php
$unvan = 'images/'.basename($_FILES['foto']['name']);
//jpg/png/jpeg/gif/webp
$tip = strtolower(pathinfo($unvan,PATHINFO_EXTENSION));

if($tip!='jpeg' && $tip!='webp' && $tip!='jpg' && $tip!='png' && $tip!='gif')
{$error = '<div class="alert alert-warning" role="alert">Yalnız <b>jpg/png/jpeg/gif/webp</b> fayl formatlarına icazə verilir.</div>';}

if($_FILES['foto']['size']>5242888)
{$error = '<div class="alert alert-warning" role="alert">Maksimum <b>5-megabayt</b> fayl həcminə icazə verilir.</div>';}

if(!isset($error))
{
    $unvan = 'images/'.time().'.'.$tip;

    move_uploaded_file($_FILES['foto']['tmp_name'], $unvan);
}

?>