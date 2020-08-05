<?php

class Book 
{
    private $id;
    private $title;
    private $price;
    private $qty;
    
    function __construct($id, $title, $price) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }
    
    //setters
    function setId($id) { $this->id = $id;} 
    function setTitle($title) { $this->title = $title;}
    function setPrice($price) { $this-> price = $price;}
    
    //getters
    function getId() { return $this->id;} 
    function getTitle() { return $this->title;}
    function getPrice() { return $this->price;}
    
    // add number of copies
    function addCopies($qty)
    {
        $this->qty = $qty;
    }
    
    public static function get_all_boring_books()
    {
        $books = array();
        $bookList = new SplFileObject("./Contents/BookList.txt");
            foreach ($bookList as $book)
             {
                preg_match("@[A-Z]{2}\d{4}@", $book, $code);

                preg_match("@[a-zA-Z \-,\&\:]{5,100}[a-zA-Z \-,\&\:0-9]{5,100}@", $book, $title);

                preg_match('@(\$\d+(\.\d{1,2})?)|(Free!)@', $book, $price);
                
                $realPrice = $price[0] !== "Free!" ? $price[0] : 0;
                
                $b = new Book($code[0], $title[0], str_replace("$", "", $realPrice));
                array_push($books, $b);
                
            }
        return $books;
    }
    
    public static function compare_title ($a, $b)
    {
        if ($a->title == $b->title) { return 0;}
        return ($a->title < $b->title) ? -1 : 1;
    }
    
    public static function compare_price ($a, $b)
    {
        if ($a->price == $b->price) { return 0;}
        return ($a->price < $b->price) ? -1 : 1;
    }
    
    public static function find_book_by_id($id = "")
    {
        if(!empty($id))
        {
            $books = self::get_all_boring_books();
            foreach($books as $book)
            {
                if($book->getId() === $id) { return $book; }
            }
        }
        
        return false;
    }
}


class BookFile extends SplFileObject {
    public function __construct($filepath) {
        parent::__construct($filepath);  
    }
    
    
}
