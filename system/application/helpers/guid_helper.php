<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function generateCharacter ()
{
   $possible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
   return $char;
}

function generateGUID ()
{
   $GUID = generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
   $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
   $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
   $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
   $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter();
   return $GUID;
}

?>