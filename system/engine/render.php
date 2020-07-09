<?php
class Render{
    public function output($template, $data = null){
        $file = DIR_VIEW . $template . '.tpl';
 
        if (is_file($file)) {
            if($data != null) { extract($data); }

            require($file);
        }
    }

    public function load($template, $data = null) {
		$file = DIR_VIEW . $template . '.tpl';

		if (is_file($file)) {
			if($data != null) { extract($data); }

			ob_start();

			require($file);

			return ob_get_clean();
		}

	}	

}

