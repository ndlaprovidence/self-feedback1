<?php

namespace App\Controller;

use League\Csv\Writer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExportCSVController extends AbstractController
{
    /**
     * @Route("/export/c/s/v", name="app_export_c_s_v")
     */
    public function index(): Response
    {
        //we fetch the info from a DB using a PDO object
        $sth = $dbh->prepare(
            "SELECT firstname, lastname, email FROM users LIMIT 200"
        );
        //because we don't want to duplicate the data for each row
        // PDO::FETCH_NUM could also have been used
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //we create the CSV into memory
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        //we insert the CSV header
        $csv->insertOne(['firstname', 'lastname', 'email']);

        // The PDOStatement Object implements the Traversable Interface
        // that's why Writer::insertAll can directly insert
        // the data into the CSV
        $csv->insertAll($sth);

        // Because you are providing the filename you don't have to
        // set the HTTP headers Writer::output can
        // directly set them for you
        // The file is downloadable
        $csv->output('users.csv');
        die;

        return $this->render('export_csv/index.html.twig', ['controller_name' => 'ExportCSVController',]);
    }
}