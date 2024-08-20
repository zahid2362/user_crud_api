<?php

use Illuminate\Support\Facades\Storage;

if(!function_exists('fileUpload')) {
    function fileUpload(string $path, string $name, mixed $file, ?string $old = null): string|bool
    {
        if (!empty($old) && Storage::exists($old)) {
            Storage::delete($old);
        }

        $fileName = $name . '.' . $file->getClientOriginalExtension();
        return Storage::putFileAs($path, $file, $fileName);
    }
}
