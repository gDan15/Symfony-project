<?php

namespace App\Controller;


// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ErrorHttpExceptionController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
      // retrieve the object from database
      // $product = ...;
      // if (!$product) {
      //     throw $this->createNotFoundException('The product does not exist');
      //
      //     // the above is just a shortcut for:
      //     // throw new NotFoundHttpException('The product does not exist');
      // }

      // load the file from the filesystem
    $file = new File('C:\Users\Gaetan\Desktop\ECAM-SoftArch4MIN-2017-Cours5-Slides copie.pdf');
    //
    // return $this->file($file);
    $this->file($file);

    // // rename the downloaded file
    $newfileName = $this->file($file, 'test.pdf');
    //
      // display the file contents in the browser instead of downloading it
    return $this->file($newfileName, 'my_invoice.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
