<?php

namespace App\Controller;

use App\Entity\Product;
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

        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);
        $repository = $em->getRepository(PurchaseHistory::class);
        $purchase_history = $repository->findAll();

        $user_existance = true;
        $product_existance = true;
        $purchase_existance = true;

        if ($form->isSubmitted() && $form->isValid()) {
            $purchase_id = $purchase->getPurchaseId();
            $user_phone = $purchase->getUserPhone();
            $date_purchase = $purchase->getDatePurchase();
            $purchase_tracking_id = $purchase->getPurchaseTrackingId();
            $product_id = $purchase->getProductId();
            $quantity = $purchase->getQuantity();

            $user_existance = $em->getRepository(User::class)->findBy(['phone' => $user_phone]) != null;
            $product_existance = $em->getRepository(Product::class)->findBy(['product_id' => $product_id]) != null;

            if($purchase_id == '') {
                if (!$user_existance || !$product_existance) {
                    return $this->render('purchase/index.html.twig', [
                        'purchase' => $purchase_history,
                        'form' => $form->createView(),
                        'user_existance' => $user_existance,
                        'product_existance' => $product_existance,
                        'purchase_existance' => $purchase_existance]);
                } else {
                    $purchase->setPurchaseId($this->generate_purchase_id());
                    $purchase->setUserPhone($user_phone);
                    $purchase->setDatePurchase($date_purchase);
                    $purchase->setPurchaseTrackingId($purchase_tracking_id);
                    $purchase->setProductId($product_id);
                    $purchase->setQuantity($quantity);
                    $em->persist($purchase);
                    $em->flush();

                    return $this->redirectToRoute('PurchaseHistoryPage');
                }
            }else{
                $purchase = $em->getRepository(PurchaseHistory::class)->findBy(['purchase_id' => $purchase_id])[0];
                $purchase_existance = $purchase != null;

                if (!$purchase_existance || !$user_existance || !$product_existance) {
                    return $this->render('purchase/index.html.twig', [
                        'purchase' => $purchase_history,
                        'form' => $form->createView(),
                        'user_existance' => $user_existance,
                        'product_existance' => $product_existance,
                        'purchase_existance' => $purchase_existance]);
                } else {
                    $purchase->setUserPhone($user_phone);
                    $purchase->setDatePurchase($date_purchase);
                    $purchase->setPurchaseTrackingId($purchase_tracking_id);
                    $purchase->setProductId($product_id);
                    $purchase->setQuantity($quantity);
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
            'purchase_existance' => $purchase_existance]);
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
                    'user_phone' => $purchase->getUserPhone(),
                    'product_id' => $purchase->getProductId(),
                    'date_purchase' => $purchase->getDatePurchase()->format('Y-m-d-H-i-s'),
                    'purchase_tracking_id' => $purchase->getPurchaseTrackingId(),
                    'quantity' => $purchase->getQuantity()
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


