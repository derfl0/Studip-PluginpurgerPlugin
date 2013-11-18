<?php

class ShowController extends StudipController {

    public function before_filter(&$action, &$args) {

        $this->set_layout($GLOBALS['template_factory']->open('layouts/base_without_infobox'));
//		PageLayout::setTitle('');
    }

    public function index_action() {
        // gimme some mighty plugin manager
        $manager = PluginManager::getInstance();
        
        // find plugins that are in directory but not loaded
        foreach (glob("./plugins_packages/*", GLOB_ONLYDIR) as $filename) {
            $origin = basename($filename);
            foreach (glob("./plugins_packages/$origin/*", GLOB_ONLYDIR) as $filename) {
                $pluginname = basename($filename);
                $ini = parse_ini_file("./plugins_packages/$origin/$pluginname/plugin.manifest");
                // later i wanna move files
                //if ($origin != $ini['origin'] || $pluginname != $ini['pluginclassname'] || !$manager->getPlugin($ini['pluginclassname'])) {
                if (!$manager->getPlugin($ini['pluginclassname'])) {
                    if (Request::submitted('clean')) {
                        $manager->registerPlugin($ini['pluginname'], $ini['pluginclassname'], "$origin/$pluginname");
                    } else {
                    $this->purge['new'][] = $ini['pluginclassname'];
                    }
                }
            }
        }
    }

    // customized #url_for for plugins
    function url_for($to) {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map("urlencode", $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join("/", $args));
    }

}
