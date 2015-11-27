<?php

namespace WEB\CrowdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WEB\CrowdBundle\Entity\Advert;
use WEB\CrowdBundle\Form\AdvertType;
use WEB\CrowdBundle\Form\AdvertEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
      if ($listAdverts === null) {
        throw $this->createNotFoundException("Il n'y a pas d'annonces");
      }
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
   	 $advert = new Advert();
  	 $form = $this->get('form.factory')->create(new AdvertType(), $advert);

	 if ($form->handleRequest($request)->isValid()) {
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($advert);
	    $em->flush();

	    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	    return $this->redirect($this->generateUrl('web_crowd_view', array('id' => $advert->getId())));
	}
	    return $this->render('WEBCrowdBundle:KickUp:add.html.twig', array(
      'form' => $form->createView(),));
	  }
public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('WEBCrowdBundle:Advert')->find($id);
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    $form = $this->createForm(new AdvertEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('web_crowd_view', array('id' => $advert->getId())));
    }

    return $this->render('WEBCrowdBundle:KickUp:edit.html.twig', array(
      'form'   => $form->createView(),
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
    $form = $this->createFormBuilder()->getForm();
    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
      return $this->redirect($this->generateUrl('web_crowd_homepage'));
    }
   
    return $this->render('WEBCrowdBundle:KickUp:delete.html.twig', array(
      'advert' => $advert
      ,'form'   => $form->createView()
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
