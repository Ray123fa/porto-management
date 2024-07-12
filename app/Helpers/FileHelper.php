<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class FileHelper
{
	/**
	 * Generates a random file name for the uploaded file.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $file  The uploaded file.
	 * @return string  The generated file name.
	 */
	public static function generateFileName(UploadedFile $file): string
	{
		do {
			$filename = Str::random(16) . '.' . $file->getClientOriginalExtension();
		} while (Storage::disk('public')->exists('portos/' . $filename));

		return $filename;
	}
}
