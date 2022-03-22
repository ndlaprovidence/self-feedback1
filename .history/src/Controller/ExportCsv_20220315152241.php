<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename="Liste des Notes.csv"');

        $data = $StudentRepository->findAll();
        ?>
        "Notes du Repas"; "Notes de l'Environnement"; "Commentaires"; "Dates";
        <?php
        foreach ($data as $d) {
            echo '"' . $d->noteRepas . '";"' . $d->noteValeurEnvironnement . '";"' . $d->noteCommentaire . '";"' . $d->noteDate . '";' . ";\n";
        }
    }
}
