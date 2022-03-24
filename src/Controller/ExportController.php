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
        function setDates($request) {//Création de l'array de dates"
            $tempArray = [];
            $dates=[];
            for($i=4;$i>=0;$i--)
            array_push($dates,date("Y-m-d",strtotime("-".$i." day", strtotime("now"))));
            // foreach($request as $ligne) {
            //     array_push($dates, $ligne['Date']);
            // }
            // $i = 1;
            // $dates = array_unique($dates);
            // usort($dates, function($a, $b) {
            //     return strtotime($a) - strtotime($b);
            // });
            // foreach($dates as $val) {
            //     $tempArray[$i] = $val;
            //     $i++;
            // }
            // $tempArray[0] = $tempArray[$i-1];
            // unset($tempArray[$i-1]);
            return $dates;
        }
        function setGraphTemplate(\TCPDF $pdf, $product) { //Création du squelette du graphique.
            $dates=setDates($product); //Les dates, elles seront importées avec les notes.

            $count=-1;
            $count2=0;
            $pdf->Arrow(30, 180, 266, 180, 3, 5, 15); //Date (X), 44 d'intervalle entre chaque barre.
            $pdf->Arrow(30, 180, 30, 40, 3, 5, 15); //Note (Y), 25 d'intervalle entre chaque barre.
            for($y = 155;$y >= 55;$y -=25) {
                $pdf->Line(29, $y, 31, $y);
                $pdf->Line(31, $y, 250, $y,array('color' => array(170)));
            }
            for($x = 60;$x <=250;$x+=44)
            $pdf->Line($x,179,$x,181);
            $pdf->SetFont('courier', '', 8);
            for($i = 176;$i>=0;$i-=44) { //Mise en place de la date
                $count++;
                $pdf->Text(230.5-$i,181,date("d/m", strtotime($dates[$count])),false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
            }
            for($i = 25;$i<150;$i+=25) { //Mise en place des chiffres de 1 à 5
                $count2++;
                $pdf->Text(25,178.25-$i,"$count2",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
            }
            $pdf->AddPage('L');
            $pdf->SetLineStyle(array('color' => array(0)));
            $j=0;
            $etiquettesRep = ['Goût','Quantité','Diversité'];
            $etiquettesEnv = ['Chaleur','Hygiène','Accueil'];
            $pdf->SetFont('helvetica', '', 11);
            for($i=0; $i<3;$i++) {
            //for($i=30;$i<264;$i+=78) {
                $x=35+$i*80;
                $bar=$x+70;
                $pdf->Arrow($x, 96, $x, 40, 3, 5, 15); //On refait des ajustements.
                $pdf->Arrow($x,96,$bar,96,3, 5, 15);
                $pdf->Text($x,96,$etiquettesRep[$i]);
                $pdf->Arrow($x, 180, $x, 119, 3, 5, 15); //On refait des ajustements.
                $pdf->Arrow($x,180,$bar,180,3, 5, 15);
                $pdf->Text($x,180,$etiquettesEnv[$i]);
            }
            $pdf->SetFont('helvetica', 'B', 20);
        }
        function avgNote($request, string $typeNote){ //Renvoie la moyenne de chaque jour en un tableau de 5 notes
            $dates = setDates($request);
            $notesArray = [0,0,0,0,0];
            $notesCount = [];
            for($h=0;$h<=4;$h++) {
                $notesCount[$h] = [];
            }
            foreach($request as $ligne) {
                switch($ligne['Date']) {
                    case $dates[0]:
                        array_push($notesCount[0],$ligne[$typeNote]);
                        
                        break;
                    case $dates[1]:
                        array_push($notesCount[1],$ligne[$typeNote]);
                        
                        break;
                    case $dates[2]:
                        array_push($notesCount[2],$ligne[$typeNote]);
                        
                        break;
                    case $dates[3]:
                        array_push($notesCount[3],$ligne[$typeNote]);
                        
                        break;
                    case $dates[4]:
                        array_push($notesCount[4],$ligne[$typeNote]);
                        
                        break;
                }
            }
            dump($notesCount);
            for($h=0;$h<=4;$h++) {
                $notesArray[$h] = array_sum($notesCount[$h])/count($notesCount[$h]);
            }
            return $notesArray;
        }
        function insertIntoGraph(\TCPDF $pdf, $request) {//Insertion des données dans le graphe
            $dates = setDates($request);
            $count = -1;
            $pdf->setPage(1);
            $noteRep=avgNote($request, 'Repas'); //Moyenne des notes repas de chaque jour
            $noteEnv=avgNote($request, 'Environnement'); //environnement
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
            $pdf->setPage(2);
            $pdf->AddPage('L');
        }
        function coordTranslator(float $note, $graphPlace="center") {//Traduit les notes en coordonnée Y pour le graphique.
            //Le 0 c'est 180, le 100 c'est 40 (140 d'écart)
            return 155-(100*($note-1)*25/100);
        }
        function getData(\TCPDF $pdf, $request, bool $refuse = false) { //ça a commencé en getdata, et ça finit en postdata lmao
            $bidule = 0;
            $incrementer = 0;
            $dates=setDates($request); //Les dates, elles seront importées avec les notes.
            array_push($dates);
            //J'ai besoin d'un moyen de revenir sue cette ligne en despi, alors je vais dire bun.
            if($refuse==false){ //Refuse est ici pour des raisons de test, il sera retiré une fois que le debugging sera fini.
                $pdf->SetFont('helvetica', 'B', 11);
                $pdf->Text(25,50, "Id",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(50,50, "Note Repas",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(80,50, "Note Env.",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(110,50, "Note Chaleur",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(140,50, "Note Gout",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                $pdf->Text(170,50, "Date",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                //$pdf->Text(170,50, "Commentaire",false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                //Note = Je prévois de mettre une boite de 66 W majuscules de long après l'id pour afficher un commentaire.
                $pdf->SetFont('helvetica', '', 11);
                foreach($request as $ligne) {
                    $incrementer++;
                    $bidule+=5;
                    $pdf->Text(25,50+$bidule, $ligne['id'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(50,50+$bidule, $ligne['Repas'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(80,50+$bidule, $ligne['Environnement'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(110,50+$bidule, $ligne['Chaleur'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(140,50+$bidule, $ligne['Gout'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    $pdf->Text(170,50+$bidule, date("d/m", strtotime($ligne['Date'])),false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    //$pdf->Text(170,50+$bidule, $ligne['Commentaire'],false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', $rtloff=true);
                    
                    if($incrementer%25==0) {
                        $pdf->AddPage('L');
                        $incrementer = 0;
                        $bidule = 0;
                    }
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
        $pdf->SetHeaderData('', 0, "Rapports du ".$madate3->format("d/m/Y")." au ".$madate->format("d/m/Y")."", "Feedback Self");

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

        
        setGraphTemplate($pdf, $product);
        // Ajout du contenu du graphique, voyez la fonction pour gérer ça.
        
        insertIntoGraph($pdf, $product);
        getData($pdf, $product, false);
// ---------------------------------------------------------
        ob_end_clean(); //Nécessaire pour que le pdf se fasse bien.
        //Close and output PDF document
        $pdf->Output('export.pdf', 'I');
        
        return $this->redirectToRoute('student_index', [], Response::HTTP_SEE_OTHER);
    }
}
