<?php     
class Math   
{     
    public static function Max($num1, $num2) {     
        return $num1 > $num2 ? $num1 : $num2;     
    }  

    public function test($num1,$num2){
    	return self::Max($num1,$num2);
    }        
}     
$a = 99;     
$b = 88;     
echo "显示 $a 和 $b 中的最大值是";     
echo "<br />";     
//echo Math::Max($a, $b);     
echo (new Math)->test($a, $b); 
echo "<br />";   
echo "<br />";   
echo "<br />";     
$a = 99;     
$b = 100;     
echo "显示 $a 和 $b 中的最大值是";     
echo "<br />";     
//echo Math::Max($a,$b);
echo (new Math)->test($a, $b);      
?>   