<?php

namespace App\Services;

use Com\Tecnick\Barcode\Barcode;

class BarcodeService
{
    const RETURN_TYPE_DIV = 1;
    const RETURN_TYPE_IMAGE = 2;
    const BARCODE_TYPE = 'C128C';
    const QRCODE_TYPE = 'QRCODE,H';
    private $types = [self::BARCODE_TYPE, self::QRCODE_TYPE];
    private $return_types = [self::RETURN_TYPE_DIV, self::RETURN_TYPE_IMAGE];

    public function genBarCode($type = '', $width = 450, $height = 70, $return_type = self::RETURN_TYPE_IMAGE, $string = '')
    {
        if (!in_array($type, $this->types)
            || !in_array($return_type, $this->return_types)
        ) {
            return ['', ''];
        }
        $string = $string ?: date('YmdHis');
        $code = self::genCodeTag($string);
        $object = self::createBarcodeObj($string, $type, $width, $height);

        switch ($return_type) {
            case self::RETURN_TYPE_DIV:
                $result = $object->getHtmlDiv();
                break;
            case self::RETURN_TYPE_IMAGE:
                $result = self::genImgTag($object);
                break;
            default:
                $result = '';
                break;
        }
        return [$result, $code];
    }

    private function genCodeTag($string)
    {
        return '<p>'.$string.'</p>';
    }

    private function genImgTag($object)
    {
        $img_data = $object->getPngData();
        return '<img alt="Embedded Image" src="data:image/png;base64,'.base64_encode($img_data).'" />';
    }

    public function storeBarcodeImg()
    {
        // $timestamp = time();
        // $locate = '/barcode/';
        // $targetPath = public_path($locate);
        // if (! is_dir($targetPath)) {
        //     mkdir($targetPath, 0777, true);
        // }
        // file_put_contents($targetPath . $timestamp . '.png', $imageData);
        // $data = '<img src="' . $locate . $timestamp . '.png">';
    }

    /**
     * Create barcode object
     *    type: C128C: Barcode
     *    type: QRCODE: QRcode
     *
     * @param string $type [barcode type and additional comma-separated parameters]
     * @param int $width [width barcode]
     * @param int $height [height barcode]
     * @param string $foreground [foreground color]
     * @param array $padding [top, right, bottom, left]
     *
     */
    private function createBarcodeObj($data, $type = 'QRCODE,H', $width = -4, $height = -4, $foreground = 'black', $padding = [0, 0, 0, 0], $background = '')
    {
        $barcode = new Barcode();
        $object = $barcode->getBarcodeObj($type, $data, $width, $height, $foreground, $padding);
        return !empty($background) ? $object->setBackgroundColor($background) : $object;
    }
}
