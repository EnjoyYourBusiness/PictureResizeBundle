<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 15:10
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\pictureresizebundle\Exception;


/**
 * Class FileNotFoundException
 *
 * @package   EnjoyYourBusiness\pictureresizebundle\Exception
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class UnsupportedImageTypeException extends \Exception
{
    const MESSAGE_FORMAT = 'File type "%s" not supported';
    const ERROR_CODE = 500;

    /**
     * FileNotFoundException constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        parent::__construct(sprintf(self::MESSAGE_FORMAT, $type), self::ERROR_CODE);
    }
}