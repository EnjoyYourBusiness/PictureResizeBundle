<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 15:24
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\PictureResizeBundle\Operation;

use EnjoyYourBusiness\PictureResizeBundle\Image\Image;

/**
 * Class OperationCrop
 *
 * @package   EnjoyYourBusiness\pictureresizebundle\Operation
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class OperationResizeCrop extends OperationResize
{
    const NAME_FORMAT = 'crop-%d-%d';

    /**
     * Applies the operation to an image
     *
     * @param Image $image
     *
     * @return resource
     */
    public function apply(Image $image)
    {
        $ratioOrigin = $image->getWidth() / $image->getHeight();
        $tmpWidth = $this->width;
        $tmpHeight = $this->height;
        $destinationX = 0;
        $destinationY = 0;
        if ($tmpWidth / $tmpHeight > $ratioOrigin) {
            $tmpHeight = $tmpWidth / $ratioOrigin;
            $destinationY = ($this->height - $tmpHeight) / 2;
        } else {
            $tmpWidth = $tmpHeight * $ratioOrigin;
            $destinationX = ($this->width - $tmpWidth) / 2;
        }

        $tmpResource = imagecreatetruecolor($tmpWidth, $tmpHeight);
        imagecopyresampled($tmpResource, $image->getResource(), 0, 0, 0, 0, $tmpWidth, $tmpHeight, $image->getWidth(), $image->getHeight());

        $newResource = imagecreatetruecolor($this->width, $this->height);
        imagecopy($newResource, $tmpResource, $destinationX, $destinationY, 0, 0, $tmpWidth, $tmpHeight);

        return $newResource;
    }

    /**
     * The name of the operation. Should take in conseideration the different versions of the operation ie :
     * a resize should provide a name with the new size : 'resize-{width}-{height}'
     *
     * @return string
     */
    public function getName(): string
    {
        return sprintf(self::NAME_FORMAT, $this->width, $this->height);
    }
}