<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @Route("/student")
 */
class ExportCsv extends AbstractController
{
    /**
     *  @Route("/", name="student_csvweek", methods={"GET"})
     */
    function csvWeek(StudentRepository $StudentRepository): Response
    {
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

        // add records to the log
        $log->warning('Foo');
        $log->error('Bar');

        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename="Liste-candidature.csv"');

        $data = $StudentRepository->findAll();
?>
        "note Repas";"note Environnement";" Commentaire";" Date";
<?php
        foreach ($data as $d) {
            echo '"' . $d->noteRepas . '";"' . $d->noteValeurEnvironnement . '";"' . $d->noteCommentaire . '";"' . $d->noteDate . '";' . ";\n";
        }
    }
}
