<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Yaml\Yaml;

error_reporting(E_ALL);

// API Services
/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/get_user_count", name="GetUserCount", methods="POST")
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
            ->andWhere('u.roles = :user_role')
            ->setParameter('starting_date', $starting_date, \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('now',new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('user_role', 'a:0:{}');
        $filtered_users = $qb->getQuery()->getResult();
        $qb_acc = $em->createQueryBuilder();
        $qb_acc->select('count(u.date_register)')
            ->from('App\Entity\User', 'u')
            ->where('u.date_register <= :starting_date')
            ->andWhere("u.roles = :user_role")
            ->setParameter('starting_date', $starting_date, \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('user_role', 'a:0:{}');
        $accumulated_user_count = $qb_acc->getQuery()->getResult();
        foreach ($filtered_users as &$user){
            $user = $user['date_register']->format('Y-m-d');
        }
        return [$filtered_users, $accumulated_user_count, $starting_date->format('Y-m-d')];
    }

    /**
     * @Route("/attach_user", name="AttachUserToSeller", methods="POST")
     */
    public function attach_user_to_seller(Request $request){
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $user_id = $params['user_id'];
                $seller_id = $params['seller_id'];
                $user_manager = $this->get('fos_user.user_manager');
                $user = $user_manager->findUserBy(['user_id' => $user_id]);
                $user->setResponsibleId($seller_id);

                $user_manager->updateUser($user);
                return true;
            }
        }
        return false;
    }

    /**
     * @Route("/get_general_list_with_count/table={table}&page={n_page}&orderedby={field}&order={order}&count={n_records}&where={where_clause}", name="GetGeneralList", methods="GET")
     * @param Request $request
     * @param string $table 表名
     * @param int $n_page 页数(从1开始)
     * @param string $field 排序的列
     * @param int $n_records 取记录的数量
     * @return JsonResponse Json记录
     */
    public function get_general_list_with_count(Request $request, string $table, int $n_page, string $field, string $order, int $n_records, string $where_clause){
        if (!$table){
            return null;
        }
        $sql = "SELECT * FROM $table";
        $count_sql = "SELECT count(*) FROM $table";
        if ($where_clause){
            $sql .= " WHERE $where_clause";
            $count_sql .= " WHERE $where_clause";
        }
        if ($field){
            $sql .= " ORDER BY $field";
        }
        if (strtolower($order) === "desc"){
            $sql .= " DESC";
        }
        if ($n_records){
            $sql .= " LIMIT $n_records";
        }
        if ($n_page) {
            $offset = ($n_page - 1) * $n_records;
            $sql .= " OFFSET $offset";
        }
        $db = $this->getDoctrine()->getManager()->getConnection();
        $sql_pre = $db->prepare($sql);
        $sql_pre->execute();
        $records = $sql_pre->fetchAll();

        $count_sql_pre = $db->prepare($count_sql);
        $count_sql_pre->execute();
        $record_count = $count_sql_pre->fetchAll()[0]['count(*)'];
        $info = ['record_count' => (int)$record_count,
                'list' => $records];
        return new JsonResponse(json_encode($info));
    }


    /**
     * @Route("/get_option_list/optionname={option_name}", name="GetOptionPossibleValue", methods="GET")
     * @param Request $request
     * @param string $option_name 取可能值的列
     * @return JsonResponse 可能值与翻译列表
     */
    public function get_option_list(Request $request, string $option_name){
        $yaml = Yaml::parse(file_get_contents('../translations/ums.zh_CN.yaml'));
        $path = explode('.', $option_name);
        foreach($path as $part){
            $yaml = $yaml[$part];
        }
        $filtered = array_filter(
            $yaml,
            function ($key){
                return is_numeric($key);
            },
            ARRAY_FILTER_USE_KEY
        );
        return new JsonResponse(json_encode($filtered));
    }

}
