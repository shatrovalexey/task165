<?php
function response($data, $success = false): void
{
	http_response_code($success ? 200 : 400);
	header('Content-Type: application/json');

	echo json_encode($success ? ['data' => $data,] : ['error' => $data,]);

	exit;
}