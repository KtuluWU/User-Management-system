<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationType;
use App\Form\UserListEditType;
use App\Form\UserListAddType;
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


class GenerateFakeUsers extends Controller
{
    /**
     * @Route("/fake/user", name="GenerateFakeUsers")
     */
    public function generate_fake_users()
    {
        $userManager = $this->get('fos_user.user_manager');

        # 30秒添加了120个用户，30秒之后超时错误，很慢，或许可以批量添加
        for ($i = 0; $i < 10000; $i++) {
            $user = $userManager->createUser();
            date_default_timezone_set("Europe/Paris");

            $username = $this->generateRandomString(rand(5, 20));
            $email = $username."@yunkun.org";
            $enable = 1;
            $plain_psw = $username;
            $role = ['ROLE_USER'];
            $user_id = $this->user_id_generator('ROLE_USER');
            $firstname = ucfirst($this->generateRandomName(rand(4, 15)));
            $lastname = ucfirst($this->generateRandomName(rand(4, 15)));
            $dt_birth = date_create("2000-01-01");
            $sex = rand(0, 1);
            $id_card = $this->generateRandomNumber(13);
            $phone = $this->generateRandomNumber(11);
            $region = "beijing";
            $address = "7 Avenue de Paris";
            $register_date = date_create("2017-".$this->generateRandomMonthDay());

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

            $this->user_id_amt_setter('ROLE_USER', $user_id);
        }
        return new Response("Fake users created!");
    }

    function generateRandom($length = 10, $characters) {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateRandomString($length){
        return $this->generateRandom($length, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }

    function generateRandomName($length){
        return $this->generateRandom($length, 'abcdefghijklmnopqrstuvwxyz');
    }

    function generateRandomNumber($length){
        return $this->generateRandom($length, '0123456789');
    }

    function generateRandomMonthDay(){
        $count_month = [10];
        $counts = [];
        for ($i = 0; $i < 11; $i++) {
            $count_month[] = end($count_month) + rand(1, 3);
        }
        for ($i = 1; $i <= 12; $i++){
            for ($j = 0; $j < $count_month[$i-1]; $j++){
                $counts[] = strval($i);
            }
        }
        shuffle($counts);
        $month = $counts[0];
        if (in_array($month, ['1', '3', '5', '7', '8', '10', '12'])){
            $day = strval(rand(1, 31));
        }elseif (in_array($month, ['4', '6', '9', '11'])){
            $day = strval(rand(1, 30));
        }else{
            $day = strval(rand(1, 28));
        }
        return $month."-".$day;
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
}
