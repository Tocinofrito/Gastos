<?php
require_once 'models/expensesmodel.php';
require_once 'models/categoriesmodel.php';
require_once 'classes/sessioncontroller.php';

class Dashboard extends SessionController{

    private $user;
    function __construct(){
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log('Dasboard::construct -> inicio de Login' );
    }
    //Funcion que llama a la vista dependiendo el controlador
    function render(){
        error_log('Dasboard::render -> Carga index Dashboard' );
        
        $expensesModel = new ExpensesModel();
        $expenses = $this->getExpenses(5);
        $totalThismonth = $expensesModel->getTotalAmountThisMonth($this->user->getId());
        $maxExpensesThisMonth = $expensesModel->getMaxExpensesThisMonth($this->user->getId());
        $categories = $this->getCategories();
        $this->view->render('dashboard/index',[
            'user' => $this->user,
            'expenses' => $expenses,
            'totalAmountThisMonth' => $totalThismonth,
            'maxExpensesThisMonth' => $maxExpensesThisMonth,
            'categories' => $categories
        ]);
        error_log($this->user->getName());
    }
    
    public function getExpenses($n = 0){
        if($n < 0){
            return NULL;
        }
        $expenses = new ExpensesModel();
        return $expenses->getByUserIdAndLimit($this->user->getId(), $n);
    }

    public function getCategories(){      
        $res = [];
        $categoriesModel = new CategoriesModel();
        $expensesModel = new ExpensesModel();

        $categories = $categoriesModel->getAll();

        foreach($categories as $category){
            $categoryArray = [];
            
            $total = $expensesModel->getTotalByCategoryThisMonth($category->getId, $this->user->getId());
            $numberOfExpenses = $expensesModel->getNumberOfExpensesByCategoryThisMonth($category->getId(), $this->user->getId());
            if($numberOfExpenses > 0){
                $categoryArray['total'] = $total;
                $categoryArray['count'] = $numberOfExpenses;
                $categoryArray['category'] = $category;
                array_push($res, $categoryArray);

            }
            
        }
        return $res;
    }

    

}