<?php namespace Ngaji\FileHandler;
use Ngaji\Http\Request;

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
     * @param $target String target path
     * @return bool|string
     */
    public static function upload($type, $name, $target = null) {
        if (Request::FILES($name, 'name')) {
            $photo = Request::FILES($name, 'name'); # $_FILES[$name]['name']
            $tmp = Request::FILES($name, 'tmp_name'); # $_FILES[$name]['tmp_name'];
            $type = Request::FILES($name, 'type'); # $_FILES[$name]['type'];
            $size = Request::FILES($name, 'size'); # $_FILES[$name]['size'];
            $encode = explode('.', $photo);
            $encode2 = explode('php', $tmp);
            $decode = $encode2[1];
            $decode2 = explode('.', $decode);
            $decode3 = $decode2[0] . "." . $encode[1];

            switch ($type) {
                case 'image/jpeg':
                    if ($size > 1000000) { # max. 1 MB.
                        echo "<i>ukuran file terlalu besar.</i>";
                        return false;
                    } else {
                        if (('image/jpeg' == $type) or ('image/png' == $type) or ('' == $type)) {
                            # $tmp = $_FILES[$name]['tmp_name'];

                            $folder = ABSPATH . "/assets/images/" . (($target) ?
                                    "{$target}/" : '') . $decode3;
                            move_uploaded_file($tmp, $folder);

                            return (($target) ? "{$target}/" : '') . $decode3;
                        } else {
                            echo "<i>File tidak support.</i>";
                            return false;
                        }
                    }
                    break;
            }
        }
        return false;
    }

    /**
     * Delete file in the server!
     *
     * @param $type (img|doc|etc.)
     * @param $file_location
     */
    public static function delete($type, $file_location) {
        $base = ABSPATH . "assets/";
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