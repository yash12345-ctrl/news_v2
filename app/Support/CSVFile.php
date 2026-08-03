<?php

namespace App\Support;

/**
 * CSVFile
 */
class CSVFile
{
	private $records;
	private $fields;
	private $mapper = null;

	public function __construct(array &$records)
	{
		$this->records = $records;
	}

	public function fields(array $fields)
	{
		$this->fields = $fields;

		return $this;
	}

	public function map(\Closure $closure)
	{
		$this->mapper = $closure;

		return $this;
	}

	public function download()
	{
		$out = fopen('php://output', 'w');

		if ($out === false) {
			throw new \Exception("File open failure");
		}

		// Download HTTP header
		header("Content-Type: application/x-download");
		header('Content-Disposition: attachment; filename=routine_sample.csv');
		header("Cache-Control: private, max-age=0, must-revalidate");
		header("Pragma: public");

		fputcsv($out, $this->fields);

		if ($this->mapper) {
			foreach ($this->records as $record) {
				$row = ($this->mapper)($record);
				if ($row) {
					fputcsv($out, $row);
				}
			}
		} else {
			foreach ($this->records as $record) {
				$row = [];
				foreach ($this->fields as $f) {
					$row[] = isset($record->{$f}) ? $record->{$f} : "";
				}
				fputcsv($out, $row);
			}
		}
		fclose($out);
	}
}