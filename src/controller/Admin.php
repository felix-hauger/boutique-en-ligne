<?php

namespace App\Controller;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Product;
use App\Entity\Stock;
use App\Model\Category as CategoryModel;
use App\Model\Product as ProductModel;
use App\Model\Tag as TagModel;
use App\Model\ProductTag as ProductTagModel;
use App\Model\User as UserModel;

class Admin extends User
{
    public function addProduct(string $name, string $description, int $price, string $image, int $category_id, ?int $discount_id = null, array $tags, Stock $stock)
    {
        $args = func_get_args();

        $args_names = $this->getMethodArgNames(__CLASS__, __FUNCTION__);

        $test = array_combine($args_names, $args);

        // var_dump($test);

        $product = new Product();

        $product_model = new ProductModel();

        $tag_model = new TagModel();

        $product_tag_model = new ProductTagModel();

        $product->hydrate($test);

        // var_dump($product);

        return $product_model->create($product);

        // $product->set;

    }

    public function updateProduct()
    {

    }

    public function deleteProduct(int $id)
    {
    }

    public function addTagToProduct(int $product_id, int $tag_id)
    {
        $product_tag_model = new ProductTagModel();

        return $product_tag_model->create($product_id, $tag_id);
    }

    public function removeTagFromProduct(int $product_id, int $tag_id)
    {
        $product_tag_model = new ProductTagModel();

        return $product_tag_model->delete($product_id, $tag_id);
    }

    public function deleteUser(int $id)
    {
        $user_model = new UserModel();
        
        return $user_model->delete($id);
    }

    public function changeUserRole(int $role_id)
    {
        $user_model = new UserModel();
    }

    public function changeUserPassword(int $id, string $password)
    {
        $user_model = new UserModel();
    }

    public function addCategory(string $name, ?string $description = null)
    {
        $category_model = new CategoryModel();

        $category = new Category();

        $category
            ->setName($name)
            ->setDescription($description);

        return $category_model->create($category);
    }

    public function updateCategory()
    {

    }

    public function deleteCategory()
    {

    }

    public function addTag(string $name, ?string $description = null)
    {
        $tag_model = new TagModel();

        $tag = new Tag();

        $tag
            ->setName($name)
            ->setDescription($description);

        return $tag_model->create($tag);
    }

    public function updateTag()
    {

    }

    public function deleteTag()
    {

    }
}

// $admin = new Admin();

// $admin->addTagToProduct(32, 13);

// $name = 'name';
// $description = '$description';

// $admin->addTag($name, $description);
// $price = 50;
// $image = 'image';
// $category_id = 5;
// $tags = [];
// $stock = new Stock;

// $admin->addProduct($name, $description, $price, $image, $category_id, null ,$tags, $stock);