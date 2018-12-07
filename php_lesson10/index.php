
Инкапусяляция -  механимз с помощью которго  возможно объеденить данные и способы работы с ними в одном месте,
при этом изолировав их от внешнего вмешательстава.

Плюсы объектов в том что мы создаем его от  класса и у нас уже есть какие либо свойства и методы,
удобочитаемость кода, редактировние по классу(возможность изменить какито  метобы в классе
при это не переписывая весь код у каждого объекта.

Из минусов пока что увидел сложность осовения этого механизма
и в случае не умелого использования все плюсы лего превратить в минусы и еще обльшую кашу.



<?php

  class Basic
  {
      public $name;



  }



  interface Car
  {
      public getColor();

  }

  class Car extends Basic
  {

    public $name;
    public $color = 'white';
    public $year;
    public $price;

    public function getColor(): string
    {
      return $this->color;
    }

    public function setName($name)
    {
      $this->name = $name;
    }
  }

  $toyota = new Car();
  echo $toyota -> getColor();

  $subaru = new Car();
  $subaru->name = 'forester';
  $subaru->price = 500000;



  class Tv
  {
    public $name;
    public $size;
    public $price;

    public function getSize()
    {
      return $this->size;
    }

    public function getName()
    {
      return $this->name;
    }
  }

  $samsung = new Tv();
  $samsung ->price = 35000;

  $sony = new Tv();
  $sony->name = 'triluminus';


  class Pen
  {
    public $name;
    public $color;
    public $size;


    public function setColor($color)
    {
      $this->color = $color;
    }
  }

  $newPen = new Pen();
  $newPen->color = 'red';

  $anotherPen = new Pen();


  class Duck
  {
    public $name;
    public $kind;
    public $gender;


    public function setKind($kind)
    {
      $this->kind = $kind;
    }
  }
  $maleDuck = new Duck();
  $maleDuck->gender = 'famele';
  $fameleDuck = new Duck();



  class Product
  {
    public $name;
    public $price;
    public $category;
    public $discount;


    public function getPrice()
    {
      return $this->price;
    }

    public function setCategory($category)
    {
      $this->category = $category;
    }
  }

  $phone = new Product();
  $phone-> price = 20000;
  $phone -> category = 'smartphone';
  $phone -> name = 'samsung';

  $phone -> getPrice();

  $bread = new Product();
  $bread -> price = 25;
  $bread-> category = 'food';


