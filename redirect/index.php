<?php

// Array mapping article ids to new descriptive urls
$articleID = array(
  3 => "/2008/10/07/book-review-fundamentals-of-operating-systems-by-a-m-lister",
  2 => "/2008/09/16/how-to-share-an-ssl-certificate-and-still-use-cookies",
  1 => "/2008/08/08/is-cobol-really-understandable-after-14-years"
);

if (array_key_exists($_GET[id], $articleID)) {
	// Redirect to new post page
	header("Location: http://techtinkering.com/".$articleID[$_GET[id]]);
} elseif ($_GET[tag]) {
  header("Location: http://techtinkering.com/tag/".$_GET[tag]);
} else {
  header("Location: http://techtinkering.com/");
}
exit;

?>

