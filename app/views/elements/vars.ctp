<?php
ob_clean();
header('Content-Type: text/html; charset=utf-8');

$ret = '';
if (is_array($data)) {
	foreach($data as $k => $v) {
		$ret .= "$k=" . urlencode($v) . "&";
	}
} else {
	// NOTE para un parche de mdt ddp
	$ret = $data;
}
echo trim($ret, "&");
