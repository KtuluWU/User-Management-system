<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */

class UserController extends Controller
{
    /**
     * @Route("/", name="UserPage")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/create_base_user", name="CreateBaseUserPage")
     */
    public function create_base_user()
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        date_default_timezone_set("Europe/Paris");

        $username = "super_admin";
        $email = "yun@yunkun.org";
        $enable = 1;
        $plain_psw = "11111";
        $roles = ["ROLE_SUPER_ADMIN"];
        $user_id = "10000000001";
        $fstname = "Super";
        $lstnamle = "ADMIN";
        $dt_birth = date_create("2000-01-01");
        $sex = 1;
        $id_card = "123456789123456789";
        $phone = "0123456789";
        $region = "PARIS";
        $address = "7 Avenue de Paris";
        $register_date = date_create(date('Y-m-d H:i:s'));

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled($enable);
        $user->setPlainPassword($plain_psw);
        $user->setRoles($roles);
        $user->setUserId($user_id);
        $user->setFirstname($fstname);
        $user->setLastname($lstnamle);
        $user->setDateBirth($dt_birth);
        $user->setSex($sex);
        $user->setIdCard($id_card);
        $user->setPhone($phone);
        $user->setRegion($region);
        $user->setAddress($address);
        $user->setDateRegister($register_date);

        $userManager->updateUser($user);

        return new Response("Super Admin Created !");
    }

}
