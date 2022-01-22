<?php

class Dungeon_model extends MYDungeon_Model
{
    function addData($from, $data)
    {
        $this->db->insert($from, $data);
    }

    function getData($select = '*', $from, $where)
    {
        $this->db->select($select);
        $this->db->from($from);
        $query = $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updData($from, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($from, $data);
    }
    public function update($table, $data)
    {
        $this->db->where($data['where']);
        $this->db->set($data['update']);
        $this->db->update($table);
    }
    public function delete($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }
    public function delWhe($table, $whe)
    {
        $this->db->where($whe);
        $this->db->delete($table);
    }


    ///////////////////////
    function register($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $this->db->select('*');
        $query = $this->db->get_where('users', array(
            'email' => $email
        ));
        if ($query->num_rows() == 0) {
            $this->db->insert("users", $data);
            $this->db->select('*');
            $query2 = $this->db->get_where('users', array(
                'email' => $email,
                'password' => $password
            ));
            return $query2->result_array();
        }
    }

    function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $this->db->select('*');
        $query = $this->db->get_where('users', array(
            'email' => $email,
            'password' => $password
        ));
        // echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            return $query->result_array(); // if data is true
        } else {
            return null;
        }
    }

    function update_users($data, $where)
    {
        $this->db->select('*');
        $query = $this->db->get_where('users', ['username' => $data['username']]);
        if ($query->num_rows() == 0) {
            $this->db->where($where);
            $this->db->update('users', $data);
            $this->db->select('*');
            $this->db->from('users');
            $query = $this->db->where($where);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
    }

    function usersHeroes()
    {
        $this->db->select('*');
        $this->db->from('ahsk_uheroes');
        $query = $this->db->where(['user_id' => $_SESSION['id']]);
        $query = $this->db->get();
        return $query->result_array();
    }

    function gameHeroes($round, $game)
    {
        $root_game = $this->db->get_where('ahsk_ugame', ['user_id' => $_SESSION['id'], 'round' => $round, 'game' => $game]);
        $root_game = $root_game->result_array();
        return $root_game;
    }

    function allHeroes()
    {
        $this->db->select('*');
        $this->db->from('dungeon_heroes');
        $query = $this->db->get();
        return $query->result_array();
    }

    function allMonster()
    {
        $this->db->select('*');
        $this->db->from('dungeon_monster');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_heroes($where)
    {
        $this->db->select('*');
        $this->db->from('dungeon_heroes');
        $query = $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_uheroes($where)
    {
        $this->db->select('*');
        $this->db->from('dungeon_uheroes');
        $query = $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    function add_uheroes($data)
    {
        $this->db->insert("dungeon_uheroes", $data);
    }

    /////
    function getMap($round, $game)
    {
        $root_game = $this->db->get_where('ahsk_map', ['round' => $round, 'game' => $game]);
        $root_game = $root_game->result_array();
        return $root_game;
    }
    function saveMonsterMap($data)
    {
        $this->db->insert("dungeon_hmap", $data);
    }

    function getMonsterByMap($map, $type = NULL)
    {
        $this->db->select('*');
        $this->db->from('dungeon_monster');
        $this->db->where(['map' => $map]);
        $this->db->where(['type' => $type]);
        $query = $this->db->get();
        return $query->result_array();
    }

    /////////////

    function attack($round, $game)
    {
        $this->db->select('*');
        $query = $this->db->get_where('ahsk_ugame', ['user_id' => $_SESSION['id'], 'round' => $round, 'game' => $game]);
        if ($query->num_rows() == 0) {
            $root_game = $this->db->get_where('ahsk_game', ['round' => $round, 'game' => $game]);
            $root_game = $root_game->result_array();
            foreach ($root_game as $k => $data) {
                $data['user_id'] = $_SESSION['id'];
                unset($data['id']);
                $this->db->insert("ahsk_ugame", $data);
            }
        };
    }

    //////////

    function add_item($data)
    {
        $this->db->insert("dungeon_uitems", $data);
    }

    function listItem($users, $type_sell, $type_item)
    {
        $pc = 10;
        $users = (object) $users;
        if ($users->level == 1) $pc = 0;
        $this->db->where('status', 'open');
        $this->db->where('need_lev <=', ($users->level + $pc));
        $this->db->where('craft', 'drop');
        $this->db->where_in('type', json_decode($type_sell, true));
        $this->db->where_in('typeitem', json_decode($type_item, true));
        $this->db->order_by('id', 'RANDOM');
        $this->db->limit(7);
        $query = $this->db->get('dungeon_items');
        return $query->result_array();
    }

    function listItemEquip($users, $where = null)
    {
        if ($where != null) $this->db->where($where);
        else $this->db->where('equip', 0);
        $this->db->where('user', $users['id']);
        $this->db->order_by('title', 'ESC');
        $query = $this->db->get('dungeon_uitems');
        return $query->result_array();
    }

    function randomItem($users, $monster, $type = null)
    {
        if (!empty($monster) && ($monster->level == 10)) {
            $this->db->where('id', 589);
            $query = $this->db->get('dungeon_items');
            return $query->result_array()[0];
        } else {
            if (!empty($type)) $this->db->where('type', $type);
            $this->db->order_by('id', 'RANDOM');
            $this->db->limit(1);
            $this->db->where((json_decode($monster->item, true)));
            $this->db->where('status', 'open');
            $this->db->where('craft', 'drop');
            $query = $this->db->get('dungeon_items');
            return $query->result_array();
        }
    }

    function randomItemPeace()
    {
        $this->db->where('craft', 'peace');
        $this->db->order_by('id', 'RANDOM');
        $this->db->limit(1);
        $query = $this->db->get('dungeon_items');
        return $query->result_array();
    }

    function randomTitle($item, $monster = null)
    {
        $rd = rand(0, 100);
        if (!empty($monster->item_title) && ($monster->level == 10 || $rd < ($monster->level * 10))) {
            $this->db->where('id', $monster->item_title);
            $query = $this->db->get('dungeon_title');
            return $query->result_array()[0];
        } else {
            $item = $item['type'];
            if ($item != 'potion') {
                $this->db->where('type <=', '4');
                $this->db->like('type_item', $item);
                $this->db->limit(1);
                $this->db->order_by('id', 'RANDOM');
                $query = $this->db->get('dungeon_title');
                return $query->result_array();
            };
        }
    }

    function getOnline($status = 'null')
    {
        switch ($status) {
            case 'list':
                $where = [
                    "last_signin >=" => (time() - 1000)
                ];
                $this->db->select('*');
                $this->db->where($where);
                $this->db->join('dungeon_uheroes', 'dungeon_uheroes.users = users.id');
                $query = $this->db->get('users');
                return $query->result_array();
                break;
            case 'onmap':
                $where = [
                    "map" => $_SESSION['heroes']['map']
                ];
                $this->db->select('*');
                $this->db->where($where);
                $this->db->join('dungeon_uheroes', 'dungeon_uheroes.users = users.id');
                $query = $this->db->get('users');
                return $query->result_array();
                break;

            default:
                $where = [
                    "last_signin >=" => (time() - 1000)
                ];
                $this->db->select('COUNT(*) AS `numrows`');
                $this->db->where($where);
                $query = $this->db->get('users');
                return $query->row()->numrows;
                break;
        }
    }

    function getGuest($status = 'null')
    {
        $where = [
            "time_updated >=" => (time() - 1000)
        ];
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('dungeon_guest');
        return $query->result_array();
    }

    function getFriends($users)
    {
        $this->db->select('*');
        $this->db->from('dungeon_friends');
        $where = ['users' => $_SESSION['users']['id']];
        $query = $this->db->where($where);
        $query = $this->db->get();
        $rs = [];
        foreach ($query->result_array() as $item) {
            $this->db->select('*');
            $this->db->from('users');
            $where = ['id' => $item['friends']];
            $query = $this->db->where($where);
            $query = $this->db->get();
            $rs[] = $query->result_array()[0];
        }
        return $rs;
    }

    function getBonusData($select = '*', $from, $where)
    {
        $this->db->select($select);
        $this->db->from($from);
        $query = $this->db->where($where);
        $this->db->order_by('level', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    //--> blacksmith <--//
    function getTitleFromItem($title)
    {
        $this->db->where('type', 'magicscroll');
        $this->db->where('typeitem', 'tile');
        $tile = $this->db->get('dungeon_items')->result_array();
        if (!empty($tile)) foreach ($tile as $key => $item) {
            $name_tile = str_replace(' magic scroll', '', $item['title']); // get title name
            if (strpos("%%" . $title, $name_tile) > 0) return $item;
        };
        return null;
    }
    function getMscrollFromItem($title)
    {
        $this->db->where('type', 1);
        $Mscroll = $this->db->get('dungeon_title')->result_array();
        if (!empty($Mscroll)) foreach ($Mscroll as $key => $item) {
            $name_tile = $item['title']; // get title name
            if (strpos("%%" . $title, $name_tile) > 0) return $item;
        };
        return null;
    }
    function getRandomMscroll()
    {
        $this->db->where('type', 'magicscroll');
        $this->db->where('typeitem', 'tile');
        $this->db->limit(1);
        $this->db->order_by('id', 'RANDOM');
        $tile = $this->db->get('dungeon_items')->result_array();
        return $tile;
    }
}
