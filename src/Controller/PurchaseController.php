<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductTracking;
use App\Entity\PurchaseHistory;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PurchaseType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/purchasehistory")
 */
class PurchaseController extends AbstractController
{
    /**
     * @Route("/", name="PurchaseHistoryPage")
     */
    public function purchase_show(Request $request)
    {
        $purchase = new PurchaseHistory();
        $em = $this->getDoctrine()->getManager();
        $_id = $this->getUser()->getId();
        $sql_user_id = "SELECT user_id FROM `User` WHERE id = $_id";
        $user_id_pre = $em->getConnection()->prepare($sql_user_id);
        $user_id_pre->execute();
        $user_id_array = $user_id_pre->fetchAll();
        $user_id = $user_id_array[0]['user_id'];

        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);
        $repository = $em->getRepository(PurchaseHistory::class);

        if(substr($user_id, 0, 1) === '1') {
            $purchase_history = $repository->findBy(['user_id' => $user_id]);
        }else{
            $purchase_history = $repository->findAll();
        }

        $user_existance = true;
        $product_existance = true;
        $seller_existance = true;
        $tracking_existance = true;

        if ($form->isSubmitted() && $form->isValid()) {
            $purchase_id = $purchase->getPurchaseId();
            $user_id = $purchase->getUserId();
            $tracking_id = $purchase->getTrackingId();
            $product_id = $purchase->getProductId();
            $purchase_time = $purchase->getPurchaseTime();
            $seller_id = $purchase->getSellerId();

            $user_existance = $em->getRepository(User::class)->findBy(['user_id' => $user_id]) != null;
            $product_existance = $em->getRepository(Product::class)->findBy(['product_id' => $product_id]) != null;
            $seller_existance = $seller_id == NULL ||
                ($em->getRepository(User::class)->findBy(['user_id' => $seller_id]) &&
                    substr($seller_id, 0, 1) === '2');  # seller_id为空或首位为2（销售员）
            $tracking_existance = $em->getRepository(ProductTracking::class)->findBy(['tracking_id' => $tracking_id]) != Null;

            if($purchase_id == '') {
                if (!$user_existance || !$product_existance || !$seller_existance || !$tracking_existance) {
                    return $this->render('purchase/index.html.twig', [
                        'purchase' => $purchase_history,
                        'form' => $form->createView(),
                        'user_existance' => $user_existance,
                        'product_existance' => $product_existance,
                        'seller_existance' => $seller_existance,
                        'tracking_existance' => $tracking_existance]);
                } else {
                    $purchase->setPurchaseId($this->generate_purchase_id());
                    $purchase->setUserId($user_id);
                    $purchase->setTrackingId($tracking_id);
                    $purchase->setProductId($product_id);
                    $purchase->setPurchaseTime($purchase_time);
                    $purchase->setSellerId($seller_id);
                    $em->persist($purchase);
                    $em->flush();

                    return $this->redirectToRoute('PurchaseHistoryPage');
                }
            }else{
                if (!$user_existance || !$product_existance || !$seller_existance || !$tracking_existance) {
                    return $this->render('purchase/index.html.twig', [
                        'purchase' => $purchase_history,
                        'form' => $form->createView(),
                        'user_existance' => $user_existance,
                        'product_existance' => $product_existance,
                        'seller_existance' => $seller_existance,
                        'tracking_existance' => $tracking_existance]);
                } else {
                    $purchase = $em->getRepository(PurchaseHistory::class)->findBy(['purchase_id' => $purchase_id])[0];
                    $purchase->setUserId($user_id);
                    $purchase->setTrackingId($tracking_id);
                    $purchase->setProductId($product_id);
                    $purchase->setPurchaseTime($purchase_time);
                    $purchase->setSellerId($seller_id);
                    $em->persist($purchase);
                    $em->flush();

                    return $this->redirectToRoute('PurchaseHistoryPage');
                }
            }
        }

        return $this->render('purchase/index.html.twig',[
            'purchase' => $purchase_history,
            'form' => $form->createView(),
            'user_existance' => $user_existance,
            'product_existance' => $product_existance,
            'seller_existance' => $seller_existance,
            'tracking_existance' => $tracking_existance
        ]);
    }

    /**
     * @Route("/modify", name="PurchaseHistoryModifyPage", methods="POST")
     */
    public function purchase_modify(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $purchase_id = $params['purchase_id'];
                $em = $this->getDoctrine()->getManager();
                $purchase = $em->getRepository(PurchaseHistory::class)->findBy(['purchase_id' => $purchase_id])[0];
            }
            return new JsonResponse([
                    'purchase_id' => $purchase_id,
                    'user_id' => $purchase->getUserId(),
                    'product_id' => $purchase->getProductId(),
                    'purchase_time' => $purchase->getPurchaseTime()->format('Y-m-d-H-i-s'),
                    'tracking_id' => $purchase->getTrackingId(),
                    'seller_id' => $purchase->getSellerId()
                ]);
        }
    }

    /**
     * @Route("/remove", name="PurchaseHistoryRemovePage", methods="POST")
     */
    public function purchase_remove(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $purchase_id = $params['purchase_id'];
                $em = $this->getDoctrine()->getManager();
                $purchase = $em->getRepository(PurchaseHistory::class)->findBy(['purchase_id' => $purchase_id])[0];
                $em->remove($purchase);
                $em->flush();
            }
        }
    }


    private function generate_purchase_id(){
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT purchase_id FROM infos";
        $id_pre = $conn->prepare($sql);
        $id_pre->execute();
        $purchase_id_last = $id_pre->fetchAll()[0]["purchase_id"];
        if ( empty($purchase_id_last) || ($purchase_id_last) == '') {
            $purchase_id = str_pad("1", 10, "0", STR_PAD_LEFT);
        }else{
            $purchase_id = str_pad((int) $purchase_id_last+1, 10, "0", STR_PAD_LEFT);
        }
        $conn->prepare("UPDATE infos SET purchase_id = $purchase_id")->execute();
        return $purchase_id;
    }

}


