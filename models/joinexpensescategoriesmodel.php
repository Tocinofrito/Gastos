<?php

    class JoinExpensesCategoriesModel extends Model{

        private $expenseId;
        private $title;
        private $amount;
        private $categoryId;
        private $date;
        private $userId;
        private $nameCategory;
        private $color;

        public function __construct(){
            parent::__construct();
        }

        public function getAll($userid){
            $items = [];

            try {
                $query = $this->prepare('SELECT expenses.id as expense_ide, title, category_id, amount, date, id_user, categories.id, name, color FROM expenses INNER JOIN categories WHERE expenses.category_id = categories.id AND expenses.id_user = :userid ORDER BY date');
                $query->execute([
                    'userid' => $userid
                ]);
                while($p = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = new JoinExpensesCategoriesModel();
                    $item->from($p);
                    array_push($items, $item);
                }
                return $items;
            } catch (PDOException $e) {
                return NULL;
            }


        }

        public function from($array){
            $this->expenseId    = $array['expense_id'];
            $this->title        = $array['title'];
            $this->amount       = $array['amount'];
            $this->categoryId   = $array['category_id'];
            $this->date         = $array['date'];
            $this->userId       = $array['id_user'];
            $this->color        = $array['color'];
        }

        public function toArray() {

            $array = [];
            $array['id']            = $this->expenseId;
            $array['title']         = $this->title;
            $array['category_id']   = $this->categoryId;
            $array['amount']        = $this->amount;
            $array['date']          = $this->date;
            $array['id_user']       = $this->userId;
            $array['name']          = $this->nameCategory;
            $array['color']         = $this->color;
            return $array;
        }

        
        
        public function getExpenseId(){return $this->expenseId;}
        public function getTitle(){return $this->title;}
        public function getCategoryId(){return $this->categoryId;}
        public function getAmount(){return $this->amount;}
        public function getDate(){return $this->date;}
        public function getUserId(){return $this->userId;}
        public function getNameCategory(){return $this->nameCategory;}
        public function getColor(){return $this->color;}
    }
?>