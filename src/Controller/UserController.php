<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{

    /**
     * @Route("/user_register", name="UserRegisterPage")
     */
    public function  user_register( Request $request)
    {

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(Registrationtype::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $username = $user->getUsername();
            $email = $user->getEmail();
            $plainpsw = $user->getPlainPassword();
            $date_birth = $user->getDateBirth();
            $sex = $user->getSex();
            $id_card = $user->getIdCard();
            $phone = $user->getPhone();
            $wechat = $user->getWechat();
            $region = $user->getRegion();
            $address = $user->getAddress();

            $roles = ["ROLE_USER"];
            $user_id = "00000000000001";
            date_default_timezone_set("Europe/Paris");
            $register_date = date_create(date('Y-m-d H:i:s'));
            $user->setEnabled("false");

            /*
             * 验证Username
             * findUserByUsername
             *
             * if !empty
             * render (error.html.twig)
             * else
             * 生成token
             * set token
             * */

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($plainpsw);
            $user->setDateBirth($date_birth);
            $user->setSex($sex);
            $user->setIdCard($id_card);
            $user->setPhone($phone);
            $user->setWechat($wechat);
            $user->setRegion($region);
            $user->setAddress($address);
            $user->setUserId($user_id);
            $user->setRoles($roles);
            $user->setDateRegister($register_date);

            $userManager->updateUser($user);

            /*
             * 发邮件
             * */

            return $this->redirectToRoute('HomePage');

        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/user/create_base_user", name="CreateBaseUserPage")
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
