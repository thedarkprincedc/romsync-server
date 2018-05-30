<?php
class ParamsToSql{
      public static function attribute($name, $value){
            return "{$name} {$value}";
      }
      public static function variable($name, $value){
            return "{$name}='{$value}'";
      }
      public static function system($name, $value){
            return ($value) ? "{$name}='{$value}'" : "";
      }
      public static function clones($name, $value){
            if(strcasecmp($value, "primary") == 0){
                  return "cloneof = ''";
            }
            if(strcasecmp($value, "clones") == 0){
                  return "cloneof <> ''";
            }
            return "";
      }
      public static function query($name, $value){
            if(preg_match("/^[0-9]+$/", $value)==1){
                  return "id LIKE '{$value}'";
            }
            if(preg_match("/[A-Za-z0-9\s\_]+/i", $value)){
                  return "name LIKE '{$value}%'";
            }
            if(preg_match("/[A-Za-z0-9\s\_]+(.zip)/i", $value)){
                  return "filename LIKE '{$value}%'";
            }
            return "";
      }
}
?>