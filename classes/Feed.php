<?php
  class Feed {
    private $id;
    private $title;
    private $link;
    private $description;
    private $href;

    public function getId() {
      return $this->id;
    }

    public function getTitle() {
      return $this->title;
    }

    public function getLink() {
      return $this->link;
    }

    public function getDescription() {
      return $this->description;
    }

    public function getHref() {
      return $this->href;
    }

    //////////////////////////

    public function setId($id) {
      $this->id = $id;
    }

    public function setTitle($title) {
      $this->title = $title;
    }

    public function setLink($link) {
      $this->link = $link;
    }

    public function setDescription($description) {
      $this->description = $description;
    }

    public function setHref($href) {
      $this->href = $href;
    }
  }
?>
