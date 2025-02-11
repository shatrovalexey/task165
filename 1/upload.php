<?php
function response($data, $success = false): void
{
	http_response_code($success ? 200 : 400);
	header('Content-Type: application/json');

	echo json_encode($success ? ['data' => $data,] : ['error' => $data,]);

	exit;
}

if (!isset($_REQUEST['char']) || (mb_strlen($_REQUEST['char']) != 1)) {
	response('Не передан "заданный символ"');
}
if (empty($_FILES['file'])) {
	response('Не передан файл');
}
if (
	empty($_FILES['file']['tmp_name'])
	|| !is_uploaded_file($_FILES['file']['tmp_name'])
) {
	response('Не удалось загрузить файл');
}

$filePath = tempnam('files', __LINE__);

if (
	!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)
	|| !($fh = fopen($filePath, 'rb'))
) {
	response(error_get_last()['message']);
}

[$digits, $lines, $line, $count,] = [range(0, 9), [], '', 0,];

while (!feof($fh)) {
	$char = fgetc($fh);

	if ($char === $_REQUEST['char']) {
		$lines[] = ['line' => $line, 'count' => $count,];
		[$line, $count,] = ['', 0,];

		continue;
	}

	$line .= $char;
	$count += in_array($char, $digits, true) ? 1 : 0;
}

if (mb_strlen($line)) {
	$lines[] = ['line' => $line, 'count' => $count,];
}

fclose($fh);

response($lines, true);