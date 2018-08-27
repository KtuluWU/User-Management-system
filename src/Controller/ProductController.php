<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="ProductPage")
     */
    public function index()
    {
        // TODO: 应该查找一页的数量0-20，点击下一页查找20-40？
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        return $this->render('product/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/new", name="AddNewProduct", methods="POST")
     */
    public function saveToDatabase(Request $request){
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $product = new Product();
                // TODO: validation
                $product->setProductId($params["product_id"]);
                $product->setProductName($params["product_name"]);
                $product->setBarcode($params["barcode"]);
                $product->setImagePath($params["image_path"]);
                $product->setCategory($params["category"]);
                $product->setShelfLife($params["shelf_life"]);
                $product->setPromotion($params["promotion"]);
                $product->setStock((int)$params["stock"]);
                $product->setDescription($params["description"]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

            }
            return new JsonResponse(array('data' => $params));
        }
    }
}
