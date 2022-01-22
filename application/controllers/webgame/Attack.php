<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attack extends Dungeon_Controller
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

    public function index($key)
    {
        $this->___checkEmpty($_SESSION['heroes']);
        $data = array_merge([], $this->___root);
        $result = '';
        $view = 'default/public/dungeon/index2';
        if (empty($_SESSION['message'])) $_SESSION['message'] = '';
        if (isset($_SESSION['users'])) {
            $data['users'] = $users = $_SESSION['users'];
            $data['udungeon'] = $udungeon = $_SESSION['heroes'];
            if (!empty($udungeon)) {
                $data['home'] = true;
                $view = 'default/public/dungeon/attack';
                // ===================== 
                $data['hmap'] = $hmap = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map'], 'where' => $key])[0];
                if (empty($hmap)) redirect(base_url('dungeon'));
                $data['spells_list'] = $spells_list =  $this->_dungeon->getData('*', 'dungeon_uspells', ['user' => $_SESSION['heroes']['id']]);
                $listItem  = $this->_dungeon->getData('*', 'dungeon_uitems', ["user"=>$udungeon['id'], "type"=>"potion"]);
                if (!empty($listItem)) $listItem = $this->array_group_by($listItem, function ($a) {
                    return $a['title'];
                });
                $data['listItem'] = $listItem;
                if (empty($_POST['attack'])) {
                    $udungeon['username'] = $users['username'];
                    $stamina = [
                        'where' => [
                            'users' => $users['id']
                        ],
                        'update' => [
                            'stamina' => ($_SESSION['heroes']['stamina'] - 1)
                        ]
                    ];
                    $this->_dungeon->updData('dungeon_uheroes', $stamina['update'], $stamina['where']);
                    $_SESSION['heroes']['stamina'] = $stamina['update']['stamina'];

                    $message = $this->attack_action($this->bonus($udungeon), $hmap, $users['id'], $key);
                    if (!empty($message['users'])) $data['udungeon'] = $message['users'];
                    if (!empty($message['monster'])) $data['hmap'] = $message['monster'];
                    if (!empty($message['mes'])) $_SESSION['message'] = $message['mes'] . $_SESSION['message'];
                    if (!empty($message['rs'])) $data['rs'] = 1;
                    $data['result'] = $message;
                }
            } else {
                redirect(base_url('dungeon/account/register'));
            }
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }
    
    private function attack_action($users, $monster, $id, $db)
    {
        $data['users']      =   $users  =   (object) $users;
        $data['map']        =    1;
        $data['where']      =    $users->x;
        $data['monster']    =   $monster =   (object) $monster;
        $message = '';
        $result = '';
        if (empty($monster)) redirect(base_url('dungeon'));
        if (!empty($this->input->post())) {
            $message            =    $this->input->post('message');
            $total_dam_user = 0;
            $total_dam_monster = 0;
            $spells_damem = 0;
            $spells_dame = 0;
            if (!empty($_POST['spell'])) {
                $spells = $this->_dungeon->getData('*', 'dungeon_uspells', ['id' => $_POST['spell']])[0];
                $spells['data_update'] = json_decode($spells['data_update']);
            }
            if (!empty($monster->spells) && $monster->spells != 0) {
                $spells_monster = $this->_dungeon->getData('*', 'dungeon_spells', ['id' => $monster->spells])[0];
                $spells_monster['data_update'] = json_decode($spells_monster['data_update']);
            }
            for ($i = 0; $i < 2; $i++) {
                $_SESSION['message'] = '';
                if ($users->health > 0 && $monster->health > 0) {
                    $message    .= "<br/>{$users->username} bắt đầu tấn công {$monster->name}";
                    $message    .= "<br/>Lượt của {$users->username}";
                    $dex_rand = rand(0, $monster->dexterity);
                    if ($dex_rand <= $users->dexterity) {
                        $match_dame = $users->strength + $users->damage;
                        $match_max_dame = $users->strength + $users->maxdamage;
                        $u_dame = rand($match_dame, $match_max_dame);
                        $st_dame = $u_dame - $monster->armor;
                        if ($st_dame <= 0) $st_dame = 0;
                        $message    .= "<br/>{$users->username} tấn công {$monster->name} được {$st_dame} sát thương";
                        $spells_dame = 0;
                        if (!empty($_POST['spell']) && $users->mana > 0) {
                            $match_dame = $users->wisdom + $spells['data_update']->damage;
                            $match_max_dame = $users->wisdom + $spells['data_update']->maxdamage;
                            $u_dame = rand($match_dame, $match_max_dame);
                            $spells_dame = $u_dame;
                            $lost_mana = ($users->mana - $spells['lost_mana']);
                            if ($lost_mana <= 0) $lost_mana = 0;
                            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $users->id], 'update' => ['mana' => $lost_mana]]);
                            $_SESSION['heroes']['mana'] = $lost_mana;
                            $message    .= "<br/>{$users->username} sử dụng phép " . $spells['title'] . " gây {$spells_dame} sát thương";
                        }

                        $total_dam_user = $total_dam_user + $st_dame + $spells_dame;
                        $mon_hp = $monster->health = $monster->health - $st_dame - $spells_dame;
                        if ($mon_hp < 0) $mon_hp = $monster->health = 0;
                        $this->_dungeon->update('dungeon_hmap', ['where' => ['id' => $monster->id], 'update' => ['health' => $mon_hp]]);
                    } else {
                        $message    .= "<br/>{$users->username} không theo kịp. {$monster->name} nhanh quá";
                    }
                    /**/
                    $message    .= "<br/>Lượt của {$monster->name}";
                    
                    $dex_rand = rand(0, $users->dexterity);
                    if ($dex_rand <= ($monster->dexterity)) {
                        $match_dame = $monster->strength + $monster->damage;
                        $match_max_dame = $monster->strength + $monster->maxdamage;
                        $m_dame = rand($match_dame, $match_max_dame);
                        $st_dame = $m_dame - $users->armor;
                        if ($st_dame <= 0) $st_dame = rand(0, 1);
                        if (!empty($monster->spells) && $monster->spells != 0) {
                            $match_dame = $monster->wisdom + $spells_monster['data_update']->damage;
                            $match_max_dame = $monster->wisdom + $spells_monster['data_update']->maxdamage;
                            $m_dame = rand($match_dame, $match_max_dame);
                            $spells_damem = $m_dame;
                            $message    .= "<br/>{$monster->name} sử dụng phép " . $spells_monster['title'] . " gây {$spells_damem} sát thương";
                        }

                        $total_dam_monster = $total_dam_monster + $st_dame + $spells_damem;
                        $use_hp = $users->health = $users->health - $st_dame - $spells_damem;
                        if ($use_hp < 0) $use_hp = $users->health = 0;
                        $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $users->id], 'update' => ['health' => $use_hp]]);
                        $_SESSION['heroes']['health'] = $use_hp;
                        $message    .= "<br/>{$monster->name} tấn công {$users->username} được {$st_dame} sát thương";
                    } else {
                        $message    .= "<br/>{$monster->name} không theo kịp. {$users->username} nhanh quá";
                    }
                };
                $result = [
                    'users' => (array) $users,
                    'monster' => (array) $monster,
                    'mes' => $message
                ];
                if ($monster->health <= 0) {
                    $message    = "{$users->username} Chiến thắng";
                    $this->_dungeon->delete('dungeon_hmap', $monster->id);
                    $_SESSION['heroes']['x'] = $db;
                    if (!empty($_SESSION['mode_Experian'])) $_SESSION['heroes']['exp'] = ($users->exp + ($monster->exp * 2));
                    if (empty($_SESSION['mode_Experian'])) $_SESSION['heroes']['exp'] = ($users->exp + $monster->exp);
                    $this->_dungeon->updData('dungeon_uheroes', $_SESSION['heroes'], ['users' => $id]);
                    $item = $this->_dungeon->getData('*', 'dungeon_uitems', ['user' => $users->id, 'equip' => '0']);
                    if (count($item) < $_SESSION['heroes']['max_inventory']) {
                        $rsitem = $this->getitems($users, $monster);
                        $i = 3;
                        $message    .= "<br>Nhận được: " . colorStar($rsitem);
                    } else {
                        $message    .= "<br>Túi đã đầy. không thể nhặt thêm vật phẩm";
                    };
                    $result = [
                        'users' => (array) $users,
                        'mes' => $message,
                        'rs' => 1
                    ];
                    $_SESSION['message'] = '';
                };
                if ($users->health <= 0) {
                    $time_die = time() + 10;
                    $query = [
                        'mana' => 0,
                        'time_die' => $time_die
                    ];
                    $this->_dungeon->updData('dungeon_uheroes', $query, ['users' => $id]);
                    $_SESSION['heroes']['mana'] = 0;
                    $_SESSION['heroes']['time_die'] = $time_die;
                    $message    = "{$monster->name} Chiến thắng";
                    $result = [
                        'rs' => 2
                    ];
                    $_SESSION['message'] = '';
                };
                if ($users->health <= 0) redirect(base_url('dungeon'));
            }
            if (($monster->health > 0) && ($users->health > 0)) {
                if ($total_dam_user > $total_dam_monster) {
                    $result['row_result']    = "{$users->username} Chiến thắng";
                    $result['row_dam_user']    = "{$users->username} - $total_dam_user";
                    $result['row_dam_monster']    = "{$monster->name} - $total_dam_monster";
                    $result['row_experience'] = ceil($monster->exp / 2);
                    $result['row_pox'] = '50%';
                    if ($monster->level == 10) {
                        $result['row_experience'] = $monster->exp;
                        $result['row_pox'] = '100%';
                    }
                    if (!empty($_SESSION['mode_Experian'])) {
                        $result['row_experience'] = $monster->exp * 2;
                        $result['row_pox'] = '200%';
                    }
                    $newxp = ($users->exp + $result['row_experience']);

                    $this->_dungeon->updData('dungeon_uheroes', ['exp' => $newxp], ['users' => $id]);
                    $_SESSION['heroes']['exp'] = $newxp;
                } else {
                    $result['row_result']    = "{$users->username} Thất bại";
                    $result['row_dam_user']    = "{$users->username} - $total_dam_user";
                    $result['row_dam_monster']    = "{$monster->name} - $total_dam_monster";
                }
            };
            $result['total_dam_user'] = $total_dam_user;
            $result['total_dam_monster'] = $total_dam_monster;
        }
        return $result;
    }
    
    private function getitems($users, $monster)
    {
        $item = $this->_dungeon->randomItem($users, $monster);
        if(!empty($item) && !empty($item[0])){
            $item = $item[0];
        } else return null;
        unset($item['id']);
        unset($item['status']);
        $item['user'] = $users->id;
        $title = $this->_dungeon->randomTitle($item, $monster);
        if(!empty($title[0])) $title = $title[0];
        if (!empty($item['type']) && ($item['type'] != 'potion' && $item['type'] != 'quest' && !empty($title)) && ($title['type'] == 1 || $title['type'] == 2)) {
            $item['data_update'] = json_decode($item['data_update'], true);
            if ($title['type'] == 1) $item['title'] = $item['title'] . ' ' . $title['title'];
            if ($title['type'] == 2) $item['title'] = $title['title'] . ' ' . $item['title'];
            if (!empty(json_decode($title['data_update'])) && ($title['type'] == 1 || $title['type'] == 2)) foreach (json_decode($title['data_update']) as $key => $vl) {
                if (!empty($item['data_update'][$key])) {
                    $item['data_update'][$key] = $item['data_update'][$key] +  $vl;
                } else {
                    $item['data_update'][$key] = $vl;
                }
            };
            $item['data_update'] = json_encode($item['data_update']);
            $item['gold'] = $item['gold'] + $title['gold'];
            if ((($item['type'] != "ring") && ($item['type'] != "amulet"))) $item = $this->staritems($item);
            //$item = $this->staritems($item);
        }
        // Rune
        if ($item['type'] != 'potion' && $item['type'] != 'quest' && !empty($title) && $title['type'] == 3) {
            $item['data_update'] = json_decode($item['data_update'], true);
            $item['title'] = $item['title'] . ' ' . $title['title'];
            if (!empty($item['data_update'])) foreach ($item['data_update'] as $key => $vl) {
                if(is_numeric($item['data_update'][$key])) $item['data_update'][$key] = $item['data_update'][$key] +  $title['data_update'];
            };
            $item['data_update'] = json_encode($item['data_update']);
            $item['gold'] = $item['gold'] + $title['gold'];
        }
        // Mảnh
        if (!empty($title['type']) && $item['type'] != 'quest' && !empty($title) && $title['type'] == 4) {
            $rand = rand(1, 3);
            $lasttitle = "(#$rand)";
            $item['user'] = $users->id;
            $item['title'] = $title['title'] . ' ' . $item['title'] . ' ' . $lasttitle;
            unset($item['id']);
            $this->_dungeon->add_item($item);
            return $item;
        }
        // Magic scroll
        if (($item['type'] != 'potion') && $item['type'] != 'quest' && !empty($title) && ($title['type'] == 5)) {
            $item['data_update'] = json_decode($item['data_update'], true);
            $item['title'] = $title['title'] . ' ' . $item['title'];
            if (!empty(json_decode($title['data_update']))) foreach (json_decode($title['data_update']) as $key => $vl) {
                if (!empty($item['data_update'][$key])) {
                    $item['data_update'][$key] = $item['data_update'][$key] +  $vl;
                } else {
                    $item['data_update'][$key] = $vl;
                }
            }
            $item['data_update'] = json_encode($item['data_update']);
            $item['gold'] = $item['gold'] + $title['gold'];
            if ((($item['type'] != "ring") && ($item['type'] != "amulet"))) $item = $this->staritems($item);
        };
        $this->_dungeon->add_item($item);
        return $item;
    }
}
