<?php

namespace App\Controller;

use DateTime;
use App\Entity\Student;
use App\Form\StudentType;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="student_index", methods={"GET"})
     */
    public function index(StudentRepository $StudentRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

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

           if(isset($datenoterepas5[0]['note_date'])){
           $labels[] = $datenoterepas5[0]['note_date'];
           $data[] = $datenoterepas5[0]['AVG(note_repas)'];
           $data2[] = $datenoterepas5[0]['AVG(note_valeur_environnement)'];
       }
        if(isset($datenoterepas4[0]['note_date'])){
        $labels[] = $datenoterepas4[0]['note_date'];
        $data[] = $datenoterepas4[0]['AVG(note_repas)'];
        $data2[] = $datenoterepas4[0]['AVG(note_valeur_environnement)'];
    }
    if(isset($datenoterepas3[0]['note_date'])){
        $labels[] = $datenoterepas3[0]['note_date'];
        $data[] = $datenoterepas3[0]['AVG(note_repas)'];
        $data2[] = $datenoterepas3[0]['AVG(note_valeur_environnement)'];
    }
    if (isset($datenoterepas2[0]['note_date'])){
        $labels[] = $datenoterepas2[0]['note_date'];
        $data[] = $datenoterepas2[0]['AVG(note_repas)'];
        $data2[] = $datenoterepas2[0]['AVG(note_valeur_environnement)'];
    }
        if (isset($datenoterepas1[0]['note_date'])){
            $labels[] = $datenoterepas1[0]['note_date'];
           $data[] = $datenoterepas1[0]['AVG(note_repas)'];
           $data2[] = $datenoterepas1[0]['AVG(note_valeur_environnement)'];
       }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Note repas',
                    'backgroundColor' => 'rgba(45,170,255, 0.5)',
                    'borderColor' => 'rgb(45,170,255)',
                    'pointBackgroundColor' => 'rgb(45,170,255)',
                    'pointBorderColor' => 'rgb(45,170,255)',
                    'data' => $data,
                ],
                [
                    'label' => 'Note Environement',
                    'backgroundColor' => 'rgba(242, 129, 35, 0.5)',
                    'borderColor' => 'rgb(242, 129, 35)',
                    'pointBackgroundColor' => 'rgb(242, 129, 35)',
                    'pointBorderColor' => 'rgb(242, 129, 35)',
                    'data' => $data2,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true
                    ]
                ]]
            ]
        ]);

        return $this->render('student/index.html.twig', [
            'students' => $StudentRepository->findAll(),
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/new", name="student_new", methods={"GET","POST"})
     */
    function new (Request $request): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $student = new Student();
        $student->setNoteDate(new DateTime());
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        dump($request);
        if($form->isSubmitted()) {
            dump($form->isValid());
        }
        dump($form->getErrors());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);

            // dump($request);
            // $CurrentDate=$request->get('student')['note_date'];
            //$CurrentDate=date("d/m/Y");

            $entityManager->flush();
            return $this->redirectToRoute('student_valid', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }
        /**
     * @Route("/valid", name="student_valid", methods={"GET"})
     */
     function valid(): Response
    {
        
        return $this->render('student/valid.html.twig', [
            'titre' => 'Votre note à été enregisté !',
        ]);
    }
    /**
     *  @Route("/", name="student_csvweek", methods={"GET"})
     */
    function csvWeek(StudentRepository $StudentRepository): Response
    {
        $sth = getDateEnv();
        //because we don't want to duplicate the data for each row
        // PDO::FETCH_NUM could also have been used
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //we create the CSV into memory
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        //we insert the CSV header
        $csv->insertOne(['classe_id', 'note_repas', 'note_valeur_environnement', 'note_commentaire', 'note_date']);

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

    /**
     * @Route("/{id}", name="student_show", methods={"GET"})
     */
    public function show(Student $student): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Student $student): Response
    {

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_delete", methods={"POST"})
     */
    public function delete(Request $request, Student $student): Response
    {

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $student->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_index', [], Response::HTTP_SEE_OTHER);
    }
}
}