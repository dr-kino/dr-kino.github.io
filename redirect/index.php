<?php

// Array mapping article ids to new descriptive urls
$articleID = array(
);

if (array_key_exists($_GET[id], $articleID)) {
	// Redirect to new post page
	header("Location: http://dr-kino.github.io/".$articleID[$_GET[id]]);
} elseif ($_GET[tag]) {
  header("Location: http://dr-kino.github.io/tag/".$_GET[tag]);
} else {
  header("Location: http://dr-kino.github.io/");
}
exit;

?>

