<?php

namespace Iidev\AmazonS3ImagesAdvanced\Model\Base;

use XCart\Extender\Mapping\Extender;

/**
 * @Extender\Mixin
 */
abstract class Image extends \XLite\Model\Base\Image
{
    public function getFrontURL()
    {
        $url = parent::getFrontURL();
        return $this->getWebPUrl($url);
    }

    public function getResizedURL($width = null, $height = null, $basewidth = null, $baseheight = null)
    {
        $url = parent::getResizedURL($width, $height, $basewidth, $baseheight);

        if (is_array($url)) {
            foreach ($url as $key => $value) {
                if (is_string($value)) {
                    $url[$key] = $this->getWebPUrl($value);
                }
            }
        } else if (is_string($url)) {
            $url = $this->getWebPUrl($url);
        }

        return $url;
    }

    private function getWebPUrl($url)
    {
        if (!\XLite\Core\Config::getInstance()->Iidev->AmazonS3ImagesAdvanced->is_webp_enabled) {
            return $url;
        }

        $domain = \XLite\Core\Config::getInstance()->CDev->AmazonS3Images->cloudfront_domain;
        $webpDomain = \XLite\Core\Config::getInstance()->Iidev->AmazonS3ImagesAdvanced->cloudfront_domain;

        if (is_string($url) && str_contains($url, $domain)) {
            $url = str_replace($domain, $webpDomain, $url);
            $url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $url);
        }

        return $url;
    }
}
