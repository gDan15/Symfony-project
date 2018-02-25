<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky", name="lucky")
     */
    public function index(LoggerInterface $logger)
    {
      $logger->info('We are logging!');
      return $this->render('lucky/index.html.twig', [
          'controller_name' => 'LuckyController',
      ]);

        // return $this->redirect('http://symfony.com/doc');
    }
}
