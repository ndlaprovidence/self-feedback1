<?php

namespace App\Controller;

use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ChartjsController extends AbstractController
{
    /**
     * @Route("/chartjs", name="chartjs")
     */
    public function index(StudentRepository $StudentRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

        // add records to the log
        $log->warning('Foo');
        $log->error('Bar');

        $student = $StudentRepository->findAll();

        $labels = [];
        $data = [];
        $data2 = [];
        $datenoterepas1 = $StudentRepository->getDateRepas1();
        $datenoterepas2 = $StudentRepository->getDateRepas2();
        $datenoterepas3 = $StudentRepository->getDateRepas3();
        $datenoterepas4 = $StudentRepository->getDateRepas4();
        $datenoterepas5 = $StudentRepository->getDateRepas5();
        dump($datenoterepas1);
        dump($datenoterepas2);

        if (isset($datenoterepas1[0]['note_date'])) {
            $labels[] = $datenoterepas1[0]['note_date'];
            $data[] = $datenoterepas1[0]['AVG(note_repas)'];
            $data2[] = $datenoterepas1[0]['AVG(note_valeur_environnement)'];
        }
        if (isset($datenoterepas2[0]['note_date'])) {
            $labels[] = $datenoterepas2[0]['note_date'];
            $data[] = $datenoterepas2[0]['AVG(note_repas)'];
            $data2[] = $datenoterepas2[0]['AVG(note_valeur_environnement)'];
        }
        if (isset($datenoterepas3[0]['note_date'])) {
            $labels[] = $datenoterepas3[0]['note_date'];
            $data[] = $datenoterepas3[0]['AVG(note_repas)'];
            $data2[] = $datenoterepas3[0]['AVG(note_valeur_environnement)'];
        }
        if (isset($datenoterepas4[0]['note_date'])) {
            $labels[] = $datenoterepas4[0]['note_date'];
            $data[] = $datenoterepas4[0]['AVG(note_repas)'];
            $data2[] = $datenoterepas4[0]['AVG(note_valeur_environnement)'];
        }
        if (isset($datenoterepas5[0]['note_date'])) {
            $labels[] = $datenoterepas5[0]['note_date'];
            $data[] = $datenoterepas5[0]['AVG(note_repas)'];
            $data2[] = $datenoterepas5[0]['AVG(note_valeur_environnement)'];
        }
        //dump($datenoteenvironnement);
        /* foreach ($student as $Students) {

            $labels[] = $Students->getNoteDate()->format('d/m/Y');
            $data[] = $Students->getNoteRepas();
            $data2[] = $Students->getNoteValeurEnvironnement();
        }*/

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Note repas',
                    'backgroundColor' => 'rgba(255,255,255, 0.5)',
                    'borderColor' => 'rgb(242, 129, 35)',
                    'pointBackgroundColor' => 'rgb(45,170,255)',
                    'pointBorderColor' => 'rgb(45,170,255)',
                    'data' => $data,
                ],
                [
                    'label' => 'Note Environement',
                    'backgroundColor' => 'rgba(255,255,255, 0.5)',
                    'borderColor' => 'rgb(45,170,255)',
                    'pointBackgroundColor' => 'rgb(45,170,255)',
                    'pointBorderColor' => 'rgb(45,170,255)',
                    'data' => $data2,
                ],
            ],
        ]);

        $chart->setOptions([]);


        return $this->render('chartjs/index.html.twig', [
            'controller_name' => 'Graphique note',
            'chart' => $chart,
        ]);
    }
}
