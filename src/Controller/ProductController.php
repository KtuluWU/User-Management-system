<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="ProductPage")
     */
    public function product_show(Request $request)
    {
        $product = new Product();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $repository = $em->getRepository(Product::class);
        $product_list = $repository->findAll();
        $product_existance = true;

        if ($form->isSubmitted() && $form->isValid()) {
            $product_id = $product->getProductId();
            $product_name = $product->getProductName();
            $barcode = $product->getBarcode();
            $category = $product->getCategory();
            $shelf_life = $product->getShelfLife();
            $promotion = $product->getPromotion();
            $stock = $product->getStock();
            $description = $product->getDescription();

            if($product_id == '') {
                $product->setProductId($this->generate_product_id());
                $product->setProductName($product_name);
                $product->setBarcode($barcode);
                $image = $form->get('image_path')->getData();
                if($image === null or $image === '') {
                    $image_path="example.jpg";
                }
                else{
                    $image_path = md5(file_get_contents($image)).'.'.$image->guessExtension();
                    $image->move(
                        $this->getParameter('uploads_images_products'),
                        $image_path
                    );
                }
                $product->setImagePath($image_path);
                $product->setCategory($category);
                $product->setShelfLife($shelf_life);
                $product->setPromotion($promotion);
                $product->setStock($stock);
                $product->setDescription($description);
                $product->setImagePath($image_path);
                $em->persist($product);
                $em->flush();

                return $this->redirectToRoute('ProductPage');
            }else{
                $product = $em->getRepository(Product::class)->findBy(['product_id' => $product_id])[0];
                $product_existance = $product != null;

                if (!$product_existance) {
                    return $this->render('product/index.html.twig', [
                        'products' => $product_list,
                        'form' => $form->createView(),
                        'product_existance' => $product_existance]);
                } else {
                    $product->setProductName($product_name);
                    $product->setBarcode($barcode);
                    $image = $form->get('image_path')->getData();
                    if($image) {
                        $image_path = md5(file_get_contents($image)).'.'.$image->guessExtension();
                        $image->move(
                            $this->getParameter('uploads_images_products'),
                            $image_path
                        );
                        $product->setImagePath($image_path);
                    }
                    $product->setCategory($category);
                    $product->setShelfLife($shelf_life);
                    $product->setPromotion($promotion);
                    $product->setStock($stock);
                    $product->setDescription($description);
                    $em->persist($product);
                    $em->flush();

                    return $this->redirectToRoute('ProductPage');
                }
            }
        }
        return $this->render('product/index.html.twig', [
            'products' => $product_list,
            'form' => $form->createView(),
            'product_existance' => $product_existance]);
    }


    /**
     * @Route("/modify", name="ProductModifyPage", methods="POST")
     */
    public function product_modify(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $product_id = $params['product_id'];
                $em = $this->getDoctrine()->getManager();
                $product = $em->getRepository(Product::class)->findBy(['product_id' => $product_id])[0];
            }
            return new JsonResponse([
                'product_id' => $product_id,
                'product_name' => $product->getProductName(),
                'barcode' => $product->getBarcode(),
                'image_path' => $product->getImagePath(),
                'category' => $product->getCategory(),
                'shelf_life' => $product->getShelfLife(),
                'promotion' => $product->getPromotion(),
                'stock' => $product->getStock(),
                'description' => $product->getDescription()
            ]);
        }
    }

    /**
     * @Route("/remove", name="ProductRemovePage", methods="POST")
     */
    public function product_remove(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $content = $request->getContent();
            if (!empty($content)){
                $params = json_decode($content, true);
                $product_id = $params['product_id'];
                $em = $this->getDoctrine()->getManager();
                $product = $em->getRepository(Product::class)->findBy(['product_id' => $product_id])[0];
                $em->remove($product);
                $em->flush();
            }
        }
    }

    private function generate_product_id(){
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT product_id FROM infos";
        $id_pre = $conn->prepare($sql);
        $id_pre->execute();
        $product_id_last = $id_pre->fetchAll()[0]["product_id"];
        if ( empty($product_id_last) || ($product_id_last) === '') {
            $product_id = str_pad("1", 10, "0", STR_PAD_LEFT);
        }else{
            $product_id = str_pad((int) $product_id_last+1, 10, "0", STR_PAD_LEFT);
        }
        $conn->prepare("UPDATE infos SET product_id = $product_id")->execute();
        return $product_id;
    }
}
