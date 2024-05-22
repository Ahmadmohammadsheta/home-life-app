<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

Trait ImageProccessingTrait
{
    // Mahmoud Kssab
    private $storage = 'storage';
    private $path = 'attachments';
    private $modelObjectName;

    /**
     * img extenstions
     */
    public function getMime ($mime){
        if ($mime == 'image/jpg')
            $extension = '.jpg';
        elseif ($mime == 'image/jpeg')
            $extension = '.jpeg';
        elseif ($mime == 'image/png')
            $extension = '.png';
        elseif ($mime == 'image/gif')
            $extension = '.gif';
        elseif ($mime  == 'image/svg+xml' )
            $extension = '.svg';
        elseif ($mime == 'image/tiff')
            $extension = '.tiff';
        elseif ($mime == 'image/webp')
            $extension = '.webp';

        return $extension;
    }

    /**
     * Image Name
     */
    public function imageName($image)
    {
        // package documentation says
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read('images/example.jpg');

        // resize image proportionally to 300px width
        $image->scale(width: 300);

        // insert watermark
        $image->place('images/watermark.png');

        // save modified image in new format
        $image->toPng()->save('images/foo.png');
    }

    /**
     * AMA-image package version-3 07-03-2024
     */
    public function setImage($img, $path, $width = null, $height = null)
    {
        $this->modelObjectName = request()->route()->controller->additionalData['modelObjectName'];
        $manager = new ImageManager(new Driver()); // create image manager with desired driver
        $imageName = $this->modelObjectName . time() . $img->getClientOriginalName();
        $image = $manager->read($img); // read image from image system
        $image->scale($width, $height); // resize image

        $image->toJpeg()->save(storage_path("app/public/" . $this->path . "/" . $path . '/' . $imageName)); // (working) save modified image in new format in folder

        // $image->place($image); // insert watermark
        // $image->toJpeg()->save(base_path("public/storage/" . $this->path . "/" . $path . '/' . $imageName)); // (working)  save modified image in new format in folder
        // $image->toJpeg()->save(public_path("storage/" . $this->path . "/" . $path . '/' . $imageName)); // (working) save modified image in new format in folder


        return $imageName; // save image name in database
        // return $this->path. "/" .$path. '/' . $imageName; // save image name in database
    }

    /**
     * Mahmoud Kssab Set array of Images
     */
    public function setImages($images, $path, $column, $width = null, $height = null)
    {
        $imagesName = [];
        foreach($images as $image){
            array_push($imagesName, [ $column => $this->setImage($image, $path, $width, $height)]);
        }
        return $imagesName;
    }

    /**
     * AMA Set array of Images
     */
    public function getImage($image, $path)
    {
        return $this->storage . '/' . $this->path . '/' . $path . '/' . $image;
    }

    /**
     * open files
     */
    public function openFile($path)
    {
        $file = Storage::path('public/' . $this->path . '/' . $path);
        return response()->file($file);
    }

    /**
     * download files
     */
    public function downloadFile($path, $filesName)
    {
        $file = Storage::path('public/' . $this->path . '/' . $path);
        return response()->download($file, Date('Y-m-d H:i:s').$filesName);
    }

    /**
     * update image width and height
     */
    public function aspectForResize($image, $ownerId, $width, $height, $path)
    {
    }

    /**
     * crop image width and height
     */
    public function aspectForCrop($image, $ownerId, $width, $height, $path)
    {
    }

    /**
     * Thumbnail image width and height
     */
    public function ImageThumbnail($image, $ownerId, $path, $thumb = false)
    {
    }

    /**
     * Mahmoud Kssab Delete image
     */
    public function deleteImage($image, $path = null)
    {
        ($path == null) ?: $path = $path.'/';

        if (file_exists($path . $image)) {
            return File::delete($path . $image);
        }
    }

    /**
     * Mahmoud Kssab Delete images
     */
    public function deleteImages($images, $path)
    {
        foreach ($images as $image) {
            $this->deleteImage($path, $image);
        }
    }

    /**
     * AMA.Delete Files Folder
     */
    public function deleteFilesFolder($location)
    {
        return Storage::disk('public')->deleteDirectory($this->path . '/' . $location);
    }

}
