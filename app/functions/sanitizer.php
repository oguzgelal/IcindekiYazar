<?php

function sanitize_string ($str) { return stripslashes(filter_var($str , FILTER_SANITIZE_MAGIC_QUOTES )); }
function sanitize_int ($int){ return (int) filter_var($int , FILTER_SANITIZE_NUMBER_INT ); }
function sanitize_float ($float) { return (float) filter_var( $data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); }
function sanitize_boolean ($bool) {
  if ($bool == 1 || strtolower($bool) == 'true' ) { return true; }
  else { return false; }
}
function sanitize_email ($email) { return filter_var( $email, FILTER_SANITIZE_EMAIL ); }
function validate_email ($email) { return filter_var($email, FILTER_VALIDATE_EMAIL ); }