<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    public function __construct(UrlGeneratorInterface  $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/registration/user_register", name="UserRegisterPage")
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

            /*
             * 用户名和邮件验证唯一
             * 从数据库中查询是否已存在
             * */
            $user_db_by_username = $userManager->findUserByUsername($username);
            $user_db_by_email = $userManager->findUserByEmail($email);
            if (null != $user_db_by_username) {
                return new Response("Username exist!");
            }
            else if (null != $user_db_by_email) {
                return new Response("Email exist!");
            }
            else {
                /*
                 * 若不存在，用户注册成功，发送账户激活邮件
                 * */
                $token = $this->generate_token();
                $user->setConfirmationToken($token);

                $user->setEnabled(false);
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

                $url = $this->router->generate('registration_confirm' ,array('token' => $token),UrlGeneratorInterface::ABSOLUTE_URL );
                $this->send_activate_email("Activate account", "no-reply@yunkun.org", $email, $url, $username); // 发送邮件

                return $this->render('user/register_check_email.html.twig', [
                    'email' => $email
                ]);
            }
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/registration/user_confirm/{token}", name="UserconfirmPage")
     */
    public function registration_confirm(Request $request, $token)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByConfirmationToken($token);
        $username = $user->getUsername();
        /*
         * 点击邮件中激活链接，如果token在数据库中不存在即报错，反之激活账户
         * */
        if (null != $user) {
            $user->setEnabled(true);
            $userManager->updateUser($user);
            return $this->render('user/register_confirm.html.twig', [
                'username' => $username
            ]);
        } else {
            return new Response("Token invalid!");
        }
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
        $firstname = "Super";
        $lastname = "ADMIN";
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
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
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

    /**
     * @Route("/userList/users", name="UserListUsersPage")
     */
    public function userList_users()
    {
        $sql = "SELECT * FROM User WHERE roles='a:0:{}'";
        $users = $this->UsersGenerator($sql);

        return $this->render('user/userList_users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/userList/sellers", name="UserListSellersPage")
     */
    public function userList_sellers()
    {
        $sql = "SELECT * FROM User WHERE roles LIKE '%\"ROLE_SELLER\"%'";
        $users = $this->UsersGenerator($sql);

        return $this->render('user/userList_sellers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/userList/admins", name="UserListAdminsPage")
     */
    public function userList_admins()
    {
        $sql = "SELECT * FROM User WHERE roles LIKE '%\"ROLE_ADMIN\"%'";
        $users = $this->UsersGenerator($sql);

        return $this->render('user/userList_admins.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @return string
     */
    private function generate_token()
    {
        return hash('sha256', md5(uniqid(md5(microtime(true)),true)));
    }

    /**
     *
     */
    private function send_activate_email($subject_to_send, $mail_from, $mail_to, $url, $username)
    {
        $mail_to_send = (new \Swift_Message())
            ->setSubject($subject_to_send)
            ->setFrom($mail_from)
            ->setTo($mail_to)
            ->setBody($this->renderView(
                'user/confirm_email.html.twig',array(
                'username' => $username,
                    'url' => $url
            )),
                'text/html');
        $this->get('mailer')->send($mail_to_send);
    }

    /**
     * @return array
     */
  private function UsersGenerator($sql)
    {
        $em_users = $this->getDoctrine()->getManager()->getConnection();
        $users_pre = $em_users->prepare($sql);
        $users_pre->execute();
        $users_db = $users_pre->fetchAll();

        $users = array();

        foreach ($users_db as $v) {
            array_push($users, [
                'username' => $v['username'],
                'email' => $v['email'],
                'enabled' => $v['enabled'],
                'last_login' => $v['last_login'],
                'user_id' => $v['user_id'],
                'firstname' => $v['firstname'],
                'lastname' => $v['lastname'],
                'date_birth' => $v['date_birth'],
                'sex' => $v['sex'],
                'id_card' => $v['id_card'],
                'phone' => $v['phone'],
                'wechat' => $v['wechat'],
                'region' => $v['region'],
                'address' => $v['address'],
                'date_register' => $v['date_register'],
                'responsible_id' => $v['responsible_id'],
                'responsible_region' => $v['responsible_region'],
            ]);
        }
        return $users;
    }
}
