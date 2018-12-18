<?php

namespace App\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @Route("/", name="HomePage")
     */
    public function index(Request $request)
    {
        $authorization_checker = $this->container->get('security.authorization_checker');
        if($authorization_checker->isGranted('ROLE_SUPER_ADMIN') || $authorization_checker->isGranted('ROLE_ADMIN')){
            $info = $this->admin_index();
        }else{
            $info = [];
        }
        return $this->render('index/index.html.twig', $info);
    }
}
