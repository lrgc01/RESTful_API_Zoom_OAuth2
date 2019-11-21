<?php
// Here some PHP funcions
function my_filter_args()
{
	$arg_filter = array (
	   'inputEmail'         => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
	   'inputPersonId'      => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
	   'inputEventId'       => array(
			             'filter' => FILTER_VALIDATE_INT,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
	   'inputAction'        => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
	   'inputActive'        => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
	   'inputdelList'       => array(
			             'filter' => FILTER_VALIDATE_INT,
			             'flags'  => FILTER_REQUIRE_ARRAY,
				),
	);
	return $arg_filter;
}

// All functions that use user data should be called after my_input_filter
function my_input_filter($data, $reqMessage='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($reqMessage && strlen($data) == 0)
    {
        die($reqMessage);
    }
    return $data;
}
?>
