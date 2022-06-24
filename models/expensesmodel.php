<?php

class expensesModel extends Model implements IModel{

    private $id;
    private $title;
    private $amount;
    private $categoryid;
    private $date;
    private $userid;

   public function setId($id){ $this->id = $id; }
   public function setTitle($title){ $this->title = $title; }
   public function setAmount($amount){ $this->amount = $amount; }
   public function setCategoryId($categoryid){ $this->categoryid = $categoryid; }
   public function setDate($date){ $this->date = $date; }
   public function setUserId($userid){ $this->userid = $userid; }

   public function getId(){ return $this->id; }
   public function getTitle(){ return $this->title; }
   public function getAmount(){ return $this->amount; }
   public function getCategoryId(){ return $this->categoryid; }
   public function getDate(){ return $this->date; }
   public function getUserId(){ return $this->userid; }

   public function __construct(){
        parent::__construct();
        
   }

    public function save(){
        try {
            $query = $this->prepare('INSERT INTO expenses (title, amount, category_id, date, id_user) VALUES(:title, :amount, :category, :d, :id, :user)');
            $query->execute([
                'title' => $this->title,
                'amount' => $this->amount,
                'category' => $this->category,
                'user' => $this->user,
                'd'      => $this->date
            ]);
            if($query->rowCount()){
                return true;
            }else{return false;}
        } catch (PDOException $e) {
            return false;
            //throw $th;
        }
    }
    public function getAll(){
        $items = [];
        try {
            $query = $this->query('SELECT * FROM expenses');
            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new ExpensesModel();
                $item->from($p);
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            return false;
            //throw $th;
        }
    }
    public function get($id){
        try {
            $query = $this->prepare('SELECT FROM expenses WHERE id = :id');
            $query->execute([
                'id' => $this->$id              
            ]);
            $expense = $query->fetch(PDO::FETCH_ASSOC);
            $this->from($expense);
            return $this;
            
        } catch (PDOException $e) {
            return false;
            //throw $th;
        }
    }
    public function delete($id){
        try {
            $query = $this->prepare('DELETE FROM expenses WHERE id = :id');
            $query->execute([
                'id' => $this->$id              
            ]);
            return true;
            
        } catch (PDOException $e) {
            return false;
            //throw $th;
        }
    }
    public function update(){
        try {
            $query = $this->prepare('UPDATE expenses SET title = :title, amount = :amount, category = :category, date = :d, id_user = :user WHERE id = :id');
            $query->execute([
                'title' => $this->title,
                'amount' => $this->amount,
                'category' => $this->category,
                'user' => $this->user,
                'd'      => $this->date,
                'id' => $this->id
            ]);
           if($query->rowCount()) return true;
           return false;
            
        } catch (PDOException $e) {
            return false;
            //throw $th;
        }
    }
    public function from($array){
        $this-> id = $array['id'];
        $this-> title = $array['title'];
        $this-> amount = $array['amount'];
        $this-> categoryid = $array['category_id'];
        $this-> date = $array['date'];
        $this-> userid = $array['id_user'];
    }

    public function getAllByUserID($userid){
        $items = [];
        try {
            $query = $this->prepare('SELECT FROM expenses WHERE id_user = :userid');
            $query->execute([
                'userid' => $userid              
            ]);
          while($p = $query->fetch(PDO::FETCH_ASSOC)){
            $item = new ExpensesModel();
            $item->from($p);
            array_push($items, $item);
          }
          return $items;
            
        } catch (PDOException $e) {
            return [];
            //throw $th;
        }
    }

    public function getByUserIdAndLimit($userid, $n){
        $items = [];
        try {
            $query = $this->prepare('SELECT * FROM expenses WHERE id_user = :userid ORDER BY expenses.date DESC LIMIT 0, :n');
            $query->execute([
                'userid' => $userid,
                'n' => $n              
            ]);
          while($p = $query->fetch(PDO::FETCH_ASSOC)){
            $item = new ExpensesModel();
            $item->from($p);
            array_push($items, $item);
          }
          return $items;
            
        } catch (PDOException $e) {
            return [];
            //throw $th;
        }
    }

    public function getTotalAmountThisMonth($userid){
        
        try {
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid ');
            $query->execute([
                'userid' => $userid,
                'year' => $year,
                'month' => $month              
            ]);
          $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
          //Regresa una sola celda
          if($total == NULL) $total =0;
          return $total;
            
        } catch (PDOException $e) {
            return NULL;
            //throw $th;
        }
    }

    public function getMaxExpensesThisMonth($userid){
        
        try {
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT MAX(amount) AS total FROM expenses WHERE YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid ');
            $query->execute([
                'userid' => $userid,
                'year' => $year,
                'month' => $month              
            ]);
          $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
          //Regresa una sola celda
          if($total == NULL) $total =0;
          return $total;
            
        } catch (PDOException $e) {
            return NULL;
            //throw $th;
        }
    }

    public function getTotalByCategoryThisMonth($categoryid, $userid){
        
        try {
            $total = 0;
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE category_id = :categoryid AND YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid ');
            $query->execute([
                'userid' => $userid,
                'year' => $year,
                'month' => $month,
                'categoryid' => $categoryid              
            ]);
          $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
          //Regresa una sola celda
          if($total == NULL) $total =0;
          return $total;
            
        } catch (PDOException $e) {
            return NULL;
            //throw $th;
        }
    }
    
    function getTotalByMonthAndCategory($date, $categoryId, $userid) {
        try {
            $total = 0;
            $year = substr($date, 0, 4);
            $month = substr($date, 5,7);

            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE category_id = :categoryid AND id_user = :user AND YEAR(date) = :year AND MONTH(date) = :month');
            $query->execute([
                'categoryid' => $categoryId,
                'userid' => $userId,
                'year' => $year,
                'month' => $month
            ]);

            if($query->rowCount() > 0) {
                $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            }else {
                return 0;
            }
           
            return $total;
        } catch (PDOException $e) {
            return NULL;
        }
    }

    public function getNumberOfExpensesByCategoryThisMonth($categoryid, $userid){
        
        try {
            $total = 0;
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT COUNT(amount) AS total FROM expenses WHERE category_id = :categoryid AND YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid ');
            $query->execute([
                'userid' => $userid,
                'year' => $year,
                'month' => $month,
                'categoryid' => $categoryid              
            ]);
          $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
          //Regresa una sola celda
          if($total == NULL) $total =0;
          return $total;
            
        } catch (PDOException $e) {
            return NULL;
            //throw $th;
        }
    }
    
}