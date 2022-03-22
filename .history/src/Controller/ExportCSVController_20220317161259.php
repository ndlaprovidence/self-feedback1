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
        use League\Csv\Writer;

$header = ['first name', 'last name', 'email'];
$records = [
    [1, 2, 3],
    ['foo', 'bar', 'baz'],
    ['john', 'doe', 'john.doe@example.com'],
];

//load the CSV document from a string
$csv = Writer::createFromString();

//insert the header
$csv->insertOne($header);

//insert all the records
$csv->insertAll($records);

echo $csv->toString(); //returns the CSV document as a string

        return $this->render('export_csv/index.html.twig', ['controller_name' => 'ExportCSVController',]);
    }
}