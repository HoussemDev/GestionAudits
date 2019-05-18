<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/02/2019
 * Time: 14:17
 */

namespace App\Controller;


use App\Entity\CB;
use App\Entity\Organisation;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeContoller extends AbstractController
{

	/**
	 * @var Environment
	 */
	private $twig;
	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(Environment $twig, ObjectManager $em)
	{
		$this->twig = $twig;
		$this->em = $em;
	}

	/**
	 * @Route("/", name="home")
	 * @return Response
	 */
	public function index(): Response
	{
		return $this->render('pages/home.html.twig');
	}


	/**
	 * @Route("/test", name="test")
	 * @return Response
	 */
	public function indexAction()
	{


		$NbrOrg = $this->em->getRepository(Organisation::class)->countorg();
		$NbrCb = $this->em->getRepository(CB::class)->countCb();

//		$datas = $this->em->getRepository(Organisation::class)->findOneBy(array('id'=>109));
//		$datas = $datas->getAudits();

//		$dataname= $datas->getName();
//		$datacountry= $datas->getCountry();

		$pieChart = new PieChart();
//
//		$cbName =  array();
//		$orgNumber = array();
//
//
//
//		foreach ($datas as $item) {
//			array_push($cbName, $item['name']);
//			array_push($orgNumber, $item[1]);
//
//		}
//
//		$dataToDisplay=  array( ['CB',    $cbName[1]],  ['Organisation Name',      $orgNumber[1]] );
//
//		dump($dataToDisplay);
//		die();
//
//		$pieChart->getData()->setArrayToDataTable( $dataToDisplay);


//		$pieChart->getData()->setArrayToDataTable(
//			[['Task', 'Hours per Day'],
//				['Test2', ],
//				['Test2', $datas->getName()],
//				['Test2', $datas->getCb()],
//			]
//		);

//		dump($NbrOrg[0][1]);
//		die();
		$pieChart->getData()->setArrayToDataTable(
			[['Task', 'Hours per Day'],

				['Organisation Number', (int) $NbrOrg[0][1]],
				['Certification Body Number', (int) $NbrCb[0][1]],
//				['Test2', 5],
//				['Test2', 5],
			]
		);

//		$pieChart->getOptions()->setTitle('My Daily Activities');
		$pieChart->getOptions()->setHeight(200);
		$pieChart->getOptions()->setWidth(600);
		$pieChart->getOptions()->getTitleTextStyle()->setBold(true);
		$pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
		$pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
		$pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
		$pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

		return $this->render('pages/test.html.twig', array('piechart' => $pieChart));
	}


}