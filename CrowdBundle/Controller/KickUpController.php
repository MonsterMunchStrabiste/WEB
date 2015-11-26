<?php

namespace WEB\CrowdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WEB\CrowdBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class KickUpController extends Controller
{
	public function indexAction($page)
	  {
	    if ($page < 1) {
	      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
	    }
	    $nbPerPage = 3;
	    $listAdverts = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('WEBCrowdBundle:Advert')
	      ->getAdverts($page, $nbPerPage)
	    ;
	    $nbPages = ceil(count($listAdverts)/$nbPerPage);
	    if ($page > $nbPages) {
	      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
	    }
	    return $this->render('WEBCrowdBundle:KickUp:index.html.twig', array(
	     'listAdverts' => $listAdverts,
	      'nbPages'     => $nbPages,
	      'page'        => $page
	    ));
	  }    
	public function viewAction($id)
	  {
	    $em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('WEBCrowdBundle:Advert')->find($id);
	    if ($advert === null) {
	      throw $this->createNotFoundException("L'annonce d'id ".$id." n'existe pas.");
	    }
	    return $this->render('WEBCrowdBundle:KickUp:view.html.twig', array('advert'=> $advert));
	  }

	public function addAction(Request $request)
	  {
	    /*$advert = new Advert();
	    $advert->setTitle('Symfony2.');
	    $advert->setNom('Villa');
	    $advert->setPrenom('Alexandre');
	    $advert->setContent("Cree votre propre projet");
	    $advert->setObjectif('1000');	
	    $advert->setCollecte('1000');
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($advert);
	    $em->flush();*/
	    if ($request->isMethod('POST')) {
	      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
	      return $this->redirect($this->generateUrl('web_crowd_homepage', array('id' => $advert->getId())));
	    }
	    return $this->render('WEBCrowdBundle:KickUp:contact.html.twig');
	  }
public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('WEBCrowdBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

/*    $form = $this->createForm(new AdvertEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('web_crowd_view', array('id' => $advert->getId())));
    }*/

    return $this->render('WEBCrowdBundle:KickUp:view.html.twig', array(
  //    'form'   => $form->createView(),
      'advert' => $advert // Je passe également l'annonce à la vue si jamais elle veut l'afficher
    ));
  }

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('WEBCrowdBundle:Advert')->find($id);
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
//    $form = $this->createFormBuilder()->getForm();
//    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
      return $this->redirect($this->generateUrl('web_crowd_homepage'));
  //  }
    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('WEBCrowdBundle:KickUp:index.html.twig', array(
      'advert' => $advert
      //,'form'   => $form->createView()
    ));
  }

    public function aboutAction()
    {
        return $this->render('WEBCrowdBundle:KickUp:about.html.twig');
    }
        public function contactAction()
    {
        return $this->render('WEBCrowdBundle:KickUp:contact.html.twig');
    }
     public function menuAction($limit = 3)
  {
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('WEBCrowdBundle:Advert')
      ->findBy(
        array(),                 // Pas de critère
        array('date' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
    );

    return $this->render('WEBCrowdBundle:KickUp:index.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }
}
