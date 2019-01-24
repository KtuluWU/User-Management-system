<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

error_reporting(E_ALL);

// API Services
/**
 * @Route("/service")
 */
class ServiceController extends Controller
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
     * @Route("/attach_user/action={action}&user_id={user_id}&seller_id={seller_id}", name="AttachUserToSeller", methods="POST")
     * @param Request $request
     * @param string $action
     * @param string $user_id
     * @param string $seller_id
     * @return JsonResponse
     */
    public function attach_user_to_seller(Request $request, string $action, string $user_id, string $seller_id){
        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserBy(['user_id' => $user_id]);
        if ($action === "engage"){
            $user->setResponsibleId($seller_id);
        }elseif($action === "dismiss"){
            $user->setResponsibleId(null);
        }else{
            return new JsonResponse(false);
        }
        $user_manager->updateUser($user);
        return new JsonResponse(true);
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
        if (substr($where_clause, 0, 4) === 'null'){
            $where_clause = '1 '.substr($where_clause, 4);
        }
        $sql .= " WHERE $where_clause";
        $count_sql .= " WHERE $where_clause";
        if ($field !== 'null'){
            $sql .= " ORDER BY $field";
        }
        if (strtolower($order) === "desc"){
            $sql .= " DESC";
        }
        if ($n_records != 'null'){
            $sql .= " LIMIT $n_records";
        }
        if ($n_page != 'null') {
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

    /**
     * @Route("/translate/pattern={pattern}", name="TranslationService", methods="GET")
     * @param Request $request
     * @param string $pattern
     * @return JsonResponse
     */
    public function translate(Request $request, string $pattern){
        $yaml = Yaml::parse(file_get_contents('../translations/ums.zh_CN.yaml'));
        $path = explode('.', $pattern);
        foreach($path as $part){
            $yaml = $yaml[$part];
        }
        return new JsonResponse($yaml);
    }

}
