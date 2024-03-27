<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\Boite;
use App\Entity\Papier;
use App\Entity\Entretien;
use App\Entity\Vidange;
use App\Entity\Tarif;
use App\Entity\Client;
use App\Entity\HuileVoiture;
use App\Entity\Location;
use App\Entity\PropertySearch;
use App\Service\QuoteService;
use App\Form\VoitureType;
use App\Form\ClientType;
use App\Form\PapierType;
use App\Form\MarqueType;
use App\Form\BoiteType;
use App\Form\HuileVoitureType;
use App\Form\VidangeType;
use App\Form\EntretienType;
use App\Form\TarifType;
use App\Form\LocationType;
use App\Form\PropertySearchType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends AbstractController
{



//*********************************************************************************************


    #[Route('/listeVoiture', name: 'listeVoiture')]
public function listeVoiture(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(['Matricule' => $nom]);
        }
    }

    return $this->render('Voiture/index.html.twig', ['form' => $form->createView(), 'voitures' => $voitures]);
}

/**
 * @Route("/voiture/new", name="new_voiture", methods={"GET", "POST"})
 */
public function newV(Request $request)
{
    $voiture = new Voiture();
    $form = $this->createForm(VoitureType::class, $voiture);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $matricule = $voiture->getMatricule(); 

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($voiture);
        $entityManager->flush();

        // Use the __toString method on the Marque entity
        $this->addFlash('notice', 'New Vehicle "' . $matricule . '" created successfully.');

        return $this->redirectToRoute('listeVoiture');
    }

    return $this->render('Voiture/ajout.html.twig', ['form' => $form->createView()]);
}

     /**
 * @Route("/voiture/delete/{id}",name="delete_voiture")
 */
public function deleteVoi(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $voiture = $entityManager->getRepository(Voiture::class)->find($id);
    if (!$voiture) {
        throw $this->createNotFoundException(
            'Pas de voiture avec l\'ID ' . $id
        );
    }
    $matricule = $voiture->getMatricule();

    $entityManager->remove($voiture);
    $entityManager->flush();

    $this->addFlash('notice', 'A Vehicle "' . $matricule . '" has been deleted successfully.');
    return $this->redirectToRoute('listeVoiture');
}

/**
 * @Route("/voiture/edit/{id}", name="edit_voiture")
 * Method({"GET", "POST"})
 */
public function editVoi(Request $request, $id) {
    $entityManager = $this->getDoctrine()->getManager();
    $voiture = $entityManager->getRepository(Voiture::class)->find($id);
  
    if (!$voiture) {
        throw $this->createNotFoundException(
            'Pas de voiture avec l\'ID ' . $id
        );
    }
  
    $form = $this->createFormBuilder($voiture)
    ->add('Matricule')
    ->add('nbrePlace')
    ->add('couleur')
    ->add('etat', ChoiceType::class, [
        'choices' => [
        'available' => '✅',
        'non-available' => '❌️', ],])
    ->add('category', ChoiceType::class, [
            'choices' => [
                'Luxury' => 'luxury',
                'Intermediate' => 'intermediate',
                'Economic' => 'economic',
            ],
            'label' => 'Category',
            'attr' => ['class' => 'form-control'],
        ])
    ->add('marque', EntityType::class, [
            'class' => Marque::class,
            'choice_label' => 'libellemarque', // Adjust this to the property you want to display
            'label' => 'Brand',
            'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
        ])
    ->add('boite', EntityType::class, [
            'class' => Boite::class,
            'choice_label' => 'typeboite', // Adjust this to the property you want to display
            'label' => 'GearBox',
            'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
        ])
    ->add('save', SubmitType::class, array(
            'label' => 'Modifier',
            'attr' => ['class' => 'btn btn-success']
        ))
        ->getForm();
  
    $form->handleRequest($request);
  
    if ($form->isSubmitted() && $form->isValid()) {
        $matricule = $voiture->getMatricule();
        $entityManager->flush();
  
        $this->addFlash('notice', 'A Vehicle "' . $matricule . '" has been modified successfully.');
  
        return $this->redirectToRoute('listeVoiture');
    }
  
    return $this->render('Voiture/editV.html.twig', ['form' => $form->createView()]);
  }

/**
     * @Route("/voiture/{id}", name="voiture_show")
     */
    public function showVo($id) {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
  
        return $this->render('Voiture/showV.html.twig', array('voiture' => $voiture));
      }

//*********************************************************************************************


#[Route('/listeMarque', name: 'listeMarque')]
public function listeMarque(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $marques = $this->getDoctrine()->getRepository(Marque::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            // If a name is provided, display regimes with that name
            $marques = $this->getDoctrine()->getRepository(Marque::class)->findBy(['libellemarque' => $nom]);
        }
    }

    return $this->render('Marque/indexM.html.twig', ['form' => $form->createView(), 'marques' => $marques]);
}


/**
 * @Route("/marque/new", name="new_marque")
 * Method({"GET", "POST"})
 */
public function newM(Request $request)
{
    $marque = new Marque();
    $form = $this->createForm(MarqueType::class, $marque);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $nomMarque = $marque->getLibelleMarque(); 


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($marque);
        $entityManager->flush();

        
        $this->addFlash('notice', 'New Marque "' . $nomMarque . '" created successfully.');

        return $this->redirectToRoute('listeMarque');
    }

    return $this->render('Marque/ajoutM.html.twig', ['form' => $form->createView()]);
}

 

//********************************************************************************************* 

#[Route('/listeBoite', name: 'listeBoite')]
public function listeBoite()
{
    // Fetch all boites
    $boites = $this->getDoctrine()->getRepository(Boite::class)->findAll();

    return $this->render('Boite/indexB.html.twig', ['boites' => $boites]);
}



//*********************************************************************************************

#[Route('/listePapier', name: 'listePapier')]
public function listePapier(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $papiers = $this->getDoctrine()->getRepository(Papier::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $Matricule = $propertySearch->getNom();
        if ($Matricule != "") {
            $papiers = $this->getDoctrine()->getRepository(Papier::class)->createQueryBuilder('e')
            ->join('e.voiture', 'v') // Assuming your association is named 'voiture'
            ->where('v.Matricule LIKE :Matricule')
            ->setParameter('Matricule', '%' . $Matricule . '%')
            ->getQuery()
            ->getResult();
        }
    }

    return $this->render('Papier/indexP.html.twig', ['form' => $form->createView(), 'papiers' => $papiers]);
}


/**
     * @Route("/papier/new", name="papier_new")
     */
    public function newP(Request $request): Response
    {
        $papier = new Papier();
        $form = $this->createForm(PapierType::class, $papier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission, e.g., persisting the entity to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($papier);
            $entityManager->flush();

            $this->addFlash('success', 'Papier created successfully.');

            // Redirect to the page you want after successful form submission
            return $this->redirectToRoute('listePapier');
        }

        return $this->render('Papier/ajoutP.html.twig', [
            'form' => $form->createView(),
        ]);
    }


       /**
 * @Route("/Papier/delete/{id}",name="delete_papier")
 */
public function deleteP(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $papier = $entityManager->getRepository(Papier::class)->find($id);
    if (!$papier) {
        throw $this->createNotFoundException(
            'Pas de papier avec l\'ID ' . $id
        );
    }

    $entityManager->remove($papier);
    $entityManager->flush();

    $this->addFlash('notice', 'A paper has been deleted successfully.');

    return $this->redirectToRoute('listePapier');
}

//*********************************************************************************************

#[Route('/listeEntretien', name: 'listeEntretien')]
public function listeEntretien(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $entretiens = $this->getDoctrine()->getRepository(Entretien::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $Matricule = $propertySearch->getNom();
        if ($Matricule != "") {
            $entretiens = $this->getDoctrine()->getRepository(Entretien::class)->createQueryBuilder('e')
            ->join('e.voiture', 'v') // Assuming your association is named 'voiture'
            ->where('v.Matricule LIKE :Matricule')
            ->setParameter('Matricule', '%' . $Matricule . '%')
            ->getQuery()
            ->getResult();
        }
    }

    return $this->render('Entretien/indexE.html.twig', ['form' => $form->createView(), 'entretiens' => $entretiens]);
}


/**
 * @Route("/entretien/new", name="new_entretien", methods={"GET", "POST"})
 */
public function newE(Request $request)
{
    $entretien = new Entretien();
    $form = $this->createForm(EntretienType::class, $entretien);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entretien);
        $entityManager->flush();



        $this->addFlash('notice', 'New maintenance created successfully.');

        return $this->redirectToRoute('listeEntretien');
    }

    return $this->render('Entretien/ajoutE.html.twig', ['form' => $form->createView()]);
}

/**
     * @Route("/entretien/{id}", name="entretien_show")
     */
    public function showE($id) {
        $entretien = $this->getDoctrine()->getRepository(Entretien::class)->find($id);
  
        return $this->render('Entretien/showE.html.twig', array('entretien' => $entretien));
      }



//*********************************************************************************************

#[Route('/listeVidange', name: 'listeVidange')]
public function listeVidange(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $vidanges = $this->getDoctrine()->getRepository(Vidange::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            $vidanges = $this->getDoctrine()->getRepository(Vidange::class)->findBy(['voiture' => $nom]);
        }
    }

    return $this->render('Vidange/indexV.html.twig', ['form' => $form->createView(), 'vidanges' => $vidanges]);
}

/**
 * @Route("/vidange/new", name="new_vidange", methods={"GET", "POST"})
 */
public function newVi(Request $request)
{
    $vidange = new Vidange();
    $form = $this->createForm(VidangeType::class, $vidange);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vidange);
        $entityManager->flush();



        $this->addFlash('notice', 'New vidange created successfully.');

        return $this->redirectToRoute('listeVidange');
    }

    return $this->render('Vidange/ajoutV.html.twig', ['form' => $form->createView()]);
}

       /**
 * @Route("/vidange/delete/{id}",name="delete_vidange")
 */
public function deleteVid(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $vidange = $entityManager->getRepository(Vidange::class)->find($id);
    if (!$vidange) {
        throw $this->createNotFoundException(
            'Pas de vidange avec l\'ID ' . $id
        );
    }

    $entityManager->remove($vidange);
    $entityManager->flush();

    $this->addFlash('notice', 'An oil change has been deleted successfully.');

    return $this->redirectToRoute('listeVidange');
}


//*********************************************************************************************

#[Route('/listeHuileV', name: 'listeHuileV')]
public function listeHuileV(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);
    $huilevoitures = $this->getDoctrine()->getRepository(HuileVoiture::class)->findAll();

    

    return $this->render('HuileVoiture/indexH.html.twig', ['form' => $form->createView(), 'huilevoitures' => $huilevoitures]);
}

/**
 * @Route("/huileV/new", name="new_Huile", methods={"GET", "POST"})
 */
public function newH(Request $request)
{
    $huilevoiture = new HuileVoiture();
    $form = $this->createForm(HuileVoitureType::class, $huilevoiture);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($huilevoiture);
        $entityManager->flush();



        $this->addFlash('notice', 'New oil created successfully.');

        return $this->redirectToRoute('listeHuileV');
    }

    return $this->render('HuileVoiture/ajoutH.html.twig', ['form' => $form->createView()]);
}


/**
 * @Route("/huileV/edit/{id}", name="edit_huileV")
 * Method({"GET", "POST"})
 */
public function editV(Request $request, $id) {
    $entityManager = $this->getDoctrine()->getManager();
    $huileV = $entityManager->getRepository(HuileVoiture::class)->find($id);
  
    if (!$huileV) {
        throw $this->createNotFoundException(
            'Pas de huile avec l\'ID ' . $id
        );
    }
  
    $form = $this->createFormBuilder($huileV)
    ->add('MarqueHuile')
    ->add('numHuile')
    ->add('etat', ChoiceType::class, [
        'choices' => [
        'available' => '✅',
        'non-available' => '❌️', ],])

    ->add('save', SubmitType::class, array(
            'label' => 'Modifier',
            'attr' => ['class' => 'btn btn-success']
        ))
        ->getForm();
  
    $form->handleRequest($request);
  
    if ($form->isSubmitted() && $form->isValid()) {
  
        $entityManager->flush();
  
        $this->addFlash('notice', 'An oil modified successfully.');
  
        return $this->redirectToRoute('listeHuileV');
    }
  
    return $this->render('HuileVoiture/editH.html.twig', ['form' => $form->createView()]);
  }


    /**
 * @Route("/huileV/delete/{id}",name="delete_huileV")
 */
public function deleteV(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $huileV = $entityManager->getRepository(HuileVoiture::class)->find($id);
    if (!$huileV) {
        throw $this->createNotFoundException(
            'Pas de huile avec l\'ID ' . $id
        );
    }

    $entityManager->remove($huileV);
    $entityManager->flush();

    $this->addFlash('notice', 'An oil deleted successfully.');

    return $this->redirectToRoute('listeHuileV');
}


//*********************************************************************************************

#[Route('/listeTarif', name: 'listeTarif')]
public function listeTarif(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    $categories = ['luxury', 'intermediate', 'economic'];
    $pricesByCategory = [];

    foreach ($categories as $category) {
        $pricesByCategory[$category] = $this->getDoctrine()->getRepository(Tarif::class)->findByCategory($category);
    }

    // Fetch all tarifs by default
    $tarifs = $this->getDoctrine()->getRepository(Tarif::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $categoriee = $propertySearch->getNom();
        if ($categoriee != "" && in_array($categoriee, $categories)) {
            $tarifs = $this->getDoctrine()->getRepository(Tarif::class)->findBy(['category' => $categoriee]);
        }
    }

    return $this->render('Tarif/indexT.html.twig', [
        'form' => $form->createView(),
        'tarifs' => $tarifs,
        'pricesByCategory' => $pricesByCategory,
    ]);
}



/**
 * @Route("/tarif/new", name="new_Tarif", methods={"GET", "POST"})
 */
public function newT(Request $request)
{
    $tarif = new Tarif();
    $form = $this->createForm(TarifType::class, $tarif);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tarif);
        $entityManager->flush();



        $this->addFlash('notice', 'New Price created successfully.');

        return $this->redirectToRoute('listeTarif');
    }

    return $this->render('Tarif/ajoutT.html.twig', ['form' => $form->createView()]);
}



//*********************************************************************************************

#[Route('/listeLocation', name: 'listeLocation')]
public function listeLocation(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $Matricule = $propertySearch->getNom();
        if ($Matricule != "") {
            $locations = $this->getDoctrine()->getRepository(Location::class)->createQueryBuilder('e')
            ->join('e.voiture', 'v') // Assuming your association is named 'voiture'
            ->where('v.Matricule LIKE :Matricule')
            ->setParameter('Matricule', '%' . $Matricule . '%')
            ->getQuery()
            ->getResult();
        }
    }

    return $this->render('Location/indexL.html.twig', ['form' => $form->createView(), 'locations' => $locations]);
}

/**
 * @Route("/location/new", name="new_location", methods={"GET", "POST"})
 */
public function newL(Request $request)
{
    $location = new Location();
    $form = $this->createForm(LocationType::class, $location);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($location);
        $entityManager->flush();



        $this->addFlash('notice', 'New rental created successfully.');

        return $this->redirectToRoute('listeLocation');
    }

    return $this->render('Location/ajoutL.html.twig', ['form' => $form->createView()]);
}

   /**
 * @Route("/location/delete/{id}",name="delete_location")
 */
public function deleteL(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $location = $entityManager->getRepository(Location::class)->find($id);
    if (!$location) {
        throw $this->createNotFoundException(
            'Pas de rental avec l\'ID ' . $id
        );
    }

    $entityManager->remove($location);
    $entityManager->flush();

    $this->addFlash('notice', 'A rental has been deleted successfully.');

    return $this->redirectToRoute('listeHuileV');
}

//*********************************************************************************************

#[Route('/listeClient', name: 'listeClient')]
public function listeClient(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            $clients = $this->getDoctrine()->getRepository(Client::class)->findBy(['nom' => $nom]);
        }
    }

    return $this->render('Client/indexC.html.twig', ['form' => $form->createView(), 'clients' => $clients]);
}

/**
 * @Route("/client/new", name="new_client", methods={"GET", "POST"})
 */
public function newC(Request $request)
{
    $client = new Client();
    $form = $this->createForm(ClientType::class, $client);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();



        $this->addFlash('notice', 'New Client created successfully.');

        return $this->redirectToRoute('listeClient');
    }

    return $this->render('Client/ajoutC.html.twig', ['form' => $form->createView()]);
}

/**
 * @Route("/client/edit/{id}", name="edit_client")
 * Method({"GET", "POST"})
 */
public function editC(Request $request, $id) {
    $entityManager = $this->getDoctrine()->getManager();
    $client = $entityManager->getRepository(Client::class)->find($id);
  
    if (!$client) {
        throw $this->createNotFoundException(
            'Pas de client avec l\'ID ' . $id
        );
    }
  
    $form = $this->createFormBuilder($client)
    ->add('nom')
    ->add('prenom')
    ->add('email')
    ->add('Numtel')
    ->add('adresse')
    ->add('save', SubmitType::class, array(
            'label' => 'Modifier',
            'attr' => ['class' => 'btn btn-success']
        ))
        ->getForm();
  
    $form->handleRequest($request);
  
    if ($form->isSubmitted() && $form->isValid()) {
        $nomClient = $client->getNom();
        $nomClient2 = $client->getPrenom();
  
        $entityManager->flush();
  
        $this->addFlash('notice', 'The client ' . $nomClient . ' modified successfully.');
  
        return $this->redirectToRoute('listeClient');
    }
  
    return $this->render('Client/editC.html.twig', ['form' => $form->createView()]);
  }

    /**
 * @Route("/client/delete/{id}",name="delete_client")
 */
public function deleteC(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $client = $entityManager->getRepository(Client::class)->find($id);
    if (!$client) {
        throw $this->createNotFoundException(
            'Pas de client avec l\'ID ' . $id
        );
    }


    $nomClient = $client->getNom();
    $nomClient2 = $client->getPrenom();

    $entityManager->remove($client);
    $entityManager->flush();

    $this->addFlash('notice', 'The client ' . $nomClient . $nomClient2. ' deleted successfully.');

    return $this->redirectToRoute('listeClient');
}

}
