<?php

namespace App\Controller;

use App\Model\Order as OrderModel;

class Order extends AbstractController
{
    public function find(int $id)
    {
        $category_model = new OrderModel();

        return $category_model->find($id);
    }

    public function findALL()
    {
        $category_model = new OrderModel();

        return $category_model->findALL();
    }
    public function getAllInfo()
    {
        $category_model = new OrderModel();

        return $category_model->getAllInfo();
    }

}
?>