<?php

function dd(...$vars): never {
	foreach ($vars as $var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	exit();
}