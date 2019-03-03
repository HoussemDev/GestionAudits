<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 03/03/2019
 * Time: 06:34
 */

namespace App\Controller\Admin;


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

	public function __construct(CertificatRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
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
	 * @Route("/admin/certificate/{slug}.{id}", name="cert.show", requirements={"slug": "[a-z0-9\-]*"})
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
			'current_menu' => 'Certificate'

		]);

	}


	/**
	 * @Route("/admin/certificate/create", name="admin.cert.new")
	 */
	public function new(Request $request)
	{
		$cert = new Certificat();
		$form = $this->createForm(CertificatType::class, $cert);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($cert);
			$this->em->flush();
			$this->addFlash('success','Certificat Created' );

			return $this->redirectToRoute('admin.certlist.index');
		}
		return $this->render('Admin/Certificate/edit.html.twig',  [
			'certs' => $cert,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/admin/certificate/{id}", name="admin.cert.delete", methods="DELETE")
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
	 * @Route("/admin/certificate/{id}", name="admin.cert.edit")
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