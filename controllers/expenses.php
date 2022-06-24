<?php
    require_once 'models/expensemodel.php';
    require_once 'models/categoriesmodel.php';

    class Expenses extends SessionController{

        
        private $user;

        function __construct() {
            parent::__construct();

             //Obtenemos info del usuario de la sesión actual
            $this->user = $this->getUserSessionData();
        }
       
        function render(){
            $this->view->render('expenses/index', [
                'user' => $this->user
            ]);
        }

        function newExpense(){
            if(!$this->existPost(['title', 'amount', 'category', 'date'])){
                $this->redirect('dashboard', []); //TODO: Error
                return;
            }
            if($this->user == NULL){
                $this->redirect('dashboard', []); //TODO:error
                return;

            }
            
            $expense = new ExpensesModel();
            $expense->setTitle($this->getPost('title'));
            $expense->setAmount((float)$this->getPost('amount'));
            $expense->setCategoryId($this->getPost('category'));
            $expense->setDate($this->getPost('date'));
            $expense->setUserId($this->user->getId());

            $expense->save();
            $this->redirect('dashboard', []); //TODO:success
        }

        //Aqui muestra la vista a dif de la anterior
        function create(){
            $categories = new CategoriesModel();
            $this->view->render('expenses/create', [
                'categories' => $categories->getAll(),
                'user' => $this->user
            ]);
        }

        function getCategoriesId(){
            $joinModel = new JoinExpensesCategoriesModel();
            $res = [];

            $categories = $joinModel->getAll($this->user->getId());

            foreach($categories as $cat){
                array_push($res, $cat->getCategoryId());

            }
            //array_values convierte el clave=> valor a solo valor
            //array_unique devuelve un array sin valores duplicados
            $res = array_values(array_unique($res));

            return $res;
        }

        private function getDateList(){
            $months = [];
            $res = [];

            $joinModel = new JoinExpensesCategoriesModel();
            $expenses = $joinModel->getAll($this->user->getId());

            foreach($expenses as $expense){
                array_push($months, substr($expense->getDate(), 0, 7));
            }
            $months = array_values(array_unique($months));

            
            if(count($months)>3){
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
            }
            return $res;
        }
        
        function getCategoryList(){
            $res = [];

            $joinModel = new JoinExpensesCategoriesModel();
            $expenses = $joinModel->getAll($this->user->getId());

            foreach($expenses as $expense){
                array_push($res, substr($expense->getNameCategory(), 0, 7));
            }
            $res = array_values(array_unique($res));

            return $res;
        }

        function getCategoryColorList(){
            $res = [];

            $joinModel = new JoinExpensesCategoriesModel();
            $expenses = $joinModel->getAll($this->user->getId());

            foreach($expenses as $expense){
                array_push($res, substr($expense->getColor(), 0, 7));
            }
            $res = array_unique($res);
            $res = array_values(array_unique($res));

            return $res;

        }

        function getHistoryJSON(){
        
            header('Content-Type: application/json');
            $res = [];
            $joinModel = new JoinExpensesCategoriesModel();
            $expenses = $joinModel->getAll($this->user->getId());
            foreach($expenses as $expense){
                array_push($res, substr($expense->toArray(), 0, 7));
            }

            echo json_encode($res);
        }

        function getExpensesJSON(){
            header('Content-Type: application/json');

            $res = [];
            $categoryIds = $this->getCategoriesId();
            $categoryNames = $this->getCategoryList();
            $categoryColors = $this->getCategoryColorList();

            array_unshift($categoryNames, 'mes');
            array_unshift($categoryColors, 'categories');
            
            $months = $this->getDateList();
            //Iteramos entre id y months 
            for ($i=0; $i < count($months); $i++){
                $item = array($months[$i]);
                for ($i=0; $i < count($categoryIds); $i++) { 
                    $total = $this->getTotalByMonthAndCategory($months[$i], $categoryIds[$j]);
                    array_push($item, $total);
                }
                array_push($res, $item);
                

            }
            array_unshift($res, $categoryNames);
            array_unshift($res, $categoryColors);

            echo json_encode($res);
        }
        private function getTotalByMonthAndCategory($date, $categoryId){
            $iduser = $this->user->getId();
            //$expenses = new ExpensesModel();
            //$total = $expenses->getTotalByMonthAndCategory($date, $categoryId, $iduser);
            $total = $this->model->getTotalByMonthAndCategory($date, $categoryId, $iduser);

            if($total == NULL){
                $total = 0;
            }
            return $total;
            
        }

        function delete($params){
            if($params == NULL){
                $this->redirect('expenses', []); //TODO: error

            }
            $id = $params[0];
            $res = $this->model->delete($id);
            
            if($res){
                $this->redirect('expenses', []); //TODO:success
            }else {
                $this->redirect('expenses', []); //TODO:error
            }
        }
       
    }
?>