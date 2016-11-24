<?php
/**
 * Created by Enjoy Your Business.
 * Date: 24/11/2016
 * Time: 14:31
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace EnjoyYourBusiness\PictureResizeBundle\Image;

use EnjoyYourBusiness\PictureResizeBundle\Exception\FileNotFoundException;
use EnjoyYourBusiness\pictureresizebundle\Exception\UnsupportedImageTypeException;
use EnjoyYourBusiness\PictureResizeBundle\Operation\OperationInterface;

/**
 * Class Image
 *
 * @package   EnjoyYourBusiness\PictureResizeBundle\Image
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class Image
{
    const NAME_FORMAT = '#^\/([^\/]+\/)*(?<name>.+)\.(?<ext>.+)$#';
    const NEW_PATH_FORMAT = '%s/%s.%s.%s';

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $imageSize;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $extension;

    /**
     * Image constructor.
     *
     * @param $path
     *
     * @throws FileNotFoundException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }

        $this->path = $path;
        $this->imageSize = getimagesize($this->path);
        $matches = [];
        if(preg_match(self::NAME_FORMAT, $this->path, $matches) === 1) {
            $this->name = $matches['name'];
        } else {
            throw new \Exception(sprintf('Could not find the name for "%s"', $this->path));
        }

        switch ($this->getMimeType()) {
            case 'image/jpeg' :
                $this->extension = 'jpeg';
                break;
            case 'image/png' :
                $this->extension = 'png';
                break;
            case 'image/gif' :
                $this->extension = 'gif';
                break;
            default:
                throw new UnsupportedImageTypeException($this->getMimeType());
        }
    }

    /**
     * Gets path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Gets the name without extension
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the image width
     *
     * @return int
     */
    public function getWidth(): int
    {
        return (int) $this->imageSize[0];
    }

    /**
     * Gets the image height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return (int) $this->imageSize[1];
    }

    /**
     * Gets the file mime type
     *
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->imageSize['mime'];
    }

    /**
     * Gets a resource for GD
     *
     * @return resource
     */
    public function getResource()
    {
        if (!is_resource($this->resource)) {
            $this->open();
        }
        return $this->resource;
    }

    /**
     * Loads the resource
     *
     * @throws UnsupportedImageTypeException
     */
    public function open()
    {
        if (!is_resource($this->resource)) {
            switch ($this->getMimeType()) {
                case 'image/jpeg' :
                    $this->resource = imagecreatefromjpeg($this->path);
                    break;
                case 'image/png' :
                    $this->resource = imagecreatefrompng($this->path);
                    break;
                case 'image/gif' :
                    $this->resource = imagecreatefromgif($this->path);
                    break;
                default:
                    throw new UnsupportedImageTypeException($this->getMimeType());
            }
        }
    }

    /**
     * Unloads the resource
     */
    public function close()
    {
        if (is_resource($this->resource)) {
            imagedestroy($this->resource);
        }
    }

    /**
     * Creates a copy of the image to a new destination after optionnaly performing an operation on the image
     *
     * @param string             $destination
     * @param OperationInterface $operation
     *
     * @return Image
     *
     * @throws UnsupportedImageTypeException
     */
    public function applyOperation(string $destination, OperationInterface $operation): Image
    {
        $this->open();
        $resource = $operation->apply($this);
        $this->close();

        if (!file_exists($destination)) {
            mkdir($destination, 0666, true);
        }

        $newPath = sprintf(self::NEW_PATH_FORMAT, $destination, $this->getName(), $operation->getName(), $this->extension);

        switch ($this->getMimeType()) {
            case 'image/jpeg' :
                imagejpeg($resource, $newPath);
                break;
            case 'image/png' :
                imagepng($resource, $newPath);
                break;
            case 'image/gif' :
                imagegif($resource, $newPath);
                break;
            default:
                throw new UnsupportedImageTypeException($this->getMimeType());
        }

        imagedestroy($resource);

        $file = new Image($newPath);

        return $file;
    }

    /**
     * Compute the new path after applying an operation. The operation won't be applied but you may use the result to
     * check if the file was previously operated.
     *
     * @param string             $destination
     * @param OperationInterface $operation
     *
     * @return string
     */
    public function getPathAfterOperation(string $destination, OperationInterface $operation): string
    {
        return sprintf(self::NEW_PATH_FORMAT, $destination, $this->getName(), $operation->getName(), $this->extension);;
    }

    /**
     * Destructs the image
     */
    public function __destruct()
    {
        $this->close();
    }
}