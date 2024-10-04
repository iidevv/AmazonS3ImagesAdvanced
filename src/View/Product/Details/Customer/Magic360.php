<?php

namespace Iidev\AmazonS3ImagesAdvanced\View\Product\Details\Customer;

use Qualiteam\SkinActMagicImages\Classes\Helper;

use XCart\Extender\Mapping\Extender;

/**
 * @Extender\Mixin
 */
class Magic360 extends \Qualiteam\SkinActMagicImages\View\Product\Details\Customer\Magic360
{
    public function renderTemplate()
    {
        $helper = Helper::getInstance();
        $tool   = $helper->getPrimaryTool();
        $tool->params->setProfile('product');
        if ($tool->params->checkValue('enable-effect', 'No')) {
            return false;
        }

        $thumbMaxWidth  = intval($tool->params->getValue('thumb-max-width', 'product'));
        $thumbMaxHeight = intval($tool->params->getValue('thumb-max-height', 'product'));

        $product                = $this->getProduct();
        $magicSwatchesSet       = $this->getSwatchMagicImages();
        $this->currentProductId = $product->getId();
        $images                 = $magicSwatchesSet ? $magicSwatchesSet->getImages()->toArray() : [];
        $imagesCount            = count($images);
        if ($imagesCount) {
            $tool->params->setValue('columns', $magicSwatchesSet->getSpinColumns());
        } else {
            //NOTE: old way
            $images = $magicSwatchesSet ? $magicSwatchesSet->getImages()->toArray() : [];
        }

        $toolData = [];

        foreach ($images as $index => $image) {

            $img = $image->getFrontURL();
            [$width, $height, $thumb] = $image->doResize($thumbMaxWidth, $thumbMaxHeight, false);

            $toolData[] = [
                'medium' => $thumb,
                'img'    => $img,
            ];

        }

        $this->renderedHTML = $tool->getMainTemplate($toolData, ['id' => 'productMagic360']);
        $this->renderedHTML = '<div class="MagicToolboxContainer widget-fingerprint-magic360">' . $this->renderedHTML . '</div>';

        return true;
    }
}
