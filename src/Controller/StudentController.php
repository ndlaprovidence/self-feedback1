<?php

namespace App\Controller;

use DateTime;
use App\Entity\Student;
use App\Form\StudentType;
use App\Entity\ChartChoice;
use App\Form\ChartChoiceType;
use function PHPSTORM_META\type;
use Doctrine\DBAL\Types\TextType;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\QrcodeRepository;
use App\Repository\StudentRepository;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{

    /**
     * @Route("/", name="student_index", methods={"GET"})
     * 
     */
    public function index(Request $request, StudentRepository $studentRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $typeChartChoice = $request->get('type');
        if (!isset($typeChartChoice)) {
            $typeChartChoice = "bar";
        }

        $student = $studentRepository->findAll();

        $labels = [];
        $data3 = [];
        $data4 = [];
        $data5 = [];
        $data6 = [];
        $data7 = [];
        $data8 = [];
        $datenoterepas1 = $studentRepository->getDateRepas1();
        $datenoterepas2 = $studentRepository->getDateRepas2();
        $datenoterepas3 = $studentRepository->getDateRepas3();
        $datenoterepas4 = $studentRepository->getDateRepas4();
        $datenoterepas5 = $studentRepository->getDateRepas5();

        if (isset($datenoterepas5[0]['note_date'])) {
            $labels[] = $datenoterepas5[0]['note_date'];
            $data3[] = $datenoterepas5[0]["AVG(note_chaleur)"];
            $data4[] = $datenoterepas5[0]["AVG(note_gout)"];
            $data5[] = $datenoterepas5[0]["AVG(notequantite)"];
            $data6[] = $datenoterepas5[0]["AVG(noteacceuil)"];
            $data7[] = $datenoterepas5[0]["AVG(notediversite)"];
            $data8[] = $datenoterepas5[0]["AVG(notehygiene)"];
        }
        if (isset($datenoterepas4[0]['note_date'])) {
            $labels[] = $datenoterepas4[0]['note_date'];
            $data3[] = $datenoterepas4[0]["AVG(note_chaleur)"];
            $data4[] = $datenoterepas4[0]["AVG(note_gout)"];
            $data5[] = $datenoterepas4[0]["AVG(notequantite)"];
            $data6[] = $datenoterepas4[0]["AVG(noteacceuil)"];
            $data7[] = $datenoterepas4[0]["AVG(notediversite)"];
            $data8[] = $datenoterepas4[0]["AVG(notehygiene)"];
        }
        if (isset($datenoterepas3[0]['note_date'])) {
            $labels[] = $datenoterepas3[0]['note_date'];
            $data3[] = $datenoterepas3[0]["AVG(note_chaleur)"];
            $data4[] = $datenoterepas3[0]["AVG(note_gout)"];
            $data5[] = $datenoterepas3[0]["AVG(notequantite)"];
            $data6[] = $datenoterepas3[0]["AVG(noteacceuil)"];
            $data7[] = $datenoterepas3[0]["AVG(notediversite)"];
            $data8[] = $datenoterepas3[0]["AVG(notehygiene)"];
        }
        if (isset($datenoterepas2[0]['note_date'])) {
            $labels[] = $datenoterepas2[0]['note_date'];
            $data3[] = $datenoterepas2[0]["AVG(note_chaleur)"];
            $data4[] = $datenoterepas2[0]["AVG(note_gout)"];
            $data5[] = $datenoterepas2[0]["AVG(notequantite)"];
            $data6[] = $datenoterepas2[0]["AVG(noteacceuil)"];
            $data7[] = $datenoterepas2[0]["AVG(notediversite)"];
            $data8[] = $datenoterepas2[0]["AVG(notehygiene)"];
        }
        if (isset($datenoterepas1[0]['note_date'])) {
            $labels[] = $datenoterepas1[0]['note_date'];
            $data3[] = $datenoterepas1[0]["AVG(note_chaleur)"];
            $data4[] = $datenoterepas1[0]["AVG(note_gout)"];
            $data5[] = $datenoterepas1[0]["AVG(notequantite)"];
            $data6[] = $datenoterepas1[0]["AVG(noteacceuil)"];
            $data7[] = $datenoterepas1[0]["AVG(notediversite)"];
            $data8[] = $datenoterepas1[0]["AVG(notehygiene)"];
        }

        $chart = $chartBuilder->createChart($typeChartChoice);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Note chaleur',
                    'backgroundColor' => 'rgba(242,129,35, 0.5)',
                    'borderColor' => 'rgb(242,129,35)',
                    'pointBackgroundColor' => 'rgb(242,129,35)',
                    'pointBorderColor' => 'rgb(242,129,35)',
                    'data' => $data3,
                ],
                [
                    'label' => 'Note gout',
                    'backgroundColor' => 'rgba(45,170,225, 0.5)',
                    'borderColor' => 'rgb(45,170,225)',
                    'pointBackgroundColor' => 'rgb(45,170,225)',
                    'pointBorderColor' => 'rgb(45,170,225)',
                    'data' => $data4,
                ],
                [
                    'label' => 'Note Quantité',
                    'backgroundColor' => 'rgba(202,46,85, 0.5)',
                    'borderColor' => 'rgb(202,46,85)',
                    'pointBackgroundColor' => 'rgb(202,46,85)',
                    'pointBorderColor' => 'rgb(202,46,85)',
                    'data' => $data5,
                ],
                [
                    'label' => 'Note Acceuil',
                    'backgroundColor' => 'rgba(169,240,209, 0.5)',
                    'borderColor' => 'rgb(169,240,209)',
                    'pointBackgroundColor' => 'rgb(169,240,209)',
                    'pointBorderColor' => 'rgb(169,240,209)',
                    'data' => $data6,
                ],
                [
                    'label' => 'Note diversité',
                    'backgroundColor' => 'rgba(153,194,77, 0.5)',
                    'borderColor' => 'rgb(153,194,77)',
                    'pointBackgroundColor' => 'rgb(153,194,77)',
                    'pointBorderColor' => 'rgb(153,194,77)',
                    'data' => $data7,
                ],
                [
                    'label' => 'Note hygiène',
                    'backgroundColor' => 'rgba(29,78,137, 0.5)',
                    'borderColor' => 'rgb(29,78,137)',
                    'pointBackgroundColor' => 'rgb(29,78,137)',
                    'pointBorderColor' => 'rgb(29,78,137)',
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
            'students' => $studentRepository->findAll(),
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/chart_choice", name="student_chart_choice", methods={"GET","POST"})
     */
    function choiceChartType(Request $request): Response
    {
        $chartType = new ChartChoice();

        $form = $this->createForm(ChartChoiceType::class, $chartType);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $chartChoice = $_POST["chart_choice"];
            return $this->redirect("/student/?type=" . $chartChoice['type']);
        } else {
            return $this->render('student/selectChartType.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/new", name="student_new", methods={"GET","POST"})
     */
    function new(Request $request, QrcodeRepository $qrcodeRepository): Response
    {
        $token = $qrcodeRepository->getTokenToday();
        $token2 = $_GET['token'];
        if ($token == $token2) {

            $student = new Student();
            $student->setNoteDate(new DateTime());
            $form = $this->createForm(StudentType::class, $student);
            $form->handleRequest($request);

            dump($request);
            if ($form->isSubmitted()) {
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
        } else {
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
     *  @Route("/csvweek", name="student_csvweek")
     */
    function exportToCsv()
    {
        dump(1);
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        dump(2);
        $response = new StreamedResponse();
        dump(3);

        $response->setCallback(function () use ($students) {
            $handle = fopen('php://output', 'r+');
            fputcsv($handle, array('id', 'note_date', 'note_gout', 'note_quantite', 'note_acceuil', 'note_diversite', 'note_hygiene', 'note_total'));
            foreach ($students as $student) {
                fputcsv($handle, array($student->getId(), $student->getNoteDate(), $student->getNoteGout(), $student->getNoteQuantite(), $student->getNoteAcceuil(), $student->getNoteDiversite(), $student->getNoteHygiene(), $student->getNoteTotal()));
            }
            fclose($handle);
        });
        dump(4);

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="notes.csv"');
        dump(5);
        $this->render('student/student_csvweek.html.twig');
        return $response;
    }

    /**
     *  @Route("/csvweek2", name="student_csvweek2")
     */
    function exportToCsv2(StudentRepository $studentRepository)
    {
        dump(1);
        $students = $studentRepository->findAll();
        dump(2);

        $data = "id;note_date;note_gout;note_quantite;note_acceuil;note_diversite;note_hygiene" . PHP_EOL;
        foreach ($students as $student) {
            $data = $data . $student->getId() . ";" . $student->getNoteDate()->format('d/m/y') . ";" . $student->getNoteGout() . ";" . $student->getNoteQuantite() . ";" . $student->getNoteAcceuil() . ";" . $student->getNoteDiversite() . ";" . $student->getNoteHygiene() . PHP_EOL;
        }
        dump($data);

        return new Response($data, 
            Response::HTTP_OK,
            ['content-type' => 'text/csv', 
        ]);
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
