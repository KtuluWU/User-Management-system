<?php

namespace App\Controller;

use App\Entity\PurchaseHistory;
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
use Symfony\Component\HttpKernel\Profiler\Profiler;
use App\Entity\TrackingImage;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Form\ImagePathType;
use Twig\Error\RuntimeError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * @Route("/tracking", name = "Tracking")
 */
class TrackingController extends AbstractController
{
    /**
     * @Route("/{tracking_id}&{page}", name = "ShowPage")
     */
    public function show(Request $request, $tracking_id)
    {
        $manager = $this->getDoctrine()->getManager();
        $product_tracking = $manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $tracking_images = $manager->getRepository(TrackingImage::class)->findOneBy(array('tracking_id'=> $tracking_id));
        $product_id = $product_tracking->getProductId();
        $product = $manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id))->getProductName();
        $purchase_info = $manager->getRepository(PurchaseHistory::class)->findOneBy(['tracking_id' => $tracking_id]);
        if($purchase_info == NULL){
            $purchase_time = NULL;
        }else{
            $purchase_time = $purchase_info->getPurchaseTime();
        }
        $form = $this->createForm(ImagePathType::class);


        //initialization form
        $form->get("StartMessage")->setData($tracking_images->getStartMessage());
        $form->get("RanchMessage")->setData($tracking_images->getRanchMessage());
        $form->get("FactoryMessage")->setData($tracking_images->getFactoryMessage());
        $form->get("FactoryDeliveryMessage")->setData($tracking_images->getFactoryDeliveryMessage());
        $form->get("ExportMessage")->setData($tracking_images->getExportMessage());
        $form->get("ImportMessage")->setData($tracking_images->getImportMessage());
        $form->get("CenterMessage")->setData($tracking_images->getCenterMessage());
        $form->get("Site1Message")->setData($tracking_images->getSite1Message());
        $form->get("Site2Message")->setData($tracking_images->getSite2Message());
        $form->get("Site3Message")->setData($tracking_images->getSite3Message());
        $form->get("CenterMessage")->setData($tracking_images->getCenterMessage());
        $form->get("ClientMessage")->setData($tracking_images->getClientMessage());


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tracking_images->setStartMessage($form->get("StartMessage")->getdata());
            $image_file = $form->get("StartImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getStartImagePath());
            $tracking_images->setStartImagePath($path);


            $tracking_images->setRanchMessage($form->get("RanchMessage")->getData());
            $image_file = $form->get("RanchImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getRanchImagePath());
            $tracking_images->setRanchImagePath($path);


            $tracking_images->setFactoryMessage($form->get("FactoryMessage")->getData());
            $image_file = $form->get("FactoryImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getFactoryImagePath());
            $tracking_images->setFactoryImagePath($path);


            $tracking_images->setFactoryDeliveryMessage($form->get("FactoryDeliveryMessage")->getData());
            $image_file = $form->get("FactoryDeliveryImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getFactoryDeliveryImagePath());
            $tracking_images->setFactoryDeliveryImagePath($path);


            $tracking_images->setExportMessage($form->get("ExportMessage")->getData());
            $image_file = $form->get("ExportImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getExportImagePath());
            $tracking_images->setExportImagePath($path);


            $tracking_images->setImportMessage($form->get("ImportMessage")->getData());
            $image_file = $form->get("ImportImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getImportImagePath());
            $tracking_images->setImportImagePath($path);

            $tracking_images->setCenterMessage($form->get("CenterMessage")->getData());
            $image_file = $form->get("CenterImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getCenterImagePath());
            $tracking_images->setCenterImagePath($path);


            $tracking_images->setSite1Message($form->get("Site1Message")->getData());
            $image_file = $form->get("Site1ImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getSite1ImagePath());
            $tracking_images->setSite1ImagePath($path);


            $tracking_images->setSite2Message($form->get("Site2Message")->getData());
            $image_file = $form->get("Site2ImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getSite2ImagePath());
            $tracking_images->setSite2ImagePath($path);


            $tracking_images->setSite3Message($form->get("Site3Message")->getData());
            $image_file = $form->get("Site3ImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getSite3ImagePath());
            $tracking_images->setSite3ImagePath($path);


            $tracking_images->setClientMessage($form->get("ClientMessage")->getData());
            $image_file = $form->get("ClientImagePath")->getData();
            $path = $this->processing_image($image_file,$tracking_images->getClientImagePath());
            $tracking_images->setClientImagePath($path);

            $manager->persist($tracking_images);
            $manager->flush();

        }


        return $this->render('tracking/show.html.twig',
            ['tracking' => $product_tracking,
            'tracking_product' => $product,
            'tracking_images' => $tracking_images,
            'form' =>$form->createView(),
            'is_block' => false,
            'purchase_time' => $purchase_time
        ]);
    }

    public function get_user_id(){
        $user_id = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager()->getConnection();
        $id_pre = $em->prepare("SELECT `user_id` FROM `User` WHERE `id` = $user_id");
        $id_pre->execute();
        $id = $id_pre->fetchAll();
        $id = array_pop($id)['user_id'];
        return $id;
    }

    /**
     * @Route("/block", name = "ShowTrackingBlock")
     */
    public function show_block(Profiler $profiler)
    {
        $profiler->disable();
        $manager = $this->getDoctrine()->getManager();
        $user_id = $this->get_user_id();
        $purchase_info = $manager->getRepository(PurchaseHistory::class)->findOneBy(['user_id' => $user_id]);
        $tracking_id = $purchase_info->getTrackingId();
        $product_tracking= $manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        $product_id = $product_tracking->getProductId();
        $product_name = $manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id))->getProductName();
        $tracking_images = $manager->getRepository(TrackingImage::class)->findOneBy(array('tracking_id'=> $tracking_id));

        if($purchase_info == NULL){
            $purchase_time = NULL;
        }else{
            $purchase_time = $purchase_info->getPurchaseTime();
        }
        return $this->render('tracking/tracking_block.html.twig',
            ['tracking' => $product_tracking,
            'tracking_product' => $product_name,
            'tracking_images' => $tracking_images,
            'is_block' => true,
            'purchase_time' => $purchase_time]);
    }



    /**
     * @Route("/data", name="ProductTrackingPage")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ProductTrackingType::class);
        $form->handleRequest($request);
        $product_existance = true;
        $user_existance = true;


        if ($form->isSubmitted() && $form->isValid()) {
            $product_tracking = new ProductTracking();
            $product_tracking_manager = $this->getDoctrine()->getManager();
            $ProductId  = $form->get('product_id')->getData();
            $UserId = $form->get('client_id')->getData();
            $User_id_check = $product_tracking_manager->getRepository(User::class)->findOneBy(array('user_id' => $UserId));
            $Product_id_check = $product_tracking_manager->getRepository(Product::class)->findOneBy(array('product_id' => $ProductId));

            if ($Product_id_check == null) $product_existance = false;
            if ($User_id_check == null and $UserId!=null ) $user_existance = false;
            if(($Product_id_check == null) or ($User_id_check == null and $UserId!=null )){
                $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
                $product_trackings = $repository->findAll();
                return $this->render('tracking/index.html.twig',
                    ['product_trackings' => $product_trackings,
                        "product_existance" => $product_existance,
                        "user_existance" => $user_existance,
                        'form' => $form->createView()]);
            }

            $batch_number = $form->get('batch_number')->getData();
            $Id = $form->get('tracking_id')->getData();
            if($batch_number== 1 or $batch_number== null) {
                if($Id == null) {
                    $product_tracking_id =  $this->product_tracking_id_generator();
                    $this->product_tracking_id_setter($product_tracking_id);
                    $new_tracking_image = new TrackingImage();
                    $new_tracking_image->setTrackingId($product_tracking_id);
                    $product_tracking_manager->persist($new_tracking_image);
                    $product_tracking_manager->flush();}
                else {
                    $product_tracking_id = $form->get('tracking_id')->getData();
                    $product_tracking = $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $product_tracking_id));

                }

                $product_tracking->setTrackingId($product_tracking_id);
                $product_tracking->setProductId($ProductId);
                $product_tracking->setProductionDate($form->get('production_date')->getData());
                $product_tracking->setBatchId($form->get('batch_id')->getData());
                $product_tracking->setStartingTime($form->get('starting_time')->getData());
                $product_tracking->setRanchId($form->get('ranch_id')->getData());
                $product_tracking->setMilkCollectionTime($form->get('milk_collection_time')->getData());
                $product_tracking->setRanchResponsible($form->get('ranch_responsible')->getData());
                $product_tracking->setFactory($form->get('factory')->getData());
                $product_tracking->setFactoryProcessingTime($form->get('factory_processing_time')->getData());
                $product_tracking->setFactoryResponsible($form->get('factory_responsible')->getData());
                $product_tracking->setFactoryDeliveryTime($form->get('factory_delivery_time')->getData());
                $product_tracking->setFactoryDeliveryResponsible($form->get('factory_delivery_responsible')->getData());
                $product_tracking->setExportTime($form->get('export_time')->getData());
                $product_tracking->setExportResponsible($form->get('export_responsible')->getData());
                $product_tracking->setImportTime($form->get('import_time')->getData());
                $product_tracking->setImportResponsible($form->get('import_responsible')->getData());
                $product_tracking->setCenterArrivalTime($form->get('center_arrival_time')->getData());
                $product_tracking->setArrivalResponsible($form->get('arrival_responsible')->getData());
                $product_tracking->setSite1($form->get('site_1')->getData());
                $product_tracking->setSite1DeliveryTime($form->get('site_1_delivery_time')->getData());
                $product_tracking->setSite1Responsible($form->get('site_1_responsible')->getData());
                $product_tracking->setSite2($form->get('site_2')->getData());
                $product_tracking->setSite2DeliveryTime($form->get('site_2_delivery_time')->getData());
                $product_tracking->setSite2Responsible($form->get('site_2_responsible')->getData());
                $product_tracking->setSite3($form->get('site_3')->getData());
                $product_tracking->setSite3DeliveryTime($form->get('site_3_delivery_time')->getData());
                $product_tracking->setSite3Responsible($form->get('site_3_responsible')->getData());
                $product_tracking->setClientId($form->get('client_id')->getData());

                $product_tracking->setPurchaseTime($form->get('purchase_time')->getData());
                $product_tracking->setSellerId($form->get('seller_id')->getData());
                $product_tracking_manager->persist($product_tracking);
                $product_tracking_manager->flush();
            }
            else{


                for($i=0;$i<$batch_number;$i++) {

                    $product_tracking_id = $this->product_tracking_id_generator();
                    $this->product_tracking_id_setter($product_tracking_id);

                    $new_tracking_image = new TrackingImage();
                    $new_tracking_image->setTrackingId($product_tracking_id);
                    $product_tracking_manager->persist($new_tracking_image);
                    $product_tracking_manager->flush();


                    $product_tracking = new ProductTracking();
                    $product_tracking->setTrackingId($product_tracking_id);
                    $product_tracking->setProductId($ProductId);
                    $product_tracking->setProductionDate($form->get('production_date')->getData());
                    $product_tracking->setBatchId($form->get('batch_id')->getData());
                    $product_tracking->setStartingTime($form->get('starting_time')->getData());
                    $product_tracking->setRanchId($form->get('ranch_id')->getData());
                    $product_tracking->setMilkCollectionTime($form->get('milk_collection_time')->getData());
                    $product_tracking->setRanchResponsible($form->get('ranch_responsible')->getData());
                    $product_tracking->setFactory($form->get('factory')->getData());
                    $product_tracking->setFactoryProcessingTime($form->get('factory_processing_time')->getData());
                    $product_tracking->setFactoryResponsible($form->get('factory_responsible')->getData());
                    $product_tracking->setFactoryDeliveryTime($form->get('factory_delivery_time')->getData());
                    $product_tracking->setFactoryDeliveryResponsible($form->get('factory_delivery_responsible')->getData());
                    $product_tracking->setExportTime($form->get('export_time')->getData());
                    $product_tracking->setExportResponsible($form->get('export_responsible')->getData());
                    $product_tracking->setImportTime($form->get('import_time')->getData());
                    $product_tracking->setImportResponsible($form->get('import_responsible')->getData());
                    $product_tracking->setCenterArrivalTime($form->get('center_arrival_time')->getData());
                    $product_tracking->setArrivalResponsible($form->get('arrival_responsible')->getData());
                    $product_tracking->setSite1($form->get('site_1')->getData());
                    $product_tracking->setSite1DeliveryTime($form->get('site_1_delivery_time')->getData());
                    $product_tracking->setSite1Responsible($form->get('site_1_responsible')->getData());
                    $product_tracking->setSite2($form->get('site_2')->getData());
                    $product_tracking->setSite2DeliveryTime($form->get('site_2_delivery_time')->getData());
                    $product_tracking->setSite2Responsible($form->get('site_2_responsible')->getData());
                    $product_tracking->setSite3($form->get('site_3')->getData());
                    $product_tracking->setSite3DeliveryTime($form->get('site_3_delivery_time')->getData());
                    $product_tracking->setSite3Responsible($form->get('site_3_responsible')->getData());
                    $product_tracking->setClientId($form->get('client_id')->getData());
                    $product_tracking->setPurchaseTime($form->get('purchase_time')->getData());
                    $product_tracking->setSellerId($form->get('seller_id')->getData());
                    $product_tracking_manager->persist($product_tracking);
                    $product_tracking_manager->flush();
                }
            }


            return $this->redirectToRoute("TrackingProductTrackingPage");
        }

        $repository = $this->getDoctrine()->getRepository(ProductTracking::class);
        $product_trackings = $repository->findAll();
        return $this->render('tracking/index.html.twig',
            ['product_trackings' => $product_trackings,
                "product_existance" => True,
                "user_existance" => True,
                'form' => $form->createView()
                ]);
    }

    /**
     * @Route("/delete/{tracking_id}&{page}", name = "ProductDelete")
     */
    public function tracking_delete($tracking_id, $page)
    {
        $product_tracking_manager = $this->getDoctrine()->getManager();
        $product_tracking = $product_tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));
        if ($product_tracking != null) {
            $product_tracking_manager->remove($product_tracking);
            $product_tracking_manager->flush();
        }
        return $this->redirectToRoute("TrackingProductTrackingPage");
    }


    /**
     * @Route("/modify", name="TrackingModifyPage", methods="POST")
     */

    public function tracking_modify(Request $request)
    {

        if ($request->isXmlHttpRequest()) {
            $content = $request->getContent();
            if (!empty($content)) {

                $params = json_decode($content, true);
                $tracking_id = $params['tracking_id'];
                $tracking_manager = $this->getDoctrine()->getManager();
                $product_tracking = $tracking_manager->getRepository(ProductTracking::class)->findOneBy(array('tracking_id' => $tracking_id));



                return new JsonResponse([
                    'tracking_id' => $product_tracking->getTrackingId(),
                    'product_id' => $product_tracking->getProductId(),
                    'production_date' => $product_tracking->getProductionDate(),
                    'batch_id' => $product_tracking->getBatchId(),
                    'starting_time' => $product_tracking->getStartingTime(),
                    'ranch_id' => $product_tracking->getRanchId(),
                    'milk_collection_time' => $product_tracking->getMilkCollectionTime(),
                    'ranch_responsible' => $product_tracking->getRanchResponsible(),
                    'factory' => $product_tracking->getFactory(),
                    'factory_processing_time' => $product_tracking->getFactoryProcessingTime(),
                    'factory_responsible' => $product_tracking->getFactoryResponsible(),
                    'factory_delivery_time' => $product_tracking->getFactoryDeliveryTime(),
                    'factory_delivery_responsible' => $product_tracking->getFactoryDeliveryResponsible(),
                    'export_time' => $product_tracking->getExportTime(),
                    'export_responsible' => $product_tracking->getExportResponsible(),
                    'import_time' => $product_tracking->getImportTime(),
                    'import_responsible' => $product_tracking->getArrivalResponsible(),
                    'center_arrival_time' => $product_tracking->getCenterArrivalTime(),
                    'arrival_responsible' => $product_tracking->getRanchResponsible(),
                    'site_1' => $product_tracking->getSite1(),
                    'site_1_delivery_time' => $product_tracking->getSite1DeliveryTime(),
                    'site_1_responsible' => $product_tracking->getSite1Responsible(),
                    'site_2' => $product_tracking->getSite2(),
                    'site_2_delivery_time' => $product_tracking->getSite2DeliveryTime(),
                    'site_2_responsible' => $product_tracking->getSite2Responsible(),
                    'site_3' => $product_tracking->getSite3(),
                    'site_3_delivery_time' => $product_tracking->getSite3DeliveryTime(),
                    'site_3_responsible' => $product_tracking->getSite3Responsible(),
                    'client_id' => $product_tracking->getClientId(),
                    'purchase_time' => $product_tracking->getPurchaseTime(),
                    'seller_id' => $product_tracking->getSellerId()

                ]);
            }
        }
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
    private function processing_image($image_file,$old_path){
        if (null == $image_file) {
            $new_image_path = $old_path;
        } else {
            $new_image_path = md5(uniqid()) . '.' . $image_file->guessExtension();
            $image_file->move(
                $this->getParameter('uploads_images_trackings'),
                $new_image_path
            );
            //delete original image and save new image
            $image_path = $old_path;
            $original_image = $this->getParameter('uploads_images_trackings') . "/" . $image_path;
            if ($image_path!=null and file_exists($original_image) and $original_image != $this->getParameter('uploads_images_trackings') . "/example.jpg") {
                unlink($original_image);
            }
        }


        return $new_image_path;
    }
}

