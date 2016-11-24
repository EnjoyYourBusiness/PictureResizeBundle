<?php
declare(strict_types = 1);

/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 14:50
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\pictureresizebundle\Tests\Image;


use EnjoyYourBusiness\PictureResizeBundle\Image\Image;
use EnjoyYourBusiness\PictureResizeBundle\Operation\OperationResize;
use EnjoyYourBusiness\PictureResizeBundle\Operation\OperationResizeCrop;

class ImageTest extends \PHPUnit_Framework_TestCase
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
     * testFileJpeg
     */
    public function testFilePng()
    {
        $filePath = __DIR__ . '/../Resources/pictures/test.png';

        $this->assertTrue(file_exists($filePath));

        return $filePath;
    }

    /**
     * testContruct
     *
     * @param string $filePath
     *
     * @depends testFileJpeg
     *
     * @return Image
     */
    public function testConstruct(string $filePath)
    {
        $image = new Image($filePath);

        $this->assertInstanceOf(Image::class, $image);

        return $image;
    }

    /**
     * testGetResource
     *
     * @depends testFileJpeg
     *
     * @param string $filePath
     */
    public function testGetMimeTypeJpeg(string $filePath)
    {
        $image = new Image($filePath);

        $this->assertEquals('image/jpeg', $image->getMimeType());
    }

    /**
     * testGetResource
     *
     * @depends testFilePng
     *
     * @param string $filePath
     */
    public function testGetMimeTypePng(string $filePath)
    {
        $image = new Image($filePath);

        $this->assertEquals('image/png', $image->getMimeType());
    }

    /**
     * testGetResource
     *
     * @param Image $image
     *
     * @depends testConstruct
     */
    public function testGetResourceJpeg(Image $image)
    {
        $this->assertInternalType('resource', $image->getResource());
    }

    /**
     * testGetWidth
     *
     * @param Image $image
     *
     * @depends testConstruct
     */
    public function testGetWidth(Image $image)
    {
        $this->assertEquals(550, $image->getWidth());
    }

    /**
     * testGetWidth
     *
     * @param Image $image
     *
     * @depends testConstruct
     */
    public function testGetHeight(Image $image)
    {
        $this->assertEquals(636, $image->getHeight());
    }

    /**
     * testGetResource
     *
     * @depends testFilePng
     *
     * @param string $filePath
     */
    public function testGetName(string $filePath)
    {
        $image = new Image($filePath);

        $this->assertEquals('test', $image->getName());
    }

    /**
     * testGetResource
     *
     * @depends testConstruct
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeName(Image $image)
    {
        $operation = new OperationResize(200, 200);

        $filePath = __DIR__ . '/../Resources/pictures/operated';

        $result = $image->applyOperation($filePath, $operation);

        $this->assertEquals($image->getName() . '.resize-200-200', $result->getName());

        return $result;
    }

    /**
     * testGetResource
     *
     * @depends testOperationResizeName
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeWidth(Image $image)
    {
        $this->assertLessThanOrEqual(200, $image->getHeight());
    }

    /**
     * testGetResource
     *
     * @depends testOperationResizeName
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeHeight(Image $image)
    {
        $this->assertLessThanOrEqual(200, $image->getHeight());
    }

    /**
     * testGetResource
     *
     * @depends testOperationResizeName
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeBoth(Image $image)
    {
        $this->assertTrue($image->getHeight() === 200 || $image->getWidth() === 200);
    }

    /**
     * testGetResource
     *
     * @depends testConstruct
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeCropName(Image $image)
    {
        $operation = new OperationResizeCrop(200, 200);

        $filePath = __DIR__ . '/../Resources/pictures/operated';

        $result = $image->applyOperation($filePath, $operation);

        $this->assertEquals($image->getName() . '.crop-200-200', $result->getName());

        return $result;
    }

    /**
     * testGetResource
     *
     * @depends testOperationResizeCropName
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeCropWidth(Image $image)
    {
        $this->assertEquals(200, $image->getHeight());
    }

    /**
     * testGetResource
     *
     * @depends testOperationResizeCropName
     *
     * @param Image $image
     *
     * @return Image
     */
    public function testOperationResizeCropHeight(Image $image)
    {
        $this->assertEquals(200, $image->getHeight());
    }
}
