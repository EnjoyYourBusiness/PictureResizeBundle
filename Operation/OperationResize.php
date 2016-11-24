<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 15:25
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\PictureResizeBundle\Operation;

use EnjoyYourBusiness\PictureResizeBundle\Image\Image;


/**
 * Class OperationResize
 *
 * @package   EnjoyYourBusiness\PictureResizeBundle\Operation
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class OperationResize implements OperationInterface
{
    const DIMENSION_WIDTH = 'width';
    const DIMENSION_HEIGHT = 'height';
    const NAME_FORMAT = 'resize-%d-%d';
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * OperationResize constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Applies the operation to an image
     *
     * @param Image $image
     *
     * @return resource
     */
    public function apply(Image $image)
    {
        $ratio_orig = $image->getWidth() / $image->getHeight();
        $width = $this->width;
        $height = $this->height;
        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        $newResource = imagecreatetruecolor($width, $height);
        imagecopyresampled($newResource, $image->getResource(), 0, 0, 0, 0, $width, $height, $image->getWidth(), $image->getHeight());

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