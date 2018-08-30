<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/product", name = "Product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="ProductPage")
     */
    public function index(Request $request)
    {
        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $product_manager = $this->getDoctrine()->getManager();
            $product_id = $this->product_id_generator();
            $product->setProductId($product_id);
            $product->setProductName($data->getProductName());
            $product->setBarcode($data->getBarcode());
            $image = $form->get('image_path')->getData();
            $image_path = md5(uniqid()).'.'.$image->guessExtension();
            $product->setImagePath($image_path);
            $product->setCategory($data->getCategory());
            $product->setShelfLife($data->getShelfLife());
            $product->setPromotion($data->getPromotion());
            $product->setStock($data->getStock());
            $product->setDescription($data->getDescription());
            $product_manager->persist($product);
            $product_manager->flush();
            $image->move(
                $this->getParameter('upload_directory'),
                $image_path
            );
            unset($purchase);
            unset($form);
            $purchase = new Product();
            $form = $this->createForm(ProductType::class, $purchase);
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $products = $repository->findAll();
            $this->product_id_setter($product_id);
            return $this->render('product/index.html.twig',
                ['products' => $products,
                'form'=> $form->createView()]);
        }






        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        return $this->render('product/index.html.twig',
            ['products' => $products,
                'form'=> $form->createView()]);
    }

    /**
     * @Route("/delete/{product_id}&{page}", name = "ProductEdit")
     */
    public function product_delete($product_id, $page)
    {   $product_manager = $this->getDoctrine()->getManager();
        $product= $product_manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id));
        if ($product != null){
            $product_manager->remove($product);
            $product_manager->flush();
        }
        $image_path = $product->getImagePath();
        $original_image = $this->getParameter('upload_directory')."/".$image_path;
        if (file_exists($original_image)) {
            unlink($original_image);
        }

        return $this->redirectToRoute("ProductProductPage");
    }
    /**
     * @Route("/edit/{product_id}&{page}")
     */
    public function product_edit(Request $request, $product_id, $page)
    {
        $product_manager = $this->getDoctrine()->getManager();
        $product= $product_manager->getRepository(Product::class)->findOneBy(array('product_id' => $product_id));
        $product_form = new Product();
        $form = $this->createForm(ProductType::class,$product_form);
        $form->get('product_name')->setData($product->getProductName());
        $form->get('barcode')->setData($product->getBarcode());
        $form->get('category')->setData($product->getCategory());
        $form->get('shelf_life')->setData($product->getShelfLife());
        $form->get('promotion')->setData($product->getPromotion());
        $form->get('stock')->setData($product->getStock());
        $form->get('description')->setData($product->getDescription());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $product->setProductName($data->getProductName());
            $product->setBarcode($data->getBarcode());
            $product->setCategory($data->getCategory());
            $product->setShelfLife($data->getShelfLife());
            $product->setPromotion($data->getPromotion());
            $product->setStock($data->getStock());
            $product->setDescription($data->getDescription());


            //save new image
            $image_file = $form->get('image_path')->getData();
            $new_image_path = md5(uniqid()).'.'.$image_file->guessExtension();
            $image_file->move(
                $this->getParameter('upload_directory'),
                $new_image_path
            );
            //delete original image and save new image
            $image_path = $product->getImagePath();
            $original_image = $this->getParameter('upload_directory')."/".$image_path;
            if (file_exists($original_image)) {
                unlink($original_image);
            }
            $product->setImagePath($new_image_path);
            //update product
            $product_manager->persist($product);
            $product_manager->flush();

            return $this->redirectToRoute('ProductProductPage');
            }

        return $this->render('product/product_edit.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
            'image_path' => $product->getImagePath()
        ]);

    }


    private function product_id_generator()
    {
        $col_id_name = 'product_id';

        $em_users = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT $col_id_name FROM infos ORDER BY $col_id_name DESC LIMIT 1";

        $id_pre = $em_users->prepare($sql);
        $id_pre->execute();
        $id_last = $id_pre->fetchAll();

        if ( empty($id_last) || ($id_last[0][$col_id_name])=="")
        {
            $product_id = '1000000001';
        } else {
            $product_id = (int)$id_last[0][$col_id_name] + 1;
        }
        return (string)$product_id;
    }
    private function product_id_setter($product_id)
    {
        $em_users = $this->getDoctrine()->getManager()->getConnection();

        $sql_init = "SELECT * FROM infos LIMIT 1";
        $stm_init = $em_users->prepare($sql_init);
        $stm_init->execute();
        $db = $stm_init->fetchAll();

        if (empty($db)) {
            $sql_first = "INSERT INTO infos VALUES (0,'','','',0,0,0,'','','')";
            $stm_first = $em_users->prepare($sql_first);
            $stm_first->execute();
        }
        $col_id_name = 'product_id';

        $sql = "UPDATE infos SET $col_id_name = $product_id ";
        $stm = $em_users->prepare($sql);
        $stm->execute();
    }
}
