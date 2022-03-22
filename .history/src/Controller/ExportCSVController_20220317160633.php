<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportCSVController extends AbstractController
{
    /**
     * @Route("/export/c/s/v", name="app_export_c_s_v")
     */
    public function index(): Response
    {
        return $this->render('export_csv/index.html.twig', ['controller_name' => 'ExportCSVController',]);
    }
}