<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndexCreate extends Dungeon_Controller
{
    protected $_dungeon;
    protected $templates_media;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['Dungeon_model']);
        $this->_dungeon = new Dungeon_model();
    }
    // MAP
    public function map()
    {
        $data = [];
        $Emap = 0;
        if (!empty($_GET['Emap'])) $Emap = $_GET['Emap'];
        $data['icon_map'] = $icon_map = scandir('public/dungeon/images/map/background');
        $data['map_all'] = $map_all = $this->_dungeon->getData('*', 'dungeon_map', []);
        $data['map'] = $map = $data['map_all'][$Emap];
        if (!empty($_POST['selectTile']) && !empty($_POST['change'])) {
            $name = substr($icon_map[$_POST['change']], 0, strpos($icon_map[$_POST['change']], '.'));
            $listBackground    = json_decode($map['background']);
            $listinBackground    = json_decode($map['inbackground']);
            //
            foreach ($_POST['selectTile'] as $k => $v) {
                $v = $v - 1;
                $listBackground[$v] = $name;
            }
            $listBackground = json_encode($listBackground);
            $this->_dungeon->updateData('dungeon_map', ['id' => $map['id']], ['background' => $listBackground]);
            //
            $data['map_all'] = $map_all = $this->_dungeon->getData('*', 'dungeon_map', []);
            $data['map'] = $map = $data['map_all'][$Emap];
        };
        if (!empty($_POST['submit'])) {
            unset($_POST['submit']);
            if (!empty($_POST['id'])) $id = $_POST['id'];
            unset($_POST['id']);
            $check = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $id]);
            if (count($check) > 0) {
                if (!empty($_POST['newmap'])) {
                    unset($_POST['newmap']);
                    $_POST['background'] = '["';
                    $background = [];
                    for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                        $background[] = $_POST['z'];
                    };
                    $_POST['background'] .= implode('","', $background);
                    $_POST['background'] .= '"]';
                    //
                    $_POST['inbackground'] = '[';
                    $background = [];
                    for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                        $background[] = '0';
                    };
                    $_POST['inbackground'] .= implode(',', $background);
                    $_POST['inbackground'] .= ',0]';
                }
                $this->_dungeon->updateData('dungeon_map', ['id' => $id], $_POST);
                redirect(base_url('create/map?Emap=' . $_GET['Emap']));
            } else {
                $_POST['background'] = '["';
                $background = [];
                for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                    $background[] = $_POST['z'];
                };
                $_POST['background'] .= implode('","', $background);
                $_POST['background'] .= '"]';
                //
                $_POST['inbackground'] = '[';
                $background = [];
                for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                    $background[] = '0';
                };
                $_POST['inbackground'] .= implode(',', $background);
                $_POST['inbackground'] .= ',0]';
                $this->_dungeon->inserData('dungeon_map', $_POST);
                redirect(base_url('create/map?Emap=' . $_GET['Emap']));
            };
        }
        $view = 'default/create/map';
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/create/layout', $data);
    }

    public function mapbg()
    {
        $data = [];
        $Emap = 0;
        if (!empty($_GET['Emap'])) $Emap = $_GET['Emap'];
        $data['icon_map'] = $icon_map = scandir('public/dungeon/images/map/inbackground');
        $data['map_all'] = $map_all = $this->_dungeon->getData('*', 'dungeon_map', []);
        $data['map'] = $map = $data['map_all'][$Emap];
        if (!empty($_POST['selectTile']) && !empty($_POST['change'])) {
            $name = substr($icon_map[$_POST['change']], 0, strpos($icon_map[$_POST['change']], '.'));
            $listinBackground    = json_decode($map['inbackground']);
            //
            foreach ($_POST['selectTile'] as $k => $v) {
                $v = $v - 1;
                $listinBackground[$v] = $name;
            }
            $listinBackground = json_encode($listinBackground);
            $this->_dungeon->updateData('dungeon_map', ['id' => $map['id']], ['inbackground' => $listinBackground]);
            //
            $data['map_all'] = $map_all = $this->_dungeon->getData('*', 'dungeon_map', []);
            $data['map'] = $map = $data['map_all'][$Emap];
        };
        if (!empty($_POST['submit'])) {
            unset($_POST['submit']);
            if (!empty($_POST['id'])) $id = $_POST['id'];
            unset($_POST['id']);
            $check = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $id]);
            if (count($check) > 0) {
                if (!empty($_POST['newmap'])) {
                    unset($_POST['newmap']);
                    $_POST['inbackground'] = '["';
                    $background = [];
                    for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                        $background[] = $_POST['z'];
                    };
                    $_POST['inbackground'] .= implode('","', $background);
                    $_POST['inbackground'] .= '"]';
                    //
                    $_POST['inbackground'] = '[';
                    $background = [];
                    for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                        $background[] = '0';
                    };
                    $_POST['inbackground'] .= implode(',', $background);
                    $_POST['inbackground'] .= ',0]';
                }
                $this->_dungeon->updateData('dungeon_map', ['id' => $id], $_POST);
                redirect(base_url('create/mapbg?Emap=' . $_GET['Emap']));
            } else {
                $_POST['inbackground'] = '["';
                $background = [];
                for ($i = 0; $i < ($_POST['x'] * $_POST['y']); $i++) {
                    $background[] = $_POST['z'];
                };
                $_POST['inbackground'] .= implode('","', $background);
                $_POST['inbackground'] .= '"]';
                $this->_dungeon->inserData('dungeon_map', $_POST);
                redirect(base_url('create/mapbg?Emap=' . $_GET['Emap']));
            };
        }
        $view = 'default/create/mapbg';
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/create/layout', $data);
    }

    public function image()
    {
        switch ($_GET['type']) {
            case 'auto-resize':
                if (!empty($_POST['butt'])) {
                    $url_img = base_url('public/image/' . $_POST['img']);
                    $width = '32';
                    $height = '32';
                    $this->crop($url_img, $_POST['folder'], $_POST['key'], $width, $height);
                };
                $data['icon_map'] = $icon_map = scandir('public/image');
                $view = 'default/create/image';
                $data['main'] = $this->load->view($view, $data, true);
                $this->load->view('default/create/layout', $data);
                break;

            default:
                # code...
                break;
        }
    }
    // END MAP
    // ITEM
    public function item()
    {
        // SET
        $view = 'default/create/item';
        $data = [];
        $param = [];
        if (!empty($_GET['type'])) $param['type'] = $_GET['type'];
        // GET ITEM
        $data['item_all'] = $item_all = $this->_dungeon->getData('*', 'dungeon_items', $param);
        // GET FIELDS
        $fields = $this->db->field_data('dungeon_items');
        $fields = $this->array_group_by($fields, function ($a) {
            return $a->name;
        });
        $data['tbkey'] = $key = array_flip(array_keys($fields));
        // SET
        if (!empty($_POST['data_update'])) {
            $_POST['data_update'] = json_encode($_POST['data_update']);
        };
        if (!empty($_POST['equipment_rule'])) {
            $_POST['equipment_rule'] = json_encode($_POST['equipment_rule']);
        };
        // ACTIVE
        if (!empty($_POST['add'])) {
            unset($_POST['id']);
            unset($_POST['add']);
            $this->_dungeon->inserData('dungeon_items', $_POST);
            redirect(base_url(uri_string()) . '?' . $_SERVER['QUERY_STRING']);
        };
        if (!empty($_POST['edit'])) {
            $whe_id = $_POST['id'];
            unset($_POST['id']);
            unset($_POST['edit']);
            $this->_dungeon->updateData('dungeon_items', ['id' => $whe_id], $_POST);
            redirect(base_url(uri_string()) . '?' . $_SERVER['QUERY_STRING']);
        };
        if (!empty($_POST['delete'])) {
            $whe_id = $_POST['id'];
            $this->_dungeon->delete('dungeon_items', $whe_id);
            redirect(base_url(uri_string()) . '?' . $_SERVER['QUERY_STRING']);
        };
        //VIEW
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/create/layout', $data);
    }
    // END ITEM
    private function crop($url, $folder, $key, $thumb_width, $thumb_height)
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        };
        $image = imagecreatefrompng($url);
        $width = imagesx($image);
        $height = imagesy($image);

        $count = 0;
        for ($x = 0; $x < ($width / $thumb_width); $x++) {
            for ($y = 0; $y < ($height / $thumb_height); $y++) {
                $count++;
                $p_x = $x * $thumb_width;
                $p_y = $y * $thumb_height;
                $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                // Resize and crop
                imagecopyresampled(
                    $thumb,
                    $image,
                    0,
                    0,
                    $p_x,
                    $p_y,
                    $thumb_width,
                    $thumb_height,
                    $thumb_width,
                    $thumb_height
                );
                imagepng($thumb, $folder . $key . $count . '.png', 9);
            };
        };
    }
}
