<?php

namespace Iidev\AmazonS3ImagesAdvanced\Model\Repo\Base;

use XCart\Extender\Mapping\Extender;

/**
 * @Extender\Mixin
 */
abstract class Image extends \CDev\AmazonS3Images\Model\Repo\Base\Image
{
    /**
     * Get managed image repositories
     *
     * @return array
     */
    public static function getManagedRepositories()
    {
        return array_merge(parent::getManagedRepositories(), ['Qualiteam\SkinActMagicImages\Model\Image', 'QSL\ShopByBrand\Model\Image\Brand\Image']);
    }
}
