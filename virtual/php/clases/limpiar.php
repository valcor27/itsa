<?php
    /*-----Primer letra de cada palabra en mayuscula y permitir acentos--------------------------*/ 
        function sanear_string($string)
        {
         
           $string = mb_convert_case($string, MB_CASE_TITLE, "utf8");
           $string = addslashes($string);
           $string = trim($string); 

            return $string;
        }
    /*-------------------------------------------------------------------------------------------*/

    /*-----Respetar email con simbolos especiales------------------------------------------------*/ 
        function sanear_normal($string_normal)
        {
         
           $string_normal = addslashes($string_normal);
           $string_normal = trim($string_normal); 

            return $string_normal;
        }
    /*-------------------------------------------------------------------------------------------*/

    /*-----Quitar los simbolos en precio---------------------------------------------------------*/
    function sanear_precio($string_precio)
    {
     
        $string_precio = str_replace(
            array('$', ','),
            array('', ''),
            $string_precio
        );
     
        return $string_precio;
    }
    /*-------------------------------------------------------------------------------------------*/

    /*dar formato al precio con , y .------------------------------------------------------------*/
    function formato_precio($string_formato)
    {
     
        $string_formato = number_format($string_formato,2,'.',',');
     
        return $string_formato;
    }
    /*-------------------------------------------------------------------------------------------*/
?>