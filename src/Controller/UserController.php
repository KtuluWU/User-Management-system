<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationType;
use App\Form\UserListEditType;
use App\Form\UserListAddType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Filesystem\Filesystem;
error_reporting(E_ALL);


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
            $data = $form->getData();

            $user_id = $this->user_id_generator('ROLE_USER');
            date_default_timezone_set("Europe/Paris");
            $register_date = date_create(date('Y-m-d H:i:s'));
            $token = $this->token_generator();
            $user->setConfirmationToken($token);

            $user->setEnabled(false);
            $user->setUsername($data->getUsername());
            $user->setFirstname($data->getFirstname());
            $user->setLastname($data->getLastname());
            $user->setSex($data->getSex());
            $user->setEmail($data->getEmail());
            $user->setDateBirth($data->getDateBirth());
            $user->setPhone($data->getPhone());
            $user->setWechat($data->getWechat());
            $user->setAddress($data->getAddress());
            $user->setRegion($data->getRegion());
            $user->setIdCard($data->getIdCard());
            $user->setPlainPassword($data->getPlainPassword());
            $user->setRoles(['ROLE_USER']);
            $user->setUserId($user_id);
            $user->setDateRegister($register_date);

            $userManager->updateUser($user);

            $this->user_id_amt_setter('ROLE_USER', $user_id);

            $url = $this->router->generate('registration_confirm' ,array('token' => $token),UrlGeneratorInterface::ABSOLUTE_URL );
            $this->send_activate_email("Activate account", "no-reply@yunkun.org", $data->getEmail(), $url, $data->getUsername()); // 发送邮件

            return $this->render('user/register_check_email.html.twig', [
                'email' => $data->getEmail()
            ]);

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
        $role = ['ROLE_SUPER_ADMIN'];
        $user_id = $this->user_id_generator('ROLE_SUPER_ADMIN');
        $firstname = "Super";
        $lastname = "ADMIN";
        $dt_birth = date_create("2000-01-01");
        $sex = 1;
        $id_card = "123456789123456789";
        $phone = "0123456789";
        $region = "beijing";
        $address = "7 Avenue de Paris";
        $register_date = date_create(date('Y-m-d H:i:s'));

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled($enable);
        $user->setPlainPassword($plain_psw);
        $user->setRoles($role);
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

        $this->user_id_amt_setter('ROLE_SUPER_ADMIN', $user_id);

        return new Response("Super Admin Created !");
    }

    /**
     * @Route("/userList/users", name="UserListUsersPage")
     */
    public function userList_users(Request $request)
    {
        $em = $this->getDoctrine()->getRepository(User::class);
        $users = $em->findMembers();

        date_default_timezone_set("Europe/Paris");

        $form_file = $this->createFormBuilder()
            ->add('submitFile', FileType::class, array('label' => '上传文件'))
            ->getForm();
        $form_file->handleRequest($request);

        if ( $form_file->isSubmitted() && $form_file->isValid() ) {
            $fileSystem = new Filesystem();
            $file = $form_file->get('submitFile');
            $users_file = $file->getData();

            $file_name = md5(uniqid()).'.'.$users_file->guessExtension();
            $users_file->move($this->getParameter('users_file'), $file_name);

            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
            $data = $serializer->decode(file_get_contents(($this->getParameter('users_file'))."/".$file_name), 'csv');
            $fileSystem->remove(($this->getParameter('users_file'))."/".$file_name);
            return new Response(var_dump($data));
        }

        $month_count = $this->get_register_month_distribution($users);

        return $this->render('user/userList_users.html.twig', [
            'users' => $users,
            'form_file' => $form_file->createView(),
            'month_count' => $month_count
        ]);
    }

    /**
     * @Route("/userList/sellers", name="UserListSellersPage")
     */
    public function userList_sellers(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $users_obj = $this->getDoctrine()->getRepository(User::class);
        $users = $users_obj->findUserByRole('ROLE_SELLER');

        date_default_timezone_set("Europe/Paris");

        $form = $this->createForm(UserListAddType::class, $user);
        $form->handleRequest($request);

        $form_file = $this->createFormBuilder()
                        ->add('submitFile', FileType::class, array('label' => '上传文件'))
                        ->getForm();
        $form_file->handleRequest($request);

        if ( $form_file->isSubmitted() && $form_file->isValid() ) {
            return new Response("Yes!!!");
        }

        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->addUserSetData($form, $user, $userManager);

            return $this->redirectToRoute('UserListSellersPage');
        }

        return $this->render('user/userList_sellers.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'form_file' => $form_file->createView()
        ]);
    }

    /**
     * @Route("/userList/admins", name="UserListAdminsPage")
     */
    public function userList_admins(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $users_obj = $this->getDoctrine()->getRepository(User::class);
        $users = $users_obj->findUserByRole('ROLE_ADMIN');

        date_default_timezone_set("Europe/Paris");

        $form = $this->createForm(UserListAddType::class, $user);
        $form->handleRequest($request);

        $form_file = $this->createFormBuilder()
            ->add('submitFile', FileType::class, array('label' => '上传文件'))
            ->getForm();
        $form_file->handleRequest($request);

        if ( $form_file->isSubmitted() && $form_file->isValid() ) {
            return new Response("Yes!!!");
        }

        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->addUserSetData($form, $user, $userManager);

            return $this->redirectToRoute('UserListAdminsPage');
        }

        return $this->render('user/userList_admins.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'form_file' => $form_file->createView()
        ]);
    }

    /**
     * @Route("/userList/edit/{user_id}&{page}")
     */
    public function userList_edit(Request $request, $user_id, $page)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['user_id' => $user_id]);

        $form = $this->createForm(UserListEditType::class, $user);
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user->setUsername($data->getUsername());
            $user->setFirstname($data->getFirstname());
            $user->setLastname($data->getLastname());
            $user->setSex($data->getSex());
            $user->setEmail($data->getEmail());
            $user->setDateBirth($data->getDateBirth());
            $user->setPhone($data->getPhone());
            $user->setWechat($data->getWechat());
            $user->setAddress($data->getAddress());
            $user->setRegion($data->getRegion());
            $user->setResponsibleRegion($data->getResponsibleRegion());
            $user->setEnabled($data->isEnabled());

            $userManager->updateUser($user);
            return $this->redirectToRoute('UserList'.$page.'Page');
        }

        return $this->render('user/userList_edit.html.twig', [
            'form' => $form->createView(),
            'page' => $page
        ]);
    }

    /**
     * @Route("/userList/delete/{user_id}&{page}")
     */
    public function userList_delete($user_id, $page)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['user_id' => $user_id]);
        $role = ($user->getRoles())[0];
        $userManager->deleteUser($user);
        $this->user_amt_deleter($role);
        return $this->redirectToRoute('UserList'.$page.'Page');
    }

    /**
     * @return string
     */
    private function token_generator()
    {
        return hash('sha256', md5(uniqid(md5(microtime(true)),true)));
    }

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
     * @return string
     */
    private function user_id_generator($role)
    {
        switch ($role) {
            case 'ROLE_USER':
                $col_id_name = 'user_id';
                break;
            case 'ROLE_SELLER':
                $col_id_name = 'seller_id';
                break;
            case 'ROLE_ADMIN'||'ROLE_SUPER_ADMIN':
                $col_id_name = 'admin_id';
                break;
        }

        $em_users = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT $col_id_name FROM infos ORDER BY $col_id_name DESC LIMIT 1";

        $id_pre = $em_users->prepare($sql);
        $id_pre->execute();
        $id_last = $id_pre->fetchAll();

        if ( empty($id_last) || ($id_last[0][$col_id_name]) == '') {
            if ($col_id_name == 'user_id') {
                $member_id = '100000001';
            }else if ($col_id_name == 'seller_id') {
                $member_id = '200000001';
            }else if ($col_id_name == 'admin_id') {
                $member_id = '300000001';
            }
        } else {
            $member_id = (int)$id_last[0][$col_id_name] + 1;
        }
        return (string)$member_id;
    }

    private function user_id_amt_setter($role, $user_id)
    {
        switch ($role) {
            case 'ROLE_USER':
                $col_id_name = 'user_id';
                $col_amt_name = 'user_amt';
                break;
            case 'ROLE_SELLER':
                $col_id_name = 'seller_id';
                $col_amt_name = 'seller_amt';
                break;
            case 'ROLE_ADMIN'||'ROLE_SUPER_ADMIN':
                $col_id_name = 'admin_id';
                $col_amt_name = 'admin_amt';
                break;
        }
        $em_users = $this->getDoctrine()->getManager()->getConnection();

        $sql_init = "SELECT * FROM infos LIMIT 1";
        $stm_init = $em_users->prepare($sql_init);
        $stm_init->execute();
        $db = $stm_init->fetchAll();

        if (empty($db)) {
            $sql_first = "INSERT INTO infos VALUES (1,'','','',0,0,0,'','','')";
            $stm_first = $em_users->prepare($sql_first);
            $stm_first->execute();
        }

        $sql = "UPDATE infos SET $col_id_name = $user_id ";
        $stm = $em_users->prepare($sql);
        $stm->execute();

        $sql2 = "UPDATE infos SET $col_amt_name = $col_amt_name + 1";
        $stm2 = $em_users->prepare($sql2);
        $stm2->execute();
    }

    private function user_amt_deleter($role)
    {
        switch ($role) {
            case 'ROLE_USER':
                $col_amt_name = 'user_amt';
                break;
            case 'ROLE_SELLER':
                $col_amt_name = 'seller_amt';
                break;
            case 'ROLE_ADMIN'||'ROLE_SUPER_ADMIN':
                $col_amt_name = 'admin_amt';
                break;
        }
        $em_users = $this->getDoctrine()->getManager()->getConnection();

        $sql = "UPDATE infos SET $col_amt_name = $col_amt_name - 1";
        $stm = $em_users->prepare($sql);
        $stm->execute();
    }

    private function get_register_month_distribution($users){
        $month_count = array_fill_keys(range(1, 12), 0);
        foreach ($users as $user){
            $month = intval($user->getDateRegister()->format('m'));
            $month_count[$month] += 1;
        }
        return $month_count;
    }

    private function get_user_date_by($em, $date_by){
        $qb = $em->createQueryBuilder();
        $mapping = [
            "day" => "-30 day",
            "week" => "-10 week",
            "month" => "-6 month",
            "year" => "-1 year"
        ];
        $starting_date = new \DateTime($mapping[$date_by]);
        $qb->select('u.date_register')
            ->from('App\Entity\User', 'u')
            ->where('u.date_register > :starting_date')
            ->andWhere('u.date_register < :now')
            ->setParameter('starting_date', $starting_date, \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('now',new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME);
        $filtered_users = $qb->getQuery()->getResult();
        $qb_acc = $em->createQueryBuilder();
        $qb_acc->select('count(u.date_register)')
               ->from('App\Entity\User', 'u')
               ->where('u.date_register <= :starting_date')
               ->setParameter('starting_date', $starting_date, \Doctrine\DBAL\Types\Type::DATETIME);
        $accumulated_user_count = $qb_acc->getQuery()->getResult();
        foreach ($filtered_users as &$user){
            $user = $user['date_register']->format('Y-m-d');
        }
        return [$filtered_users, $accumulated_user_count, $starting_date->format('Y-m-d')];
    }

    /**
     * @Route("/service/get_user_count", name="GetUserCount", methods="POST")
     */
    public function send_user_count(Request $request){
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $em = $this->getDoctrine()->getManager();
                $params = json_decode($content, true);
                $date_by = $params['date_by'];
                $res_tuple = $this->get_user_date_by($em, $date_by);
                $filtered_users = $res_tuple[0];
                $accumulated_user_count = $res_tuple[1];
                $starting_date = $res_tuple[2];
                $res_dict = [
                    'filtered_users' => $filtered_users,
                    'accumulated_user_count' => (int) $accumulated_user_count[0]["1"],  //"accumulated_user_count":[{"1":"329"}]
                    'starting_date' => $starting_date
                ];
                return new JsonResponse(json_encode($res_dict));
            }
        }
        return null;
    }

    private function addUserSetData($form, $user, $userManager)
    {
        $data = $form->getData();
        $user_id = $this->user_id_generator(($data->getRoles())[0]);
        date_default_timezone_set("Europe/Paris");
        $register_date = date_create(date('Y-m-d H:i:s'));

        $user->setUsername($data->getUsername());
        $user->setFirstname($data->getFirstname());
        $user->setLastname($data->getLastname());
        $user->setSex($data->getSex());
        $user->setEmail($data->getEmail());
        $user->setDateBirth($data->getDateBirth());
        $user->setPhone($data->getPhone());
        $user->setWechat($data->getWechat());
        $user->setAddress($data->getAddress());
        $user->setRegion($data->getRegion());
        $user->setIdCard($data->getIdCard());
        $user->setEnabled($data->isEnabled());
        $user->setRoles($data->getRoles());
        $user->setPlainPassword($data->getPlainPassword());
        $user->setUserId($user_id);
        $user->setDateRegister($register_date);

        $userManager->updateUser($user);

        $this->user_id_amt_setter(($data->getRoles())[0], $user_id);
    }
}
