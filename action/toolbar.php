<?php
/**
 * Cellbg Plugin table cell background color Functionality
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Pavel Kochman <kochi@centrum.cz>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * Class action_plugin_cellbg_toolbar
 */
class action_plugin_cellbg_toolbar extends DokuWiki_Action_Plugin {

    /**
     * Register event handlers.
     *
     * @param Doku_Event_Handler $controller The plugin controller
     */
    public function register(Doku_Event_Handler $controller) {
        if($this->getConf('toolbar_icon')) $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'insert_toolbar_button', array ());
    }

    /**
     * Inserts the cellbg toolbar button
     */
    function insert_toolbar_button(Doku_Event &$event, $param) {
      $defaultColors = array( 'Yellow'    => 'yellow',
                              'Red'       => 'red',
                              'Orange'    => 'orange',
                              'Salmon'    => 'salmon',
                              'Pink'      => 'pink',
                              'Plum'      => 'plum',
                              'Purple'    => 'purple',
                              'Fuchsia'   => 'fuchsia',
                              'Silver'    => 'silver',
                              'Aqua'      => 'aqua',
                              'Teal'      => 'teal',
                              'Cornflower'=> '#6495ed',
                              'Sky Blue'  => 'skyblue',
                              'Aquamarine'=> 'aquamarine',
                              'Pale Green'=> 'palegreen',
                              'Lime'      => 'lime',
                              'Green'     => 'green',
                              'Olive'     => 'olive'
                            );
      $custom_colors = array();
      if($this->getConf('custom_colors'))
      {
          $custom_colors_lines = explode(DOKU_LF, $this->getConf('custom_colors'));
          foreach ($custom_colors_lines as $line) {
              list($colerName, $color) = explode('=', $line);
              $custom_colors[$colerName] = $color;
          }
      }
      $event->data[] = array (
          'type' => 'CellbgPicker',
          'title' => $this->getLang('toolbar_icon'),
          'icon' => '../../plugins/cellbg/images/cellbg-toolbar.png',
          'open' => '@#',
          'colorlist' => array_merge($defaultColors, $custom_colors),
          'sample' => 'RRGGBB',
          'close' => ':'
        );
    }
}