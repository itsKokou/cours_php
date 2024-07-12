<?php 
class Professeur extends Personne{
   private string $grade; 

   public function __construct()
   {
      //super() ==> parent
       parent::__construct();
   }

   /**
    * Get the value of grade
    */ 
   public function getGrade()
   {
      return $this->grade;
   }

   /**
    * Set the value of grade
    *
    * @return  self
    */ 
   public function setGrade($grade)
   {
      $this->grade = $grade;

      return $this;
   }
   //@override
   public function __toString()
   {
      return parent::__toString() ." Grade :".$this->grade;
   }
}