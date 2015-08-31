<?php namespace Ngaji\FileHandler;

use finfo;
use Ngaji\Http\Request;
use RuntimeException;

/**
 * Class File
 *
 * Work with file!
 *
 * @package Ngaji\FileHandler
 * @author Ocki Bagus Pratama
 * @since  2.0
 */

class File {

    /**
     * Library for upload file
     * Basically ini PHP way we uses $_FILES['']
     * to handle the file request
     *
     * Usage:
     * $_FILES['name']
     *
     * File::upload('img', 'name')
     *
     * @param $type String
     * @param $name
     * @param $target_path String target path (/assets/$target_path)
     * @return bool|string
     */
    public static function upload($type, $name, $target_path=null) {
        try {
            # Undefined | Multiple Files | $_FILES Corruption Attack
            # If this request falls under any of them, treat it invalid.
            if (!isset($_FILES[$name]['error']) || is_array($_FILES[$name]['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }

            // Check $_FILES['upfile']['error'] value.
            switch (Request::FILES($name, 'error')) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    return null;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            # You should also check filesize here.
            if (Request::FILES($name, 'size') > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            # DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            # Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);

            # switch type
            switch ($type) {
                case 'img':
                    $valid_mime = [
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                    ];
                    $target_path = (isset($target_path)) ? $target_path : 'images';
                    break;
                default:
                    $valid_mime = [
                        'pdf' => 'application/pdf',
                        'doc' => 'application/msword',
                        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    $target_path = (isset($target_path)) ? $target_path : 'proposal';
            }

            # check if that upload file has valid MIME format
            if (false === $ext = array_search(
                    $finfo->file($_FILES[$name]['tmp_name']),
                    $valid_mime,
                    true
                )
            ) {
                throw new RuntimeException('Invalid file format.');
            }

            # check if that upload file not have .php or .inc extension
            if ('php' === $ext or 'inc' === $ext) {
                throw new RuntimeException('Invalid file extension.');
            }

            # new file name
            $new_file_name = sprintf('%s-%s.%s',
                sha1_file($_FILES[$name]['tmp_name']),
                date("Y-m-d-h-m-s"),
                $ext
            );

            # You should name it uniquely.
            # DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            # On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                $_FILES[$name]['tmp_name'],
                sprintf('%s/assets/%s/%s',
                    ABSPATH,
                    $target_path,
                    $new_file_name
                )
            )
            ) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            echo 'File is uploaded successfully.';

            return $new_file_name;

        } catch (RuntimeException $e) {

            echo $e->getMessage();

        }
        return null;
    }

    /**
     * Delete file in the server!
     *
     * @param $type (img|doc|etc.)
     * @param $file_location
     */
    public static function delete($type, $file_location) {
        $base = ABSPATH . "/assets/";
        switch ($type) {
            case 'img':
                unlink("{$base}/images/{$file_location}");
                break;
            case 'doc': # proposal, etc.
                unlink("{$base}/documents/proposal/{$file_location}");
                break;
            default:
                unlink($base . $file_location);
        }
    }
}