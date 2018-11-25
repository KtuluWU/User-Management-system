<?php

namespace App\Controller;

use App\Form\ProductTrackingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ProductTracking;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;




/**
 * @Route("/tracking", name = "Product")
 */
class TrackingController extends AbstractController
{
    /**
     * @Route("/{tracking_id}&{page}", name = "ShowPage")
     */
    public function show($tracking_id, $page)
    {
        $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking= $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $product_id = $product_tracking->getProductId();
        $product_name = $product_tracking_manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id))->getProductName();
        return $this->render('tracking/show.html.twig',['tracking' => $product_tracking,'tracking_product'=> $product_name]);
    }



    /**
     * @Route("/data", name="TrackingPage")
     */
    public function index(Request $request)
    {
        $product_tracking= new ProductTracking();
        $form = $this->createForm(ProductTrackingType::class, $product_tracking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $product_manager = $this->getDoctrine()->getManager();
            $product_tracking_id = $this->product_tracking_id_generator();
            $product_tracking->setTrackingId($product_tracking_id);
            $product_tracking->setProductId($data->getProductId());
            $product_tracking->setProductionDate($data->getProductionDate());
            $product_tracking->setBatchId($data->getBatchId());
            $product_tracking->setStartingTime($data->getStartingTime());
            $product_tracking->setRanchId($data->getRanchId());
            $product_tracking->setMilkCollectionTime($data->getMilkCollectionTime());
            $product_tracking->setRanchResponsible($data->getRanchResponsible());
            $product_tracking->setFactory($data->getFactory());
            $product_tracking->setFactoryProcessingTime($data->getFactoryProcessingTime());
            $product_tracking->setFactoryResponsible($data->getFactoryResponsible());
            $product_tracking->setFactoryDeliveryTime($data->getFactoryDeliveryTime());
            $product_tracking->setFactoryDeliveryResponsible($data->getFactoryDeliveryResponsible());
            $product_tracking->setExportTime($data->getExportTime());
            $product_tracking->setExportResponsible($data->getExportResponsible());
            $product_tracking->setImportTime($data->getImportTime());
            $product_tracking->setImportResponsible($data->getImportResponsible());
            $product_tracking->setCenterArrivalTime($data->getCenterArrivalTime());
            $product_tracking->setArrivalResponsible($data->getArrivalResponsible());
            $product_tracking->setSite1($data->getSite1());
            $product_tracking->setSite1DeliveryTime($data->getSite1DeliveryTime());
            $product_tracking->setSite1Responsible($data->getSite1Responsible());
            $product_tracking->setSite2($data->getSite2());
            $product_tracking->setSite2DeliveryTime($data->getSite2DeliveryTime());
            $product_tracking->setSite2Responsible($data->getSite2Responsible());
            $product_tracking->setSite3($data->getSite3());
            $product_tracking->setSite3DeliveryTime($data->getSite3DeliveryTime());
            $product_tracking->setSite3Responsible($data->getSite3Responsible());
            $product_tracking->setClientId($data->getClientId());
            $product_tracking->setPurchaseTime($data->getPurchaseTime());
            $product_tracking->setSellerId($data->getSellerId());
            $product_manager->persist($product_tracking);
            $product_manager->flush();
            $this->product_tracking_id_setter($product_tracking_id);
            unset($product_tracking);
            unset($form);
            $product_tracking = new ProductTracking();
            $form = $this->createForm(ProductTrackingType::class, $product_tracking);
            $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
            $product_tracking = $repository->findAll();
            return $this->render('tracking/index.html.twig',
                ['tracking' => $product_tracking,
                    'form'=> $form->createView()]);
        }


        $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
        $product_tracking = $repository->findAll();
        return $this->render('tracking/index.html.twig',
            ['tracking' => $product_tracking,
                'form'=> $form->createView()]);
    }

    /**
     * @Route("/delete/{tracking_id}&{page}", name = "ProductEdit")
     */
    public function tracking_delete($tracking_id, $page)
    {   $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking= $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        if ($product_tracking != null){
            $product_tracking_manager->remove($product_tracking);
            $product_tracking_manager->flush();
        }
        return $this->redirectToRoute("ProductTrackingPage");
    }
    /**
     * @Route("/edit/{tracking_id}&{page}")
     */
    public function tracking_edit(Request $request, $tracking_id, $page)
    {
        $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking= $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $form = $this->createForm(ProductTrackingType::class, $product_tracking);
        $form->setData($product_tracking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $product_tracking->setProductId($data->getProductId());
            $product_tracking->setProductionDate($data->getProductionDate());
            $product_tracking->setBatchId($data->getBatchId());
            $product_tracking->setStartingTime($data->getStartingTime());
            $product_tracking->setRanchId($data->getRanchId());
            $product_tracking->setMilkCollectionTime($data->getMilkCollectionTime());
            $product_tracking->setRanchResponsible($data->getRanchResponsible());
            $product_tracking->setFactory($data->getFactory());
            $product_tracking->setFactoryProcessingTime($data->getFactoryProcessingTime());
            $product_tracking->setFactoryResponsible($data->getFactoryResponsible());
            $product_tracking->setFactoryDeliveryTime($data->getFactoryDeliveryTime());
            $product_tracking->setFactoryDeliveryResponsible($data->getFactoryDeliveryResponsible());
            $product_tracking->setExportTime($data->getExportTime());
            $product_tracking->setExportResponsible($data->getExportResponsible());
            $product_tracking->setImportTime($data->getImportTime());
            $product_tracking->setImportResponsible($data->getImportResponsible());
            $product_tracking->setCenterArrivalTime($data->getCenterArrivalTime());
            $product_tracking->setArrivalResponsible($data->getArrivalResponsible());
            $product_tracking->setSite1($data->getSite1());
            $product_tracking->setSite1DeliveryTime($data->getSite1DeliveryTime());
            $product_tracking->setSite1Responsible($data->getSite1Responsible());
            $product_tracking->setSite2($data->getSite2());
            $product_tracking->setSite2DeliveryTime($data->getSite2DeliveryTime());
            $product_tracking->setSite2Responsible($data->getSite2Responsible());
            $product_tracking->setSite3($data->getSite3());
            $product_tracking->setSite3DeliveryTime($data->getSite3DeliveryTime());
            $product_tracking->setSite3Responsible($data->getSite3Responsible());
            $product_tracking->setClientId($data->getClientId());
            $product_tracking->setPurchaseTime($data->getPurchaseTime());
            $product_tracking->setSellerId($data->getSellerId());
            $product_tracking_manager->persist($product_tracking);
            $product_tracking_manager->flush();
            return $this->redirectToRoute('ProductTrackingPage');
        }
        $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
        $product_tracking = $repository->findAll();
        return $this->render('tracking/tracking_edit.html.twig',
            ['tracking' => $product_tracking,
                'form'=> $form->createView()]);


    }


    private function product_tracking_id_generator()
    {
        $col_id_name = 'tracking_id';

        $em_users = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT $col_id_name FROM infos ORDER BY $col_id_name DESC LIMIT 1";

        $id_pre = $em_users->prepare($sql);
        $id_pre->execute();
        $id_last = $id_pre->fetchAll();

        if ( empty($id_last) || ($id_last[0][$col_id_name])=="")
        {
            $tracking_id = '1000000001';
        } else {
            $tracking_id = (int)$id_last[0][$col_id_name] + 1;
        }
        return (string)$tracking_id;
    }
    private function product_tracking_id_setter($tracking_id)
    {
        $em_users = $this->getDoctrine()->getManager()->getConnection();

        $sql_init = "SELECT * FROM infos LIMIT 1";
        $stm_init = $em_users->prepare($sql_init);
        $stm_init->execute();
        $db = $stm_init->fetchAll();

        if (empty($db)) {
            $sql_first = "INSERT INTO infos VALUES (0,'','','',0,0,0,'','','')";
            $stm_first = $em_users->prepare($sql_first);
            $stm_first->execute();
        }
        $col_id_name = 'tracking_id';

        $sql = "UPDATE infos SET $col_id_name = $tracking_id ";
        $stm = $em_users->prepare($sql);
        $stm->execute();
    }
}
