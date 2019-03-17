<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 03/03/2019
 * Time: 06:34
 */

namespace App\Controller\Admin;


use App\Entity\Audit;
use App\Entity\Certificat;
use App\Form\CertificatType;
use App\Repository\CertificatRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCertController extends AbstractController
{

	/**
	 * @var CertificatRepository
	 */
	private $repository;
	/**
	 * @var ObjectManager
	 */
	private $em;
	/**
	 * @var \Twig_Environment
	 */
	private $twig;

	public function __construct(CertificatRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}

	/**
	 * @Route("/admin/certificate", name="admin.certlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$certs = $this->repository->findAll();
		return $this->render('Admin/Certificate/index.html.twig', compact('certs'));
	}

	/**
	 * @Route("/admin/certificate/profile/{slug}.{id}", name="cert.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Certificat $certificat
	 * @return Response
	 */
	public function show(Certificat $certificat, string $slug):Response
	{
		if ($certificat->getSlug() !== $slug)
		{
			return $this->redirectToRoute('cert.show', [
				'id' => $certificat->getId(),
				'slug' => $certificat->getSlug()
			], 301);
		}

		return $this->render('Admin/Certificate/show.html.twig', [
			'certs' => $certificat,
			'audits' => $certificat->getAudit(),
			'current_menu' => 'Certificate'

		]);

	}


	/**
	 * @Route("/admin/certificate/create/{title}", name="admin.cert.new")
	 */
	public function new(Request $request, $title)
	{
		$cert = new Certificat();
		$form = $this->createForm(CertificatType::class, $cert);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$cert->setAudit($this->em->getRepository(Audit::class)->findOneBy(array("Title" => $title)));

			$this->em->persist($cert);
			$this->em->flush();
			$msgAddCert = $this->addFlash('success','Certificat Created' );

			$id = $cert->getId();
			$slug = $cert->getSlug();

			return $this->redirectToRoute('cert.show', array("id" => $id, "slug"=> $slug, "success" => $msgAddCert ));
		}
		return $this->render('Admin/Certificate/edit.html.twig',  [
			'certs' => $cert,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/admin/certificate/delete/{id}", name="admin.cert.delete", methods="DELETE")
	 * @param Certificat $certificat
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Certificat $certificat, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $certificat->getId(), $request->get('_token')))
		{
			$this->em->remove($certificat);
			$this->em->flush();
			$this->addFlash('success','Certificat removed' );

		}


		return $this->redirectToRoute('admin.certlist.index');
	}


	/**
	 * @Route("/admin/certificate/edit/{id}", name="admin.cert.edit")
	 * @param Certificat $certificat
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(Certificat $certificat, Request $request)
	{
		$form =$this->createForm(CertificatType::class, $certificat);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Certificat Edited' );
			return $this->redirectToRoute('admin.certlist.index');
		}

		return $this->render('Admin/Certificate/edit.html.twig',  [
			'certs' => $certificat,
			'form' => $form->createView() ]);
	}







}