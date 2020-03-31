<?php

$anggota = json_decode(file_get_contents(__DIR__."/../anggota.json"));

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Metode Iterasi Fixed Point</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css" integrity="sha256-gVCm5mRCmW9kVgsSjQ7/5TLtXqvfCoxhdsjE6O1QLm8=" crossorigin="anonymous" />
    <style>
    body{
        font-family: 'Lato', sans-serif;
    }
    h1{
        font-family: 'Lato', sans-serif;
    }
    table{
        font-family: 'Lato', sans-serif;
    }

    .hideradio{
        visibility: hidden;

    }

    .loading {
    position: fixed;
    z-index: 999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    }

    .loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,1);
    }

    .loading:not(:required) {
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    @-webkit-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @-moz-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @-o-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @keyframes  spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    
    .banner{
        background: url('/assets/img/bg.jpg');
        background-size:cover;
          box-shadow:inset 0 0 0 2000px rgba(0,0,0,0.5);
          background-attachment:fixed;
        
    }
    .block{
        border: 2px solid 0; border-radius: 25px; 
        box-shadow:inset 0 0 0 2000px rgba(0,0,0,0.5);
        opacity: .4; 
        width:70%;
        margin-left:auto;
        margin-right:auto;
        
    }

    .block:hover{
        opacity : 1;
        cursor:pointer;
    }
    </style>
</head>
<div class="loading">Loading&#8230;</div>
<body>
<script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
    <SCRIPT SRC='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></SCRIPT>
    <SCRIPT>MathJax.Hub.Config({ tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}})</SCRIPT>
<nav class="navbar navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="#">
        <i class="fa fa-calculator"></i> METODE ITERASI TITIK TETAP
  </a>
</nav>
<div class="jumbotron jumbotron-fluid banner text-center text-white">
  <div class="container">
    <h1 class="display-4 bg-dark block text-nice">
     Komputasi <i class="fa fa-calculator"></i> Numerik</h1>
    <p class="lead bg-dark block">METODE ITERASI TITIK TETAP</p>
  </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 py-2">
            <div class="card">
                <div class="card-body">
                    <h3 class="display-5"><i class="fa fa-list"></i> Input</h3>
                    <hr>
                    <form action="proses.php" id="form" method="POST">
                        <div class="form-group">
                            <label for="inputEmail4">Fungsi f(x)</label>
                            <input type="text" class="form-control" name="fx" placeholder="f(x) = " value="x^2 - 2x - 3">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Fungsi g(x)</label>
                            <input type="text" class="form-control" name="gx" placeholder="g(x) = " value="sqrt(2x+3)">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Error Limit</label>
                                <input type="text" class="form-control" name="error_limit" placeholder="error limit" value="0.000001">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Nilai Awal</label>
                                <input type="number" class="form-control" name="nilai_awal" placeholder="nilai awal" value="4">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4"><input type="checkbox" value="true" checked id="dec_point" name="enable_decimal_point"> Masukan jumlah digit dibelakang koma</label>
                                <input type="number" class="form-control" name="decimal_point" placeholder="nilai awal" value="10" id="decimal_point">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-block btn-primary">Run!</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card my-2">
                <div class="card-body">
                <h3 class="display-5"><i class="fa fa-users"></i> Hello World!</h3>
                <hr>
                <ol>

                    <?php
                    foreach($anggota as $person){
                        ?>
                        <li><?=$person->nama?><br><span class="badge badge-primary">Nim <?=$person->nim?></span></li>
                        <?
                    }
                    ?>
                    
                    
                </ol>
                </div>
            </div>
        </div>
        <div class="col-md-8 py-2"  id="result">
            <div class="card">
                <div class="card-body">
                    <h3 class="display-5"><i class="fa fa-info"></i> Metode Iterasi Titik Tetap</h3>
                    <hr>
                        <p class="justify">
                        Metode ini kadang-kadang dinamakan metode iterasi sederhana atau metode langsung atau metode substitusi beruntun. Kesederhanaan metode ini karena pembentukan prosedur iterasinya yang mudah dibentuk, yaitu kita ubah persamaan \( f(x)=0 \) menjadi bentuk \( x=g(x) \), kemudian dibentuk menjadi prosedur iterasi,
                        $$ x_{r+1} = g(x_r)$$
                        Dan kita terka sebuah nilai awal (tebakan awal) x<sub>0</sub> , lalu dihitung x<sub>1</sub>, x<sub>2</sub>, x<sub>3</sub>, ..., yang diharapkan konvergen ke akar sejati s sedemikian rupa sehingga \( f(s) = 0\) dan \(s = g(s) \)
                        <hr>
                        Kondisi berhentinya iterasi dinyatakan bila ,<br/>
            \( |x_{r+1} - x_r| < \epsilon \)
                        <br/>Atau bila menggunakan galat relatif hampiran <br/>
                        \( \left|(x_{r+1} - x_r) \over x_{r+1} \right| < \delta \)

                        </p>
                        <p class="justify">
                        <b>Note : untuk Fungsi g(x) masukan syntax math. example : [sqrt,pow..etc]
                        </p>
                </div>
            </div>
        </div>
    </div>
  </div>
  <script>

    function loadPage(html){
        $("#result").html(html);
    }

    function reload_js(src) {
        $('script[src="' + src + '"]').remove();
        $('<script>').attr('src', src).appendTo('head');
    }
    /*$(window).load(function(){
            
            //$("#myNav").removeClass("d-none");
    });*/

    function errorPage(){
        alert("Gagal menyambungkan, refresh!");
    }
    $(document).ready(function () {
        $('.loading').fadeOut(1000);
        $("#dec_point").on("change", function () {
            $("#decimal_point").prop("disabled",!this.checked); 
        });
        $("#form").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            dataType: "html",
            beforeSend: function(){
                $("#form button").attr("disabled",true);
                $("#form input").attr("disabled",true);
            },
            success: function (response) {
                loadPage(response)
                $("#form button").removeAttr("disabled");
                $("#form input").removeAttr("disabled");
            }
        }).fail(function(a){
            //alert(a);
            console.log(a);
            $("#form button").removeAttr("disabled");
            $("#form input").removeAttr("disabled");
            errorPage();
        });
        return;
    });
    });
    
<!--       _       _                            _         _  | |       ___      |___  |-->
<!-- _ _ _| |_ ___| |_    ___ ___ ___    _ _   | |___ ___| |_|_|___   |  _|___ ___|  _|-->
<!--| | | |   | .'|  _|  | .'|  _| -_|  | | |  | | . | . | '_| |   |  |  _| . |  _|_|  -->
<!--|_____|_|_|__,|_|    |__,|_| |___|  |___|  |_|___|___|_,_| |_|_|  |_| |___|_| |_|  -->
    
  </script>
</body>
</html>