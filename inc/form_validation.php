<?php
/*
 * Set up Form Validation
 */
function test_form_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}