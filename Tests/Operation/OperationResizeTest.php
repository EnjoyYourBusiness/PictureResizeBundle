<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 17:06
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\PictureResizeBundle\Tests\Operation;

use EnjoyYourBusiness\PictureResizeBundle\Image\Image;
use EnjoyYourBusiness\PictureResizeBundle\Operation\OperationResize;


/**
 * Class OperationResizeTest
 *
 * @package   EnjoyYourBusiness\pictureresizebundle\Tests\Operation
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class OperationResizeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testFileJpeg
     */
    public function testFileJpeg()
    {
        $filePath = __DIR__ . '/../Resources/pictures/test.jpeg';

        $this->assertTrue(file_exists($filePath));

        return $filePath;
    }

    /**
     * testInstance
     */
    public function testInstance()
    {
        $operation = new OperationResize(200, 200);

        $this->assertInstanceOf(OperationResize::class, $operation);
    }

    /**
     * @depends testFileJpeg
     */
    public function testApply($file)
    {
        $operation = new OperationResize(200, 200);

        $image = new Image($file);

        $resource = $operation->apply($image);

        $this->assertEquals(200, imagesy($resource));

        imagedestroy($resource);
    }
}