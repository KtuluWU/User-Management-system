<?php

namespace App\Controller;

use App\Entity\PurchaseHistory;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PurchaseType;
/**
 * @Route("/purchasehistory")
 */
class PurchaseController extends AbstractController
{
    /**
     * @Route("/", name="PurchaseHistoryPage")
     */
    public function purchase_show()
    {
        return $this->render('purchase/index.html.twig');
    }


    /**
     * @Route("/purchase/history/register", name="PurchaseRegisterPage")
     */
    public function  purchase_register( Request $request)
    {

        $purchase = new PurchaseHistory();

        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $num = 1;
            $purchase_id = '000000000000000000'.$num;
            $user_id = $purchase->getUserId();
            $date_purchase = $purchase->getDatePurchase();
            $purchase_tracking_id = $purchase->getPurchaseTrackingId();
            $product = $purchase->getProductId();
            $quantity = $purchase->getQuantity();


            $purchase_manager = $this->getDoctrine()->getManager();
            $user_comfirmation = $purchase_manager->getRepository(User::class)->findBy(array('username' => $user_id));

            if (null == $user_comfirmation) {
                return new Response("User does not exist!");
            }
            
            else {
                
                $purchase->setPurchaseId($purchase_id);
                $purchase->setUserId($user_id);
                $purchase->setDatePurchase($date_purchase);
                $purchase->setPurchaseTrackingId($purchase_tracking_id);
                $purchase->setProductId($product);
                $purchase->setQuantity($quantity);
                $purchase_manager->persist($purchase);
                $purchase_manager->flush();
            }
        }
        return $this->render('purchase/purchase_register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}


