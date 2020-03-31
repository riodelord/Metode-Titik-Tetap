<?php
set_time_limit(3);
require_once __DIR__."/../lib.php";
$fx = getPost('fx');
$gx = getPost("gx");
$error_limit = getPost('error_limit');
$nilai_awal = getPost('nilai_awal');
$enable_decimal_point = getPost('enable_decimal_point');
$decimal_point = getPost('decimal_point');


$fp = new FixedPointCalculator();
if($fx && $gx && $error_limit && $nilai_awal){
    $fp->setFx($fx)->setGx($gx);
    $fp->setErrorLimit($error_limit);
    $fp->setInitial($nilai_awal);
    if($enable_decimal_point == true){
        $fp->setDecimalPoint($decimal_point);
    }
    $table = $fp->calculatePoint();
    $hasil_akhir = $table[count($table) - 1];
}
//echo "</pre>";
if($hasil_akhir['x'] == 0){
    ?>
        <h2 class="text-center display-4">coba bentuk g(x) yang lain</h2>
    <?
    die();
}
?>
<script>
reload_js("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
</script>
    <SCRIPT>//MathJax.Hub.Config({ tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}})</SCRIPT>
<div class="card">
                <div class="card-body">
                    <h3 class="display-5"><i class="fa fa-plane"></i> Hasil</h3>
                    <hr>
                        
                
<div class="text-center">
        Hasil : </center>
        <h2><?=$hasil_akhir['x']?></h2>
        <small>Total : <?=count($table)?> iterasi</small>
</div>
<hr>
<div class="container">

    <center><button data-toggle="collapse" class="btn btn-outline-primary btn-lg btn-block" data-target="#orekorekan">Tabel</button></center>

    <div class="collapse py-2" style="margin-top:0px" id="orekorekan">
    <?php
    //print_r($table);
    ?>
        <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">i</th>
                <th scope="col">x<sub>i</sub> </th>
                <th scope="col">f(x<sub>i</sub>)</th>
                <th scope="col">g(x<sub>i-1</sub>)</th>
                <th scope="col">e</th>
                </tr>
            </thead>
            <tbody>
                
                    <?php
                    
                    foreach($table as $i => $row){
                        ?>
                        <tr>
                            <th scope="row"><?=$i?></th>
                            <td><?=printNumber($row['x'])?></td>
                            <td><?=printNumber($row['fx'])?></td>
                            <td><?=printNumber($row['gx'])?></td>
                            <td><?=printNumber($row['e'])?></td>
                        </tr>
                        <?
                    }

                    ?>
                    
                
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
            </div>