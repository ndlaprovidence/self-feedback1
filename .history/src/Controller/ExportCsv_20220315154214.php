<?php
    namespace App\Controller;

    use App\Repository\StudentRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/student")
     */
    class ExportCsv extends AbstractController
    {
        /**
         * @Route("/export.csv", name="exportcsv", options={"expose"=true}, methods={"GET","POST"})
         */
        public function exportcsv()
        {
        /**
         *  @Route("/", name="student_csvweek", methods={"GET"})
         */
        function csvWeek(StudentRepository $StudentRepository): Response
        {
            header('Content-Type: text/csv;');
            header('Content-Disposition: attachment; filename="Liste des Notes.csv"');

            $data = $StudentRepository->findAll();

            foreach ($data as $d)
            {
                echo '"' . $d->noteRepas . '";"' . $d->noteValeurEnvironnement . '";"' . $d->noteCommentaire . '";"' . $d->noteDate . '";' . ";\n";
            }
        }
    }
?>