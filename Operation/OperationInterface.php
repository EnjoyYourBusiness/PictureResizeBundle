<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 14:26
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\PictureResizeBundle\Operation;

use EnjoyYourBusiness\PictureResizeBundle\Image\Image;

/**
 * interface OperationInterface
 *
 * @package   EnjoyYourBusiness\pictureresizebundle\Resize
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
interface OperationInterface
{
    /**
     * Applies the operation to an image
     *
     * @param Image $image
     *
     * @return resource
     */
    public function apply(Image $image);

    /**
     * The name of the operation. Should take in conseideration the different versions of the operation ie :
     * a resize should provide a name with the new size : 'resize-{width}-{height}'
     *
     * @return string
     */
    public function getName(): string;
}