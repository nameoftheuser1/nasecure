<?php

if (!function_exists('obscureString')) {
    function obscureString($string)
    {
        return str_repeat('*', strlen($string));
    }
}
