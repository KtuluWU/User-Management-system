<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProductTrackingType;
use phpDocumentor\Reflection\Types\String_;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ProductTracking;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TrackingImage;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Form\ImagePathType;
use Twig\Error\RuntimeError;

/**
 * @Route("/tracking", name = "Product")
 */
class TrackingController extends AbstractController
{
    /**
     * @Route("/{tracking_id}&{page}", name = "ShowPage")
     */
    public function show(Request $request,$tracking_id, $page)
    {
        $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking = $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $tracking_images = $product_tracking_manager->getRepository(TrackingImage::class)->findOneBy(array('tracking_id'=> $tracking_id));
        $product_id = $product_tracking->getProductId();
        $product = $product_tracking_manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id))->getProductName();
        $form = $this->createForm(ImagePathType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tracking_images->setStartMessage($form->get("StartMessage")->getdata());
            $tracking_images->setStartImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setRanchMessage($form->get("StartImagePath")->getData());
            $tracking_images->setRanchImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setFactoryMessage($form->get("StartImagePath")->getData());
            $tracking_images->setFactoryImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setFactoryDeliveryMessage($form->get("StartImagePath")->getData());
            $tracking_images->setFactoryDeliveryImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setExportMessage($form->get("StartImagePath")->getData());
            $tracking_images->setExportImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setImportMessage($form->get("StartImagePath")->getData());
            $tracking_images->setImportImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setCenterMessage($form->get("StartImagePath")->getData());
            $tracking_images->setCenterImagePath($form->get("StartImagePath")->getData());
            $tracking_images->setSite1Message($form->get("StartImagePath")->getData());
            $tracking_images->setSite1ImagePath($data->getSite1ImagePath());
            $tracking_images->setSite2Message($data->getSite2Message());
            $tracking_images->setSite2ImagePath($data->getSite2ImagePath());
            $tracking_images->setSite3Message($data->getSite3Message());
            $tracking_images->setSite3ImagePath($data->getSite3ImagePath());
            $tracking_images->setClientMessage($data->getClientMessage());
            $tracking_images->setClientImagePath($data->getClientImagePath());
            $product_tracking_manager->persist($tracking_images);
            $product_tracking_manager->flush();
            return $this->render('tracking/{tracking_id}&{page}',
                [   'tracking' => $product_tracking,
                    'tracking_product' => $product,
                    'tracking_images' => $tracking_images,
                    'form' => $form->createView()]);
        }


        return $this->render('tracking/show.html.twig',
            ['tracking' => $product_tracking,
            'tracking_product' => $product,
            'tracking_images' => $tracking_images,
            'form' =>$form->createView()
        ]);
    }


    /**
     * @Route("/data", name="TrackingPage")
     */
    public function index(Request $request)
    {
        $product_tracking = new ProductTracking();
        $form = $this->createForm(ProductTrackingType::class, $product_tracking);
        $form->handleRequest($request);
        $product_existance = true;
        $user_existance = true;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $product_manager = $this->getDoctrine()->getManager();

            $product_tracking_id = $this->product_tracking_id_generator();
            $product_tracking->setTrackingId($product_tracking_id);

            //create a new image path record
            $tracking_image = new TrackingImage();
            $tracking_image ->setTrackingId($product_tracking_id);
            $ProductId  = $data->getProductId();
            $UserId = $data->getClientId();
            $User_id_check = $product_manager->getRepository(User::class)->findOneBy(array('user_id' => $UserId));
            $Product_id_check = $product_manager->getRepository(Product::class)->findOneBy(array('product_id' => $ProductId));

            if ($Product_id_check == null) $product_existance = false;
            if ($User_id_check == null and $UserId!=null ) $user_existance = false;
            if(($Product_id_check == null) or ($User_id_check == null and $UserId!=null )){
                $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
                $product_tracking = $repository->findAll();
                return $this->render('tracking/index.html.twig',
                    ['tracking' => $product_tracking,
                        "product_existance" => $product_existance,
                        "user_existance" => $user_existance,
                        'form' => $form->createView()]);
            }

            $product_tracking->setProductId($ProductId);
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
                    "product_existance" => $product_existance,
                    "user_existance" => $user_existance,
                    'form' => $form->createView()]);
        }


        $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
        $product_tracking = $repository->findAll();
        return $this->render('tracking/index.html.twig',
            ['tracking' => $product_tracking,
                "product_existance" => True,
                "user_existance" => True,
                'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{tracking_id}&{page}", name = "ProductEdit")
     */
    public function tracking_delete($tracking_id, $page)
    {
        $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking = $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        if ($product_tracking != null) {
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
        $product_tracking = $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $form = $this->createForm(ProductTrackingType::class, $product_tracking);
        $form->setData($product_tracking);
        $form->handleRequest($request);
        $product_existance = true;
        $user_existance = true;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ProductId  = $data->getProductId();
            $UserId = $data->getClientId();
            $User_id_check = $product_tracking_manager->getRepository(User::class)->findOneBy(array('user_id' => $UserId));
            $Product_id_check = $product_tracking_manager->getRepository(Product::class)->findOneBy(array('product_id' => $ProductId));
            if ($Product_id_check == null) $product_existance = false;
            if ($User_id_check == null and $UserId!=null ) $user_existance = false;
            if(($Product_id_check == null) or ($User_id_check == null and $UserId!=null )){
                $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
                $product_tracking = $repository->findAll();

                return $this->render('tracking/index.html.twig',
                    ['tracking' => $product_tracking,
                        "product_existance" => $product_existance,
                        "user_existance" => $user_existance,
                        'form' => $form->createView()]);
            }
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
                "product_existance" => $product_existance,
                "user_existance" => $user_existance,
                'form' => $form->createView()]);


    }


    private function product_tracking_id_generator()
    {
        $col_id_name = 'tracking_id';

        $em_users = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT $col_id_name FROM infos ORDER BY $col_id_name DESC LIMIT 1";

        $id_pre = $em_users->prepare($sql);
        $id_pre->execute();
        $id_last = $id_pre->fetchAll();

        if (empty($id_last) || ($id_last[0][$col_id_name]) == "") {
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
