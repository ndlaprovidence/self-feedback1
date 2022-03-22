<?php
    namespace App\Controller;

    use App\Repository\StudentRepository;
    use Symfony\Component\BrowserKit\Response;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\CsvEncoder;
    use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/student")
     */
    class ExportCsv extends AbstractController
    {
        /**
        * @Route("/export.csv", name="exportcsv", options={"expose"=true}, methods={"GET","POST"})
        *
        **/
        public function exportcsv()
        {
            $sessionuser = $this->session->get('user');
            $user = $this->finduser($sessionuser);
            $datas = $this->getDoctrine()->getRepository(Object::class)-> findBy(['Event'=> $user->getEvent()]);
            $encoders = [new CsvEncoder()];
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $csvContent = $serializer->serialize($datas, 'csv'); 
            return new Response($csvContent);

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
    }
?>