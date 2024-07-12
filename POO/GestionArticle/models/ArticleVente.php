<?php

class ArticleVente extends Article{
    private string $date;

    public function __construct(){
        parent::__construct();
    }
    

	public function getDate(): string {
		return $this->date;
	}
	
	public function setDate(string $date) {
		$this->date = $date;
	}
}