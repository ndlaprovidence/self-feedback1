<?php

namespace App\Controller;

use PDO;
use DateTime;
use DateInterval;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class ExportController extends AbstractController
{
    /**
     * @Route("/export", name="export")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $repository = $this->getDoctrine()->getRepository(Student::class);
    $product = $repository->findNotesFromWeek(); //Format Y/m/d '2022-02-28'
        //Mise en place de fonctions locales...
        function setGraphTemplate(\TCPDF $pdf) { //Création du squelette du graphique.
            $dates=["12/01","12/02","12/03","12/04","12/05"]; //Les dates, elles seront importées avec les notes.

            $count=-1;
            $count2=0;
            $pdf->Arrow(30, 180, 266, 180, 3, 5, 15); //Date (X), 44 d'intervalle entre chaque barre.
            $pdf->Arrow(30, 180, 30, 40, 3, 5, 15); //Note (Y), 25 d'intervalle entre chaque barre.
            for($y = 155;$y >= 55;$y -=25)
            $pdf->Line(29, $y, 31, $y);
            for($x = 60;$x <=250;$x+=44)
            $pdf->Line($x,179,$x,181);
            $pdf->SetFont('courier', '', 8);
            for($i = 176;$i>=0;$i-=44) { //Mise en place de la date (Devra être préparé dynamiquement)
                $count++;
                $pdf->Text(230.5-$i,181,"$dates[$count]",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
            }
            for($i = 25;$i<150;$i+=25) { //Mise en place des chiffres de 1 à 5
                $count2++;
                $pdf->Text(25,178.25-$i,"$count2",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
            }
            $pdf->SetFont('helvetica', 'B', 20);
        }
        function insertIntoGraph(\TCPDF $pdf) {//Insertion des données dans le graphe
            $count = -1;
            $noteRep=[3.3,4.2,1.3,3.4,4.7]; //Moyenne des notes repas de chaque jour
            $noteEnv=[1.2,2.3,4.1,4.8,2]; //environnement
            $coordRep = []; //Coordnnées de chaque note repas
            $coordEnv = []; //...Et celles de l'environnement.
            $styleRep = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)); //Style Barre repas
            $styleEnv = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 255, 190)); //Style Barre environnement
            for($x = 60;$x<212;$x+=44) {
                $count++;
                $y = coordTranslator($noteRep[$count]); //Appelle le traducteur.
                $y2 = coordTranslator($noteEnv[$count]);
                array_push($coordRep,$x, $y); //Pousse la note dans l'array de coordonnées..
                array_push($coordEnv,$x, $y2);
            }
            array_push($coordRep,$x, coordTranslator($noteRep[$count+1])); //Poussées finales, nécessaire pour pas que tout bugue.
            array_push($coordEnv,$x, coordTranslator($noteEnv[$count+1]));
            $pdf->SetLineStyle($styleRep); //
            $pdf->PolyLine($coordRep); //Et voilà le beau bébé ! :D
            $pdf->SetLineStyle($styleEnv);
            $pdf->PolyLine($coordEnv);
        }
        function coordTranslator(float $note) {//Traduit les notes en coordonnée Y pour le graphique.
            return 155-(100*($note-1)*25/100);
        }
        function getData(\TCPDF $pdf, $request, bool $refuse = false) { //ça a commencé en getdata, et ça finit en postdata lmao
            $bidule = 0;
            
            //J'ai besoin d'un moyen de revenir sue cette ligne en despi, alors je vais dire bun.
            if($refuse==false){ //Refuse est ici pour des raisons de test, il sera retiré une fois que le debugging sera fini.
                $pdf->SetFont('helvetica', 'B', 11);
                $pdf->Text(50,50, "Note Repas",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(100,50, "Note Env.",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(150,50, "Commentaire",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(25,50, "ID",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->SetFont('helvetica', '', 11);
                foreach($request as $ligne) {
                    $bidule+=5;
                    $pdf->Text(50,50+$bidule, $ligne['Repas'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(100,50+$bidule, $ligne['Environnement'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(150,50+$bidule, $ligne['Commentaire'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(25,50+$bidule, $ligne['id'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                }
                
            }
        }

        // Génération du PDF
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        

        // Mise en place des informations du PDF
        $pdf->SetCreator('Feedback Self');
        $pdf->SetTitle('Feedback Self');
        $pdf->SetSubject('Note de la semaine');

        $madate3 = new DateTime(date("Y-m-d"));
        $madate3->sub(new DateInterval('P4D'));
        $madate = new DateTime(date("Y-m-d"));
        // Mise en place du header (Logo, Taille logo, Titre, Sous-titre, Couleur de texte, couleur de ligne)
        $pdf->SetHeaderData('', 0, "Rapports du ".$madate->format("d/m/Y")." au ".$madate3->format("d/m/Y")."", "Feedback Self");

        // Mise en place des polices
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Mise en place de la police monospace par défaut.
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Mise en place des marges
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Mise en place de l'auto-page-break
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // Ratio d'image.
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

        // Mise en place de la grosse police
        $pdf->SetFont('helvetica', 'B', 20);

        // Ajout d'une page paysage (P pour le portrait)
        $pdf->AddPage('L');
        //2criture du titre, je sais pas quoi mettre, les autres verront.
        $pdf->Write(0, 'Indice de satisfaction globale');
        // Création du squelette du graphique
        getData($pdf, $product, false);
        /// setGraphTemplate($pdf);
        // Ajout du contenu du graphique, voyez la fonction pour gérer ça.
        /// insertIntoGraph($pdf);

// ---------------------------------------------------------
        ob_end_clean(); //Nécessaire pour que le pdf se fasse bien.
        //Close and output PDF document
        $pdf->Output('export.pdf', 'I');
        //dump($product);
        return $this->render('export/index.html.twig', [
            'controller_name' => 'ExportController',
        ]);
    }
}