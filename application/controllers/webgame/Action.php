<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Action extends Dungeon_Controller
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

    public function charater($idcode)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/npc';
        $npc = $this->_dungeon->getData('*', 'dungeon_npc', ['slug' => $idcode])[0];
        $npc['type_sell'] = (array) json_decode($npc['type_sell']);
        $npc['type_item'] = (array) json_decode($npc['type_item']);
        $data['npc'] = $npc;

        if (!empty($_GET['buy'])) switch ($_GET['buy']) {
            case 'thing':
                $data['data_shop'] = $npc['data_shop'];
                if (empty($data['data_shop'])) $data['data_shop'] = $this->change_shop($npc);
                $data['listItem'] = (array) json_decode($data['data_shop']);

                break;
            default:
                $d = $_GET['buy'] - 1;
                $listItem = (array) json_decode($npc['data_shop']);
                $data['item'] = $item = (array) $listItem[$d];
                $this->buy_shop($idcode, $data);
                break;
        };
        if (!empty($_GET['blacksmith'])) switch ($_GET['blacksmith']) {
            case 'thing':
                $data['listItem'] = $listItem  = $this->_dungeon->listItemEquip($_SESSION['heroes'], ['equip' => '0']);
                break;
            case 'craft':
                /// check
                $check['check_item'] = 0;
                $check['check_gem'] = 0;
                $check['check_scroll'] = 0;
                $check['check_piece'] = 0;
                $check['list_piece'] = '|';
                $cpchange = [];
                if (!empty($this->input->post('cp'))) {
                    $data['cp'] = $cp = $this->input->post();
                    foreach ($cp['cp'] as $k => $vl) {
                        if (!empty($vl) && $vl > 0) {
                            $itemz = $this->_dungeon->getData('*', 'dungeon_uitems', ['id' => $vl])[0];
                            if (in_array($itemz['type'], ["weapon", "shield", "helm", 'armor', 'boot', 'amulet', 'ring']) === true) {
                                $check['check_item']++;
                                $cpchange['item'] = $itemz;
                                $cpchange['cp'][] = $itemz;
                            } elseif ($itemz['type'] == 'gem') {
                                $check['check_gem']++;
                                $cpchange['gem'][] = $itemz;
                                $cpchange['cp'][] = $itemz;
                            } elseif ($itemz['type'] == 'pieces') {
                                $check['list_piece'] .= $itemz['title'] . '|';
                                $cpchange['piece'] = $itemz;
                                $cpchange['cp'][] = $itemz;
                                $check['check_piece']++;
                            } elseif ($itemz['type'] == 'magicscroll') {
                                $check['check_scroll']++;
                                $cpchange['scroll'] = $itemz;
                            };
                        }
                    };
                };

                if ($check['check_piece'] === 3) $data['craft'] = $this->craft_pieces($check, $cpchange);
                if ($check['check_item'] == 1 && (($check['check_gem'] == 1 && $cpchange['item']['c2'] == 0) || ($check['check_gem'] == 2 && $cpchange['item']['c2'] == 0 &&  $cpchange['item']['c1'] == 0))) $data['craft'] = $this->craft_store($check, $cpchange);
                if ($check['check_item'] == 1 && $check['check_scroll'] == 1) $data['craft'] = $this->craft_tile($cpchange);
                if ($check['check_item'] == 0 && $check['check_scroll'] == 1) $data['craft'] = $this->random_title($cpchange);


                // Message
                if ($check['check_item'] + $check['check_gem'] + $check['check_scroll'] + $check['check_piece'] == 0) $data['err'] = 'Chưa chọn item nào cả';
                break;
            default:
                break;
        };
        if (!empty($_GET['status'])) switch ($_GET['status']) {
            case 'open':
                $data['listItem'] = $listItem  = $this->_dungeon->listItemEquip($_SESSION['heroes'], ['equip' => '-1']);
                if (!empty($_GET['id'])) {
                    $stamina = [
                        'where' => [
                            'id' => $_GET['id']
                        ],
                        'update' => [
                            'equip' => 0
                        ]
                    ];
                    $this->_dungeon->updData('dungeon_uitems', $stamina['update'], $stamina['where']);
                    redirect(base_url('dungeon/action/charater/Vaults?status=open'));
                };
                break;
            case 'save':
                $data['listItem'] = $listItem  = $this->_dungeon->listItemEquip($_SESSION['heroes'], ['equip' => '0']);
                if (!empty($_GET['id'])) {
                    $stamina = [
                        'where' => [
                            'id' => $_GET['id']
                        ],
                        'update' => [
                            'equip' => -1
                        ]
                    ];
                    $this->_dungeon->updData('dungeon_uitems', $stamina['update'], $stamina['where']);
                    redirect(base_url('dungeon/action/charater/Vaults?status=save'));
                };
                break;
            default:
                break;
        };
        if (!empty($_GET['learn'])) switch ($_GET['learn']) {
            case 'thing':
                $data['listItem'] = $listItem  = $this->_dungeon->getData('*', 'dungeon_spells', ['npc' => $idcode]);
                break;
            default:
                $data['item'] = $item = $this->_dungeon->getData('*', 'dungeon_spells', ['id' => $_GET['learn']])[0];
                // Match item Requirements
                $id_true = 0;
                $itemtest = $this->_dungeon->getData('*', 'dungeon_uspells', ['user' => $_SESSION['heroes']['id'], 'title' => $item['title']]);
                if (!empty($itemtest) && count($itemtest) > 0) $id_true++;
                // end
                $data['id_true'] = $id_true;
                if (!empty($_GET['now']) && $_GET['now'] == 1) {
                    unset($item['id']);
                    unset($item['npc']);
                    $item['user'] = $_SESSION['heroes']['id'];
                    $this->_dungeon->addData('dungeon_uspells', $item);
                    redirect(base_url('dungeon/action/charater/' . $data['npc']['slug']));
                }
                break;
        };
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function point($idcode)
    {
        $users = $_SESSION['users'];
        $udungeon = $_SESSION['heroes'];
        if ($idcode == 'strength') {
            $udungeon['health'] = ($udungeon['maxhealth']);
            $udungeon['mana'] = ($udungeon['maxmana']);
            $udungeon['strength'] = ($udungeon['strength'] + 1);
            $udungeon['point'] = ($udungeon['point'] - 1);
        };
        if ($idcode == 'dexterity') {
            $udungeon['health'] = ($udungeon['maxhealth']);
            $udungeon['mana'] = ($udungeon['maxmana']);
            $udungeon['dexterity'] = ($udungeon['dexterity'] + 1);
            $udungeon['point'] = ($udungeon['point'] - 1);
        };
        if ($idcode == 'armor') {
            $udungeon['health'] = ($udungeon['maxhealth']);
            $udungeon['mana'] = ($udungeon['maxmana']);
            $udungeon['armor'] = ($udungeon['armor'] + 1);
            $udungeon['point'] = ($udungeon['point'] - 1);
        };
        if ($idcode == 'endurance') {
            $udungeon['health'] = ($udungeon['health'] * 10 + 10);
            $udungeon['maxhealth'] = ($udungeon['maxhealth'] * 10 + 10);
            $udungeon['mana'] = ($udungeon['maxmana']);
            $udungeon['endurance'] = ($udungeon['endurance'] + 1);
            $udungeon['point'] = ($udungeon['point'] - 1);
        };
        if ($idcode == 'wisdom') {
            $udungeon['health'] = ($udungeon['maxhealth']);
            $udungeon['mana'] = ($udungeon['maxmana']);
            $udungeon['maxmana'] = ($udungeon['maxmana'] + 10);
            $udungeon['wisdom'] = ($udungeon['wisdom'] + 1);
            $udungeon['point'] = ($udungeon['point'] - 1);
        };
        $this->_dungeon->updData('dungeon_uheroes', $udungeon, ['users' => $users['id']]);
        $_SESSION['heroes'] = $this->_dungeon->getData('*', 'dungeon_uheroes', ['users' => $users['id']])[0];
        redirect(base_url('dungeon'));
    }
    public function go($idcode)
    {
        $users = $_SESSION['users'];
        $mappr = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $_SESSION['heroes']['map']])[0];
        $link = json_decode($mappr['link']);
        $plink = json_decode($mappr['plink']);
        $go = json_decode($mappr['go']);
        if (in_array($idcode, $plink) === true && is_numeric($link[array_search($idcode, $plink)]) == false) {
            $npc = $link[array_search($idcode, $plink)];
            $data = [
                'where' => [
                    'users' => $users['id']
                ],
                'update' => [
                    'stamina' => ($_SESSION['heroes']['stamina'] - 1),
                    'map' => $mappr['id'],
                    'x' => $idcode
                ]
            ];
            $this->_dungeon->updData('dungeon_uheroes', $data['update'], $data['where']);
            $_SESSION['heroes']['map'] = $data['update']['map'];
            $_SESSION['heroes']['x'] = $data['update']['x'];
            redirect(base_url('dungeon/action/charater/' . $npc));
        }
        if (in_array($idcode, $plink) === true && $_SESSION['heroes']['x'] == $idcode) {
            $newmap = $link[array_search($idcode, $plink)];
            $newgo = $go[array_search($idcode, $plink)];
            $data = [
                'where' => [
                    'users' => $users['id']
                ],
                'update' => [
                    'stamina' => ($_SESSION['heroes']['stamina'] - 1),
                    'map' => $newmap,
                    'x' => $newgo
                ]
            ];
        } else {
            $data = [
                'where' => [
                    'users' => $users['id']
                ],
                'update' => [
                    'stamina' => ($_SESSION['heroes']['stamina'] - 1),
                    'map' => $mappr['id'],
                    'x' => $idcode
                ]
            ];
        }

        $this->_dungeon->updData('dungeon_uheroes', $data['update'], $data['where']);
        $_SESSION['heroes']['map'] = $data['update']['map'];
        $_SESSION['heroes']['x'] = $data['update']['x'];
        $_SESSION['heroes']['stamina'] = $data['update']['stamina'];
        redirect(base_url('dungeon'));
    }


    // 
    private function change_shop($npc)
    {
        if (!empty($npc['type_item'])) $listItem  = $this->_dungeon->listItem($_SESSION['heroes'], $npc['type_sell'], $npc['type_item']);
        if (!empty($listItem)) {
            if (!empty($npc['type_sell']) && $npc['type_sell'][0] == 'potion') {
                if (empty($npc['data_shop'])) $this->_dungeon->updateData('dungeon_npc', ['id' => $npc['id']], ['data_shop' => json_encode($listItem)]);
                return json_encode($listItem);
            };
            if (!empty($npc['type_sell']) && $npc['type_sell'][0] != 'potion') {
                $sell_item = [];
                for ($i = 0; $i <= 9; $i++) {
                    $item = $listItem[array_rand($listItem)];
                    $title = $this->_dungeon->randomTitle($item)[0];
                    $sell_item[] = $this->craft($item, $title);
                };
                if (empty($npc['data_shop'])) $this->_dungeon->updateData('dungeon_npc', ['id' => $npc['id']], ['data_shop' => json_encode($sell_item)]);
                return json_encode($sell_item);
            };
        };
    }
    private function buy_shop($idcode, $data)
    {
        if (!empty($_GET['now']) && $_GET['now'] == 1) {
            $item = $data['item'];
            unset($item['id']);
            $item['user'] = $_SESSION['heroes']['id'];
            if ($_GET['num'] > 0) for ($x = 1; $x <= $_GET['num']; $x++) {
                if ($_SESSION['heroes']['gold'] - $item['gold'] > 0) {
                    $this->_dungeon->add_item($item);
                    $_SESSION['heroes']['gold'] = $_SESSION['heroes']['gold'] - $item['gold'];
                }
            }
            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
            redirect(base_url('dungeon/action/charater/' . $data['npc']['slug']));
        }
    }
    private function craft_store($cp, $check_piece)
    {
        $item = $check_piece['item'];
        $item['data_update'] = (array) json_decode($item['data_update']);
        $item['equipment_rule'] = (array) json_decode($item['equipment_rule']);
        if (count($check_piece['gem']) > 0) foreach ($check_piece['gem'] as $key => $gem) {
            $gem['data_update'] = (array) json_decode($gem['data_update']);
            $gem['equipment_rule'] = (array) json_decode($gem['equipment_rule']);
            if (count($gem['data_update']) > 0) foreach ($gem['data_update'] as $key => $data_update) {
                if (!empty($item['data_update'][$key])) {
                    if (is_numeric($data_update)) $item['data_update'][$key] = $item['data_update'][$key] +  $data_update;
                } else {
                    $item['data_update'][$key] = $data_update;
                }
            };
            if ($item['c1'] > 0 && $item['c2'] == 0) $item['c2'] = $gem['id'];
            if ($item['c1'] == 0) $item['c1'] = $gem['id'];
            //dd($gem);
            $this->_dungeon->updData('dungeon_uitems', ['equip' => -1], ['id' => $gem['id']]);
        };
        $item['data_update'] = json_encode($item['data_update']);
        $item['equipment_rule'] = json_encode($item['equipment_rule']);

        $this->_dungeon->updData('dungeon_uitems', $item, ['id' => $item['id']]);
        redirect(base_url('dungeon/item'));
    }
    private function craft_pieces($cp, $check_piece)
    {

        /// ghép mảnh
        $pr1 = (strpos($check_piece['piece']['title'], 'A pieces of') + strlen('A pieces of '));
        $pr2 = strpos($check_piece['piece']['title'], ' (#') - $pr1;
        $check_piece_title = substr($check_piece['piece']['title'], $pr1, $pr2);

        $check_piece_count_tit =    substr_count($cp['list_piece'], $check_piece_title);
        $check_piece_count_piece1 = substr_count($cp['list_piece'], "(#1)");
        $check_piece_count_piece2 = substr_count($cp['list_piece'], '(#2)');
        $check_piece_count_piece3 = substr_count($cp['list_piece'], '(#3)');

        if ($check_piece_count_tit == 3 && $check_piece_count_piece1 == 1 && $check_piece_count_piece2 == 1 && $check_piece_count_piece3 == 1) {
            $newItem = $check_piece['piece'];
            $data['newItem'] = $newItem['title'] = $check_piece_title;
            if (!empty($this->input->post('title'))) {
                $newType = $this->_dungeon->getData('type', 'dungeon_piece', ['title' => $check_piece_title])[0]['type'];
                $newItem['type'] = $newType;
                $newItem['title'] = '"' . $_POST['title'] . '" ' . trim($newItem['title']);
                unset($newItem['id']);
                $this->_dungeon->add_item($newItem);
                foreach ($check_piece['cp'] as $k => $vl) {
                    $this->_dungeon->delete('dungeon_uitems', $vl['id']);
                };
                redirect(base_url('dungeon/item'));
            };
            return $data;
        };
    }
    private function craft_tile($check_piece)
    {
        $data['newItem'] = $check_piece['item'];
        if (isset($_POST['title'])) {
            $title = $this->_dungeon->getTitleFromItem($check_piece['item']['title']);
            if (!empty($title['data_update'])) $title['star'] = $check_piece['item']['star'];
            if (!empty($title['data_update'])) $title = $this->matchstaritem($title);
            if (!empty($title['data_update'])) $title['data_update'] = (array) json_decode(json_encode(viewDataItem($title['data_update'])));
            if (!empty($title['equipment_rule'])) $title['equipment_rule'] = (array) json_decode(json_encode(viewDataItem($title['equipment_rule'])));
            
            $Mscroll = $this->_dungeon->getMscrollFromItem($check_piece['item']['title']);
            if (!empty($Mscroll['data_update'])) $Mscroll['star'] = $check_piece['item']['star'];
            if (!empty($Mscroll['data_update'])) $Mscroll = $this->matchstaritem($Mscroll);
            if (!empty($Mscroll['data_update'])) $Mscroll['data_update'] = (array) json_decode(json_encode(viewDataItem($Mscroll['data_update'])));
            if (!empty($Mscroll['equipment_rule'])) $Mscroll['equipment_rule'] = (array) json_decode(json_encode(viewDataItem($Mscroll['equipment_rule'])));
            
            $item = $check_piece['item'];
            $itemID = $item['id'];
            if (!empty($item['data_update'])) $item['data_update'] = (array) json_decode(json_encode(viewDataItem($item['data_update'])));
            if (!empty($item['equipment_rule'])) $item['equipment_rule'] = (array) json_decode(json_encode(viewDataItem($item['equipment_rule'])));
            $item['title'] = trim(preg_replace('/"[\s\S]+?"/', '', trim(str_replace(str_replace(' magic scroll', '', $title['title']), '', $item['title']))));
            $item['title'] = trim(preg_replace('/"[\s\S]+?"/', '', trim(str_replace(str_replace(' magic scroll', '', $Mscroll['title']), '', $item['title']))));
            
            if (!empty($item['data_update']) && !empty($title['data_update'])) foreach ($title['data_update'] as $key => $vl) {
                $item['data_update'][$key] = $item['data_update'][$key] -  $vl;
            };
            if (!empty($item['data_update']) && !empty($Mscroll['data_update'])) foreach ($Mscroll['data_update'] as $key => $vl) {
                $item['data_update'][$key] = $item['data_update'][$key] -  $vl;
            };
            $scroll = $check_piece['scroll'];
            $scroll['star'] = $check_piece['item']['star'];
            $scroll = $this->matchstaritem($scroll);
            if (!empty($scroll['data_update'])) $scroll['data_update'] = (array) json_decode(json_encode(viewDataItem($scroll['data_update'])));
            if (!empty($scroll['equipment_rule'])) $scroll['equipment_rule'] = (array) json_decode(json_encode(viewDataItem($scroll['equipment_rule'])));
            
            switch ($scroll['typeitem']) {
                case "tile":
                    if (!empty($_POST['title'])) $item['title'] = '"' . $this->input->post('title') . '" ' . str_replace('magic scroll', '', $scroll['title']) . $item['title'];
                    else $item['title'] = str_replace('magic scroll', '', $scroll['title']) . $item['title'];

                    if (!empty($item['data_update']) && !empty($scroll['data_update'])) foreach ($scroll['data_update'] as $key => $vl) {
                        if (!empty($item['data_update'][$key])) {
                            $k = (int)($item['data_update'][$key]);
                            $vl = (int) $vl;
                            if ($vl > 0) $item['data_update'][$key] = $k +  $vl;
                        } else {
                            $vl = (int) $vl;
                            if ($vl > 0) $item['data_update'][$key] = $vl;
                        }
                    };
                    break;
            };
            
            unset($item['id']);
            $item['data_update'] = json_encode(viewDataItem($item['data_update']));
            $item['equipment_rule'] = json_encode(viewDataItem($item['equipment_rule']));
            $this->_dungeon->updData('dungeon_uitems', $item, ['id' => $itemID]);
            $this->_dungeon->updData('dungeon_uitems', ['equip' => -1], ['id' => $scroll['id']]);
            redirect(base_url('dungeon/item'));
        };
        return $data;
    }
    private function random_title($scroll)
    {
        $newScroll = $this->_dungeon->getRandomMscroll();
        $newScroll['user'] = $_SESSION['heroes']['id'];
        unset($newScroll['id']);
        $this->_dungeon->add_item($newScroll);
        $this->_dungeon->delete('dungeon_uitems', $scroll['scroll']['id']);
        redirect(base_url('dungeon/item'));
    }
}
