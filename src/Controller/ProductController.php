<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;



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
     * @Route("/register", name="AddNewProduct")
     */
    public function saveToDatabase(Request $request){
        $product= new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product_id = $product->getProductId();
            $product_name = $product->getProductName();
            $barcode = $product->getBarcode();
            $image_path = $product->getImagePath();
            $category = $product->getCategory();
            $shelf_life = $product->getShelfLife();
            $promotion = $product->getPromotion();
            $stock = $product->getStock();
            $description = $product->getDescription();

            $product_manager = $this->getDoctrine()->getManager();
            $product_confirmation = $product_manager->getRepository(Product::class)->findBy(array('product_id' => $product_id));

            if (null == $product_confirmation) {
                $product->setProductId($product_id);
                $product->setProductName($product_name);
                $product->setBarcode($barcode);
                $product->setImagePath($image_path);
                $product->setCategory($category);
                $product->setShelfLife($shelf_life);
                $product->setPromotion($promotion);
                $product->setStock($stock);
                $product->setDescription($description);
                $product_manager->persist($product);
                $product_manager->flush();
            }

            else {
                return new Response("product exists!!!");;
            }
        }

        return $this->render('product/product_register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
