<?php
    namespace App\Controller;

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

        }
    }
?>