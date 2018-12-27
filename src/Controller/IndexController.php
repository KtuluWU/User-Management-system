<?php

namespace App\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

error_reporting(E_ALL);


class IndexController extends AbstractController
{
    private function admin_index(){
        $em = $this->getDoctrine()->getManager()->getConnection();

        $sql_new_users = "SELECT `user_id` FROM `User` WHERE date_sub(curdate(), INTERVAL 7 DAY) <= date(`date_register`) AND roles='a:0:{}'";
        $sql_new_sellers = "SELECT `user_id` FROM `User` WHERE date_sub(curdate(), INTERVAL 7 DAY) <= date(`date_register`) AND roles='a:1:{i:0;s:11:\"ROLE_SELLER\";}'";
        $sql_new_admins = "SELECT `user_id` FROM `User` WHERE date_sub(curdate(), INTERVAL 7 DAY) <= date(`date_register`) AND roles='a:1:{i:0;s:10:\"ROLE_ADMIN\";}'";
        $sql_total_users = "SELECT * FROM `User` WHERE roles='a:0:{}'";
        $sql_total_sellers = "SELECT * FROM `User` WHERE roles='a:1:{i:0;s:11:\"ROLE_SELLER\";}'";
        $sql_total_admins = "SELECT * FROM `User` WHERE roles='a:1:{i:0;s:10:\"ROLE_ADMIN\";}'";

        $new_users_pre = $em->prepare($sql_new_users);
        $new_users_pre->execute();
        $new_users = $new_users_pre->fetchAll();

        $new_sellers_pre = $em->prepare($sql_new_sellers);
        $new_sellers_pre->execute();
        $new_sellers = $new_sellers_pre->fetchAll();

        $new_admins_pre = $em->prepare($sql_new_admins);
        $new_admins_pre->execute();
        $new_admins = $new_admins_pre->fetchAll();

        $total_users_pre = $em->prepare($sql_total_users);
        $total_users_pre->execute();
        $total_users = $total_users_pre->fetchAll();

        $total_sellers_pre = $em->prepare($sql_total_sellers);
        $total_sellers_pre->execute();
        $total_sellers = $total_sellers_pre->fetchAll();

        $total_admins_pre = $em->prepare($sql_total_admins);
        $total_admins_pre->execute();
        $total_admins = $total_admins_pre->fetchAll();

        $count_new_users = count($new_users);
        $count_new_sellers = count($new_sellers);
        $count_new_admins = count($new_admins);

        $count_total_users = count($total_users);
        $count_total_sellers = count($total_sellers);
        $count_total_admins = count($total_admins);

        $info = [
            'new_users' => $count_new_users,
            'new_sellers' => $count_new_sellers,
            'new_admins' => $count_new_admins,
            'total_user' => $count_total_users,
            'total_sellers' => $count_total_sellers,
            'total_admins' => $count_total_admins,
            'sellers' => $total_sellers,
        ];

        return $info;
    }

    private function seller_index(){
        $em = $this->getDoctrine()->getManager()->getConnection();
        $seller_id = $this->getUser()->getId();
        $sql_seller = "SELECT * FROM `User` WHERE id = $seller_id";
        $seller_pre = $em->prepare($sql_seller);
        $seller_pre->execute();
        $seller_array = $seller_pre->fetchAll();
        $seller = $seller_array[0];
        $seller_region = $seller['region'];
        $seller_user_id = $seller['user_id'];

        $sql_user_same_region = "SELECT * FROM `User` WHERE responsible_id IS NULL AND region='$seller_region' AND user_id LIKE '1%'";
        $user_same_region_pre = $em->prepare($sql_user_same_region);
        $user_same_region_pre->execute();
        $user_array = $user_same_region_pre->fetchAll();

        $sql_engaged_user = "SELECT * FROM `User` WHERE responsible_id='$seller_user_id'";
        $engaged_user_pre = $em->prepare($sql_engaged_user);
        $engaged_user_pre->execute();
        $engaged_user_array = $engaged_user_pre->fetchAll();

        $info = [
            'seller' => $seller,
            'users' => $user_array,
            'engaged_users' => $engaged_user_array
        ];
        return $info;
    }

    /**
     * @Route("/", name="HomePage")
     */
    public function index(Request $request)
    {
        $authorization_checker = $this->container->get('security.authorization_checker');
        if($authorization_checker->isGranted('ROLE_SUPER_ADMIN') || $authorization_checker->isGranted('ROLE_ADMIN')){
            $info = $this->admin_index();
        }elseif ($authorization_checker->isGranted('ROLE_SELLER')){
            $info = $this->seller_index();
        }else{
            $info = [];
        }
        return $this->render('index/index.html.twig', $info);
    }
}
