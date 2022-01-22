<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends Dungeon_Controller
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
    public function index()
    {
        $data = array_merge([], $this->___root);
        $data['countItem'] = 0;
        $data['listItem'] = $item = $this->_dungeon->listItemEquip($data['heroes']);
        $data['countItem'] = count($item);
        if (!empty($item)) $item = $this->array_group_by($item, function ($a) {
            return $a['title'];
        });
        uasort($item, function ($a, $b) {
            return strcmp(count($a), count($b));
        });
        $data['item'] = array_reverse($item);

        $where = ['user' => $data['heroes']['id'], 'type' => 'weapon', 'equip' => $data['heroes']['id']];
        $where2 = ['user' => $data['heroes']['id'], 'type' => 'shield', 'equip' => $data['heroes']['id']];
        $where3 = ['user' => $data['heroes']['id'], 'type' => 'helm', 'equip' => $data['heroes']['id']];
        $where4 = ['user' => $data['heroes']['id'], 'type' => 'armor', 'equip' => $data['heroes']['id']];
        $where5 = ['user' => $data['heroes']['id'], 'type' => 'boot', 'equip' => $data['heroes']['id']];
        $where6 = ['user' => $data['heroes']['id'], 'type' => 'amulet', 'equip' => $data['heroes']['id']];
        $where7 = ['user' => $data['heroes']['id'], 'type' => 'ring', 'equip' => $data['heroes']['id']];
        $data['weapon'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where);
        $data['shield'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where2);
        $data['helm'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where3);
        $data['armor'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where4);
        $data['boot'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where5);
        $data['amulet'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where6);
        $data['ring'] = $this->_dungeon->getData('*', 'dungeon_uitems', $where7);
        $data['main'] = $this->load->view('default/public/dungeon/items', $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function info($id)
    {
        $data = array_merge([], $this->___root);
        $item = $this->_dungeon->getData('*', 'dungeon_uitems', ['id' => $id])[0];
        $this->___checkEmpty($item);
        if ($item['c1'] > 0) $data['item_c1'] = $item_c1 = $this->_dungeon->getData('*', 'dungeon_uitems', ['id' => $item['c1']])[0];
        if ($item['c2'] > 0) $data['item_c2'] = $item_c2 = $this->_dungeon->getData('*', 'dungeon_uitems', ['id' => $item['c2']])[0];
        $equipitem = $this->_dungeon->getData('*', 'dungeon_uitems', ['user' => $data['heroes']['id'], 'type' => $item['type'], 'equip' => $data['heroes']['id']]);
        if (!empty($equipitem)) $data['equipitem'] = $equipitem[0];
        else $data['equipitem']['data_update'] = '{}';
        // set item
        $item['data_update'] = (array) json_decode($item['data_update']);
        $item['equipment_rule'] = (array) json_decode($item['equipment_rule']);
        $data['item'] = $item;
        // action
        if (!empty($this->input->post()) || !empty($this->input->get())) {
            $status = $this->input->post('status');
            if (!empty($this->input->get())) $status = $this->input->get('status');
            $this->equip($item, $data, $id, $status);
            $this->use($item, $data, $id, $status);
            $this->takeoff($item, $data, $id, $status);
            $this->destroy($item, $data, $id, $status);
            $this->takeoffall($item, $data, $id, $status);
        };
        // check rule item
        $data['rule'] = $this->item_rules($item, $data, $id);
        // end
        //dump($data);
        $data['main'] = $this->load->view('default/public/dungeon/info', $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function equip($item, $data, $id, $status)
    {
        if ($status == 'equip') {
            $this->_dungeon->updData('dungeon_uitems', ['equip' => $item['user']], ['id' => $id]);
            if (!is_array($item['data_update'])) $item['data_update'] = (array)$item['data_update'];
            if (!empty($item['data_update'])) foreach ($item['data_update'] as $key => $vl) {
                if (is_numeric($vl)) switch ($key) {
                    case 'wisdom':
                        $_SESSION['heroes']['wisdom'] = $data['heroes'][$key] + $vl;
                        $userDB = $data['heroes']['maxmana'];
                        $newDB = $userDB + ($vl * 10);
                        $_SESSION['heroes']['maxmana'] = $newDB;
                        break;
                    case 'endurance':
                        $userDB = $data['heroes']['maxhealth'];
                        $newDB = $userDB + ($vl * 10);
                        $_SESSION['heroes']['maxhealth'] = $newDB;
                        $_SESSION['heroes']['endurance'] = $data['heroes'][$key] + $vl;
                        break;
                    case 'health':
                        $userDB = $data['heroes']['maxhealth'];
                        $newDB = $userDB + $vl;
                        $_SESSION['heroes']['maxhealth'] = $newDB;
                        break;
                    case 'mana':
                        $userDB = $data['heroes']['maxmana'];
                        $newDB = $userDB + $vl;
                        $_SESSION['heroes']['maxmana'] = $newDB;
                        break;
                    case 'stamina':
                        $userDB = $data['heroes']['stamina'];
                        $newDB = $userDB + $vl;
                        $_SESSION['heroes']['maxstamina'] = $newDB;
                        break;
                    default:
                        $userDB = $data['heroes'][$key];
                        $newDB = $userDB + $vl;
                        $_SESSION['heroes'][$key] = $newDB;
                        break;
                }
            }
            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
            redirect(base_url('dungeon/item'));
        }
    }

    public function use($item, $data, $id, $status)
    {
        if ($status == 'use') {
            if ($item['level'] == 1) {
                if (!empty($item['data_update'])) foreach ($item['data_update'] as $key => $vl) {
                    if (is_numeric($vl)) switch ($key) {
                        case 'health':
                            $userDB = $data['heroes']['health'];
                            $newDB = $userDB + $vl;
                            if ($newDB > $data['heroes']['maxhealth']) $newDB = $userDB;
                            $_SESSION['heroes']['health'] = $newDB;
                            break;
                        case 'mana':
                            $userDB = $data['heroes']['mana'];
                            $newDB = $userDB + $vl;
                            if ($newDB > $data['heroes']['maxmana']) $newDB = $userDB;
                            $_SESSION['heroes']['mana'] = $newDB;
                            break;
                        case 'stamina':
                            $userDB = $data['heroes']['stamina'];
                            $newDB = $userDB + $vl;
                            if ($newDB > $data['heroes']['maxstamina']) $newDB = $userDB;
                            $_SESSION['heroes']['stamina'] = $newDB;
                            break;
                    }
                };
                $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $data['heroes']['id']], 'update' => $_SESSION['heroes']]);
                $this->_dungeon->delete('dungeon_uitems', $id);
                if (!empty($this->input->get('back'))) {
                    redirect(base_url($this->input->get('back')));
                } else {
                    redirect(base_url('dungeon/item'));
                }
            };
            if ($item['level'] == 2) {
                if (!empty($item['data_update'])) foreach ($item['data_update'] as $key => $vl) {
                    if (is_numeric($vl)) switch ($key) {
                        case 'health':
                            $userDB = $data['heroes']['maxhealth'];
                            $newDB = $data['heroes']['health'] + ceil(($userDB / 100) * $vl);
                            if ($newDB > $userDB) $newDB = $userDB;
                            $_SESSION['heroes']['health'] = $newDB;
                            break;
                        case 'mana':
                            $userDB = $data['heroes']['maxmana'];
                            $newDB = $data['heroes']['mana'] + ceil(($userDB / 100) * $vl);
                            if ($newDB > $userDB) $newDB = $userDB;
                            $_SESSION['heroes']['mana'] = $newDB;
                            break;
                        case "stamina":
                            $userDB = $data['heroes']['maxstamina'];
                            $newDB = $data['heroes']['stamina'] + ceil(($userDB / 100) * $vl);
                            if ($newDB > $userDB) $newDB = $userDB;
                            $_SESSION['heroes']['stamina'] = $newDB;
                            break;
                    }
                };
                $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $data['heroes']['id']], 'update' => $_SESSION['heroes']]);
                $this->_dungeon->delete('dungeon_uitems', $id);
                if (!empty($this->input->get('back'))) {
                    redirect(base_url($this->input->get('back')));
                } else {
                    redirect(base_url('dungeon/item'));
                }
            }
        };
    }

    public function takeoff($item, $data, $id, $status)
    {
        if ($status == 'takeoff') {
            $this->_dungeon->updData('dungeon_uitems', ['equip' => 0], ['id' => $id]);

            if (!empty($item['data_update'])) foreach ($item['data_update'] as $key => $vl) {
                if (is_numeric($vl)) switch ($key) {
                    case 'wisdom':
                        $_SESSION['heroes']['wisdom'] = $data['heroes'][$key] - $vl;
                        $userDB = $data['heroes']['maxmana'];
                        $newDB = $userDB - ($vl * 10);
                        if ($newDB < 0) $newDB = 0;
                        $_SESSION['heroes']['maxmana'] = $newDB;
                        break;
                    case 'endurance':
                        $userDB = $data['heroes']['maxhealth'];
                        $newDB = $userDB - ($vl * 10);
                        $newEND = $data['heroes'][$key] - $vl;
                        if ($newDB < 0) $newDB = 0;
                        if ($newEND < 0) $newEND = 0;
                        $_SESSION['heroes']['maxhealth'] = $newDB;
                        $_SESSION['heroes']['endurance'] = $newEND;
                        break;
                    case 'health':
                        $userDB = $data['heroes']['maxhealth'];
                        $newDB = $userDB - $vl;
                        if ($newDB < 0) $newDB = 0;
                        $_SESSION['heroes']['maxhealth'] = $newDB;
                        break;
                    case 'stamina':
                        $userDB = $data['heroes']['stamina'];
                        $newDB = $userDB - $vl;
                        if ($newDB < 0) $newDB = 0;
                        $_SESSION['heroes']['maxstamina'] = $newDB;
                        break;
                    default:
                        $userDB = $data['heroes'][$key];
                        $newDB = $userDB - $vl;
                        if ($newDB < 0) $newDB = 0;
                        $_SESSION['heroes'][$key] = $newDB;
                        break;
                }
            }
            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
            redirect(base_url('dungeon/item'));
        }
    }

    public function destroy($item, $data, $id, $status)
    {
        if ($status == 'destroy') {
            if (!empty($_POST['choose'])) {
                foreach ($_POST['choose'] as $key => $id) {
                    $_SESSION['heroes']['gold'] = $_SESSION['heroes']['gold'] + $item['gold'];
                    $this->_dungeon->delete('dungeon_uitems', $id);
                }
                $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
            } else {
                $_SESSION['heroes']['gold'] = $_SESSION['heroes']['gold'] + $item['gold'];
                $this->_dungeon->delete('dungeon_uitems', $id);
                $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
            }
            redirect(base_url('dungeon/item'));
        }
    }

    public function takeoffall($item, $data, $id, $status)
    {
    }

    public function item_rules($item, $data, $id)
    {
        $result = [];
        $equip_type = ["weapon", "shield", "helm", "armor", "boot", "amulet", "ring"];
        $use_type = ["potion", "jewel"];
        $equip_twoHanded = ["barbarian", "assassin", "amazon"];
        $whereItemEquip = ['user' => $data['heroes']['id'], 'type' => $item['type'], 'equip' => $data['heroes']['id']];
        $whereWeaponItemEquip = ['user' => $data['heroes']['id'], 'type' => 'weapon', 'equip' => $data['heroes']['id']];
        $whereShieldItemEquip = ['user' => $data['heroes']['id'], 'type' => 'shield', 'equip' => $data['heroes']['id']];
        $itemEquip = $this->_dungeon->getData('*', 'dungeon_uitems', $whereItemEquip);
        $itemWeaponEquip = $this->_dungeon->getData('*', 'dungeon_uitems', $whereWeaponItemEquip);
        $itemShieldEquip = $this->_dungeon->getData('*', 'dungeon_uitems', $whereShieldItemEquip);
        // check equip
        $result['equip'] = ['0'];
        if (!in_array($item['type'], $equip_type)) unset($result['equip']);
        if ($item['equip'] == 1) unset($result['equip']);
        // check equipment_rule
        if (!empty($item['equipment_rule']['class']) && $item['equipment_rule']['class'] != $data['heroes']['class']) unset($result['equip']);
        if (!empty($item['equipment_rule']['strength']) && $item['equipment_rule']['strength'] > $data['heroes']['strength']) unset($result['equip']);
        if (!empty($item['equipment_rule']['dexterity']) && $item['equipment_rule']['dexterity'] > $data['heroes']['dexterity']) unset($result['equip']);
        if (!empty($item['equipment_rule']['endurance']) && $item['equipment_rule']['endurance'] > $data['heroes']['endurance']) unset($result['equip']);
        if (!empty($item['equipment_rule']['wisdom']) && $item['equipment_rule']['wisdom'] > $data['heroes']['wisdom']) unset($result['equip']);
        //* check equipment_rule end 
        if ($item['type'] != 'ring' && count($itemEquip) >= 1) unset($result['equip']); //* check equip
        if ($item['type'] == 'ring' && count($itemEquip) >= 2) unset($result['equip']); //* check ring equip
        if (($item['type'] == 'shield' && $item['typeitem'] == 'bow') && (!empty($itemWeaponEquip) && $itemWeaponEquip[0]['typeitem'] != 'bow')) unset($result['equip']); //* check shield bow equip
        if (($item['type'] == 'shield' && $item['typeitem'] != 'bow') && (!empty($itemWeaponEquip) && $itemWeaponEquip[0]['typeitem'] === 'bow')) unset($result['equip']); //* check shield bow equip
        if (($item['type'] == 'weapon' && $item['typeitem'] != 'bow') && (!empty($itemShieldEquip) && $itemShieldEquip[0]['typeitem'] === 'bow')) unset($result['equip']); //* check shield bow equip
        if (($item['type'] == 'weapon' && $item['typeitem'] == 'bow') && (!empty($itemShieldEquip) && $itemShieldEquip[0]['typeitem'] != 'bow')) unset($result['equip']); //* check shield bow equip
        if (($item['type'] == 'weapon' && $item['typeitem'] == 'two-handed') && (!in_array($data['heroes']['class'], $equip_twoHanded) || !empty($itemShieldEquip))) unset($result['equip']); //* check weapon two-handed bow equip
        if (($item['type'] == 'shield') && (!empty($itemWeaponEquip) && $itemWeaponEquip[0]['typeitem'] === 'two-handed')) unset($result['equip']); //* check shield two-handed equip

        // check use
        $result['use'] = ['0'];
        if (!in_array($item['type'], $use_type)) unset($result['use']);
        // check takeoff
        $result['takeoff'] = ['0'];
        if ($item['equip'] == 0) unset($result['takeoff']);
        // check destroy
        $result['destroy'] = ['0'];

        // check takeoff all
        $result['takeoffall'] = ['0'];
        if ($item['equip'] != 1) unset($result['takeoffall']);

        return $result;
    }
}
