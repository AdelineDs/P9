<?php
namespace AdelineD\OC\P9\View;

class View {

    // Name of the file associated with the view
    private $file;
    // Title of the view (defined in view file)
    private $title;

    public function __construct($action) {
        // determine the name of view file from the action
        $this->file = "View/view" . $action . ".php";
    }

    // generates and display view
    public function generate($data) {
        // Generation of the specific part of the view
        $content = $this->generateFile($this->file, $data);
        // generation of the template
        $view = $this->generateFile('View/Template.php.twig',
        array('title' => $this->title, 'content' => $content));
        // Return view
        echo $view;
    }

    // Generate a view file and return result
    private function generateFile($file, $data) {
        if (file_exists($file)) {
            // Makes $data elements accessible in the view
            extract($data);
            // Turn on output buffering
            ob_start();
            // Inclide view file
            // Its result is placed in the output buffer
            require $file;
            // Get current buffer contents
            return ob_get_clean();
        }
        else {
            throw new \Exception("Fichier '$file' introuvable");
        }
    }
}