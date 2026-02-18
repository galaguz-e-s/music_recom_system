<?php
class FileCache {
private $cachePath;
private $defaultExpiry;

public function __construct($cachePath = 'cache', $defaultExpiry = 3600) {
	$this->cachePath = rtrim($cachePath, '/');
	$this->defaultExpiry = $defaultExpiry;

	if (!file_exists($this->cachePath)) {
		mkdir($this->cachePath, 0755, true);
	}
}

public function get($key) {
	$filename = $this->getCacheFilename($key);

	if (!file_exists($filename)) {
		return null;
	}

	$content = file_get_contents($filename);
	$data = unserialize($content);

	if ($data['expires'] < time()) {
	unlink($filename);
	return null;
	}

	return $data['content'];
}

public function set($key, $value, $expiry = null) {
	$expiry = $expiry ?: $this->defaultExpiry;
	$filename = $this->getCacheFilename($key);

	$data = [
	'expires' => time() + $expiry,
	'content' => $value
	];

	file_put_contents($filename, serialize($data), LOCK_EX);
}

public function delete($key) {
	$filename = $this->getCacheFilename($key);
	if (file_exists($filename)) {
	unlink($filename);
	}
}

private function getCacheFilename($key) {
	return $this->cachePath . '/' . md5($key) . '.cache';
	}
}
?>