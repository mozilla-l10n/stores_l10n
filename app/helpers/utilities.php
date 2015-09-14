<?php
/**
 * Utility function to replace <br> tags into line breaks
 */
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
}
