<?php
class Page
{
    // Class Attribute
    public $content;
    public $menu;
    public $includes = array("Header" => "/includes/header.php", "Menu" => "/includes/menu.php", "Footer" => "/includes/footer.php");
    public $local = true;
    public $path = "";
    public $docRoot = "";

    // Class operations
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function Display()
    {
        $this->local = false;
        $this->path = $_SERVER['DOCUMENT_ROOT'];
        $this->docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

        if ($this->local == false) {
            $this->path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
            $this->docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
        }


        $this->DisplayHeaders();
        $this->DisplayMenu();
        echo $this->content;
        $this->DisplayFooter();
    }

    public function DisplayHeaders()
    {
        include($this->path . $this->includes["Header"]);
    }

    public function DisplayMenu()
    {
        include($this->path . $this->includes["Menu"]);
    }

    public function DisplayFooter()
    {
        include($this->path . $this->includes["Footer"]);
    }
}
