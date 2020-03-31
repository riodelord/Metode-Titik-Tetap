<?php

require_once __DIR__."/vendor/autoload.php";
use MathPHP\Algebra;
use MathPHP\NumericalAnalysis\RootFinding;
use ChrisKonnertz\StringCalc;
use ChrisKonnertz\StringCalc\Exceptions;

class FixedPointCalculator extends ChrisKonnertz\StringCalc\StringCalc
{
    private $fx;
    private $gx;
    private $error_limit;
    private $initial;
    private $decimalPoint = false;
    public function __construct()
    {
        parent::__construct();
    }

    public function setFx($fx){
        $this->fx = $this->convertToPhp(str_replace(" ","",$fx));
        //echo join("",$this->fx)."ksks";
        return $this;
    }

    public function setGx($gx){
        $this->gx = $this->convertToPhp(str_replace(" ","",$gx));
        //echo join("",$this->gx)."ksks";
        return $this;
    }

    public function calculateFx($x){
        return $this->createFunction($x,$this->fx);
    }

    public function calculateGx($x){
        return $this->createFunction($x,$this->gx);
    }

    public function setErrorLimit($error_limit){
        return $this->error_limit = $error_limit;
    }

    private function createFunction($x,$str){
        $pre = join("",$str);
        //$x = str_replace(",","",number_format($x,100,".",null));
        $x = $this->decimalPoint == false ? $x : number_format($x,$this->decimalPoint);
        $pre = str_replace("x",$x,$pre);
        
        //echo $pre."<br/>\n";
        //echo $pre;
        try{
            return $this->calculate($pre);
        }catch(Exception $e){
            return 0;
        }   
    }

    public function setInitial($x){
        $this->initial = $x;
    }

    public function calculatePoint(){
        $error = 1.0;
        $i=0;
        $tabel = [];
        
        while($error > $this->error_limit){
            $tmp = [];
            if($i == 0){
                $tmp['x'] = $this->initial;
            }else{
                $tmp['x'] = $tabel[$i-1]['gx'];
            }
            $tmp['gx'] = $this->calculateGx($tmp['x']);
            $tmp['fx'] = $this->calculateFx($tmp['x']);
            $tmp['e'] = 0;
           //$tmp['e'] = 0;
            //$tmp['e'] = $i >= 1? $this->calcError($tabel[$i-1]['x'],$tabel[$i]['x']) : 0;
            $tabel[] = $tmp;
            if($i > 0){

                $error = $this->calcError($tabel[$i-1]['x'],$tabel[$i]['x']);
                $tabel[$i]['e'] = $error;
                //$tmp['e'] = $error;
                //echo $error;
            }
            
            $i++;
        }
        return $tabel;
    }

    public function setDecimalPoint($point){
        $this->decimalPoint = $point;
    }

    private function calcError($x_awal,$x_akhir){
        return abs($x_akhir - $x_awal);
    }

    private function convertToPhp($str){
        preg_match_all("/[-+\/]/",$str,$matches);
        $exp = [];
        $tes = str_split($str);
        //print_r($tes);
        $tmp = "";
        $pos = 0;

        $operator = ["(",")","+","*","-","/"];

        for ($i=0; $i <=count($tes); $i++) { 
            if($i == count($tes)){
                $exp[] = $tmp;
            }else if(in_array($tes[$i],$operator)){
                if(preg_match_all("/([\d][a-zA-Z])/",$tmp,$matches)){
                    $re = str_split($tmp);
                    $tmp = "";
                    for($j=0;$j<count($re);$j++){
                        $tmp.=$re[$j];
                        $tmp.= ($j == count($re)-1) ? "" : "*";
                    }
                } else if(preg_match_all("/\d?[a-zA-Z]\^\d/m",$tmp,$matches)){
                    $calon = explode("^",$tmp);
                    $tmp = "pow(".$calon[0].",".$calon[1].")";
                } 
                if(!empty($tmp)){
                    $exp[] = $tmp;
                }
                $tmp = "";
                $exp[] = $tes[$i];
            }else {
                $tmp.=$tes[$i];
            }
            //echo $tmp."\n";
        }

        for ($i=0; $i < count($exp); $i++) { 
            if($i < count($exp) -1){
                if(in_array($exp[$i+1],["("]) && is_numeric($exp[$i])){
                    $exp[$i].="*";
                    
                }
            }
        }
        //print_r($exp);
        return $exp;
    }
    
}

/**
 * Retreive POST Value
 *
 */
function getPost($index){
    return isset($_POST[$index]) ? $_POST[$index] : NULL;
}

/**
* Retreive GET Value
*/

function getParam($index){
    return isset($_GET[$index]) ?  $_GET[$index] : NULL;
}

function printNumber($number){
    global $enable_decimal_point;
    if($enable_decimal_point){
        global $decimal_point;
        $no = number_format($number,$decimal_point);
        return floor($no) == $no ? (int) $no : $no;
    }
    return $number;       
}

/*
$fp = new FixedPointCalculator();
$fp->setFx("x^2-2x+3")->setGx("sqrt(2x-3)");
$fp->setErrorLimit(0.000001);
$fp->setInitial(4);
$table = $fp->calculatePoint();
//print_r($table);

*/
//$g = createFunction(4,convertToPhp($str));

//echo $g;

function convertToPhp($str){
    preg_match_all("/[-+\/]/",$str,$matches);
    $exp = [];
    $tes = str_split($str);
    print_r($tes);
    $tmp = "";
    $pos = 0;

    $operator = ["(",")","+","*","-","/"];

    for ($i=0; $i <=count($tes); $i++) { 
        if($i == count($tes)){
            $exp[] = $tmp;
        }else if(in_array($tes[$i],$operator)){
            if(preg_match_all("/([\d][a-zA-Z])/",$tmp,$matches)){
                $re = str_split($tmp);
                $tmp = "";
                for($j=0;$j<count($re);$j++){
                    $tmp.=$re[$j];
                    $tmp.= ($j == count($re)-1) ? "" : "*";
                }
            } else if(preg_match_all("/\d?[a-zA-Z]\^\d/m",$tmp,$matches)){
                $calon = explode("^",$tmp);
                $tmp = "pow(".$calon[0].",".$calon[1].")";
            } 
            if(!empty($tmp)){
                $exp[] = $tmp;
            }
            $tmp = "";
            $exp[] = $tes[$i];
        }else {
            $tmp.=$tes[$i];
        }
        //echo $tmp."\n";
    }

    for ($i=0; $i < count($exp); $i++) { 
        if($i < count($exp) -1){
            if(in_array($exp[$i+1],["("])){
                $exp[$i].="*";
                
            }
        }
    }
    print_r($exp);
    return $exp;
}

//convertToPhp("2(x^2)-2x+3");
?>