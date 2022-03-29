Skip to content
Search or jump to…
Pull requests
Issues
Marketplace
Explore
 
@CELAULT 
ndlaprovidence
/
self-feedback1
Public
Code
Issues
24
Pull requests
Discussions
Actions
Projects
1
Wiki
Security
Insights
Settings
self-feedback1/src/Controller/StudentController.php /
@yaperson
yaperson Merge branch 'main' into LAB_NOTE_del
Latest commit f4139b4 2 hours ago
 History
 3 contributors
@LuidjyAubel@DylanCahu@yaperson
296 lines (265 sloc)  10.6 KB
   
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
use App\Repository\QrcodeRepository;

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
        $this->denyAccessUnlessGranted('ROLE_USER');

        $student = $StudentRepository->findAll();
        
        $labels = [];
        $data3 = [];
        $data4 = [];
        $data5 = [];
        $data6 = [];
        $data7 = [];
        $data8 = [];
        $datenoterepas1 = $StudentRepository->getDateRepas1();
        $datenoterepas2 = $StudentRepository->getDateRepas2();
        $datenoterepas3 = $StudentRepository->getDateRepas3();
        $datenoterepas4 = $StudentRepository->getDateRepas4();
        $datenoterepas5 = $StudentRepository->getDateRepas5();
        dump($datenoterepas1);
        dump($datenoterepas2);

           if(isset($datenoterepas5[0]['note_date'])){
           $labels[] = $datenoterepas5[0]['note_date'];
           $data3[] = $datenoterepas5[0]["AVG(note_chaleur)"];
           $data4[] = $datenoterepas5[0]["AVG(note_gout)"];
           $data5[] = $datenoterepas5[0]["AVG(notequantite)"];
           $data6[] = $datenoterepas5[0]["AVG(noteacceuil)"];
           $data7[] = $datenoterepas5[0]["AVG(notediversite)"];
           $data8[] = $datenoterepas5[0]["AVG(notehygiene)"];
       }
        if(isset($datenoterepas4[0]['note_date'])){
        $labels[] = $datenoterepas4[0]['note_date'];
        $data3[] = $datenoterepas4[0]["AVG(note_chaleur)"];
        $data4[] = $datenoterepas4[0]["AVG(note_gout)"];
        $data5[] = $datenoterepas4[0]["AVG(notequantite)"];
        $data6[] = $datenoterepas4[0]["AVG(noteacceuil)"];
        $data7[] = $datenoterepas4[0]["AVG(notediversite)"];
        $data8[] = $datenoterepas4[0]["AVG(notehygiene)"];
    }
    if(isset($datenoterepas3[0]['note_date'])){
        $labels[] = $datenoterepas3[0]['note_date'];
        $data3[] = $datenoterepas3[0]["AVG(note_chaleur)"];
        $data4[] = $datenoterepas3[0]["AVG(note_gout)"];
        $data5[] = $datenoterepas3[0]["AVG(notequantite)"];
        $data6[] = $datenoterepas3[0]["AVG(noteacceuil)"];
        $data7[] = $datenoterepas3[0]["AVG(notediversite)"];
        $data8[] = $datenoterepas3[0]["AVG(notehygiene)"];
    }
    if (isset($datenoterepas2[0]['note_date'])){
        $labels[] = $datenoterepas2[0]['note_date'];
        $data3[] = $datenoterepas2[0]["AVG(note_chaleur)"];
        $data4[] = $datenoterepas2[0]["AVG(note_gout)"];
        $data5[] = $datenoterepas2[0]["AVG(notequantite)"];
        $data6[] = $datenoterepas2[0]["AVG(noteacceuil)"];
        $data7[] = $datenoterepas2[0]["AVG(notediversite)"];
        $data8[] = $datenoterepas2[0]["AVG(notehygiene)"];
    }
        if (isset($datenoterepas1[0]['note_date'])){
            $labels[] = $datenoterepas1[0]['note_date'];
           $data3[] = $datenoterepas1[0]["AVG(note_chaleur)"];
           $data4[] = $datenoterepas1[0]["AVG(note_gout)"];
           $data5[] = $datenoterepas1[0]["AVG(notequantite)"];
           $data6[] = $datenoterepas1[0]["AVG(noteacceuil)"];
           $data7[] = $datenoterepas1[0]["AVG(notediversite)"];
           $data8[] = $datenoterepas1[0]["AVG(notehygiene)"];
       }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Note chaleur',
                    'backgroundColor' => 'rgba(45,255,175, 0.5)',
                    'borderColor' => 'rgb(45,175,255)',
                    'pointBackgroundColor' => 'rgb(45,175,255)',
                    'pointBorderColor' => 'rgb(45,175,255)',
                    'data' => $data3,
                ],
                [
                    'label' => 'Note gout',
                    'backgroundColor' => 'rgba(255,20,255, 0.5)',
                    'borderColor' => 'rgb(255,175,45)',
                    'pointBackgroundColor' => 'rgb(50,175,255)',
                    'pointBorderColor' => 'rgb(50,175,255)',
                    'data' => $data4,
                ],
                [
                    'label' => 'Note Quantité',
                    'backgroundColor' => 'rgba(255,255,45, 0.5)',
                    'borderColor' => 'rgb(255,175,45)',
                    'pointBackgroundColor' => 'rgb(50,175,255)',
                    'pointBorderColor' => 'rgb(50,175,255)',
                    'data' => $data5,
                ],
                [
                    'label' => 'Note Acceuil',
                    'backgroundColor' => 'rgba(255,20,20, 0.5)',
                    'borderColor' => 'rgb(255,175,45)',
                    'pointBackgroundColor' => 'rgb(50,175,255)',
                    'pointBorderColor' => 'rgb(50,175,255)',
                    'data' => $data6,
                ],
                [
                    'label' => 'Note diversité',
                    'backgroundColor' => 'rgba(20,20,255, 0.5)',
                    'borderColor' => 'rgb(255,175,45)',
                    'pointBackgroundColor' => 'rgb(50,175,255)',
                    'pointBorderColor' => 'rgb(50,175,255)',
                    'data' => $data7,
                ],
                [
                    'label' => 'Note hygiène',
                    'backgroundColor' => 'rgba(20,255,20, 0.5)',
                    'borderColor' => 'rgb(255,175,45)',
                    'pointBackgroundColor' => 'rgb(50,175,255)',
                    'pointBorderColor' => 'rgb(50,175,255)',
                    'data' => $data8,
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
    function new (Request $request, QrcodeRepository $qrcodeRepository): Response {
        $token = $qrcodeRepository->getTokenToday();
        $token2 = $_GET['token'];
        if ($token == $token2)
        {
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
        else
        {
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        
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
        // $labels = [];
        // $data = [];
        // $data2 = [];
        // $datenoterepas = $StudentRepository->getDateRepas();
        // for ($i = 0; $i < count($datenoterepas);$i++){
        // $labels[] = $datenoterepas[0]['note_date'];
        // $data[] = $datenoterepas[0]['note_repas'];
        // $data2[] = $datenoterepas[0]['note_valeur_environnement'];
        // }
        ?><?php
        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename="Liste-candidature.csv"');
        
        $data = $StudentRepository->findAll();
        ?>
        "note Repas";"note Environnement";" Commentaire";" Date";
        <?php  
        foreach($data as $d){
            echo '"'.$d->noteRepas.'";"'.$d->noteValeurEnvironnement.'";"'.$d->noteCommentaire.'";"'.$d->noteDate.'";'.";\n";
        }
        ?><?php
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