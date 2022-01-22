<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $template_path = '';
    public $template_main = '';
    public $template_admin = '';
    public $templates_assets = '';
    public $settings = array();
    public $_controller;
    public $_method;
    public $_memcache;
    public $_message = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_controller = $this->router->fetch_class();
        $this->_method = $this->router->fetch_method();
        $this->template_main = 'public/layout';
        $this->template_admin = 'default/public/admin';
        //load cache driver
        $this->load->driver('cache', array('adapter' => CACHE_ADAPTER, 'backup' => 'file', 'key_prefix' => CACHE_PREFIX_NAME));

        // 
        $this->load->model('admin/setting_model', 'setting_model');



        //general settings

        $global_data['general_settings'] = $this->setting_model->get_general_settings();

        $this->general_settings = $global_data['general_settings'];



        //set timezone

        date_default_timezone_set($this->general_settings['timezone']);



        //recaptcha status

        $global_data['recaptcha_status'] = true;

        if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key'])) {

            $global_data['recaptcha_status'] = false;
        }

        $this->recaptcha_status = $global_data['recaptcha_status'];

        $site_language = ($this->general_settings['default_language'] != "") ? $this->general_settings['default_language'] : "english";
        $language = ($this->session->userdata('site_lang') != "") ? $this->session->userdata('site_lang') : $site_language;
        $language = strtolower(get_lang_name_by_id($language));

        $this->config->set_item('language', $language);
        $this->lang->load(array('site'), $language);
    }
    function session($type, $data)
    {
        switch ($type) {
            case 'set':
                $this->session->set_userdata($data);
                break;
            case 'remove':
                $this->session->unset_userdata($data);
                break;
        }
    }

    public function setCacheFile($timeOut = 1)
    {
        $this->output->cache($timeOut);
    }
    public function setCache($key, $data, $timeOut = 3600)
    {
        $this->cache->save($key, $data, $timeOut);
    }

    public function getCache($key)
    {
        return $this->cache->get($key);
    }

    public function deleteCache($key = null)
    {
        if (!empty($key)) {
            return $this->cache->delete($key);
        } else return $this->cache->clean();
    }

    public function geneJsonFile($url = 'database/setting_dashboard.json', $cache_name = 'cache_dbsetting', $cache = true)
    {
        if ($cache == true) $data = $this->getCache($cache_name);
        if (empty($data)) if ($cache == true) {
            $data = json_decode(file_get_contents(base_url($url)));
            $this->setCache($cache_name, $data);
        }
        return $data;
    }

    public function cUrl($url, array $post_data = array(), $delete = false, $verbose = false, $ref_url = false, $cookie_location = false, $return_transfer = true)
    {
        $pointer = curl_init();

        curl_setopt($pointer, CURLOPT_URL, $url);
        curl_setopt($pointer, CURLOPT_TIMEOUT, 40);
        curl_setopt($pointer, CURLOPT_RETURNTRANSFER, $return_transfer);
        curl_setopt($pointer, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.28 Safari/534.10");
        curl_setopt($pointer, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($pointer, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($pointer, CURLOPT_HEADER, false);
        curl_setopt($pointer, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($pointer, CURLOPT_AUTOREFERER, true);
        curl_setopt($pointer, CURLOPT_SSL_VERIFYPEER, false);
        if ($cookie_location !== false) {
            curl_setopt($pointer, CURLOPT_COOKIEJAR, $cookie_location);
            curl_setopt($pointer, CURLOPT_COOKIEFILE, $cookie_location);
            curl_setopt($pointer, CURLOPT_COOKIE, session_name() . '=' . session_id());
        }

        if ($verbose !== false) {
            $verbose_pointer = fopen($verbose, 'w');
            curl_setopt($pointer, CURLOPT_VERBOSE, true);
            curl_setopt($pointer, CURLOPT_STDERR, $verbose_pointer);
        }

        if ($ref_url !== false) {
            curl_setopt($pointer, CURLOPT_REFERER, $ref_url);
        }

        if (count($post_data) > 0) {
            curl_setopt($pointer, CURLOPT_POST, true);
            curl_setopt($pointer, CURLOPT_POSTFIELDS, $post_data);
        }
        if ($delete !== false) {
            curl_setopt($pointer, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        $return_val = curl_exec($pointer);

        $http_code = curl_getinfo($pointer, CURLINFO_HTTP_CODE);

        if ($http_code == 404) {
            return false;
        }

        curl_close($pointer);

        unset($pointer);

        return $return_val;
    }

    function sendXmlOverPost($url, $xml)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // For xml, change the content-type.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function toSlug($doc)
    {
        $str = addslashes(html_entity_decode($doc));
        $str = $this->toNormal($str);
        $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $str = preg_replace("/( )/", '-', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace("\/", '', $str);
        $str = str_replace("+", "", $str);
        $str = strtolower($str);
        $str = stripslashes($str);
        return trim($str, '-');
    }

    public function toNormal($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }

    public function returnJson($data = null)
    {
        if ($this->config->item('csrf_protection') == TRUE) {
            $csrf = [
                'csrf_form' => [
                    'csrf_name' => $this->security->get_csrf_token_name(),
                    'csrf_value' => $this->security->get_csrf_hash()
                ]
            ];
            if (empty($data)) $data = $this->_message;
            $data = array_merge($csrf, (array) $data);
        }
        die(json_encode($data));
    }

    public function array_group_by(array $arr, callable $key_selector)
    {
        $result = array();
        foreach ($arr as $i) {
            $key = call_user_func($key_selector, $i);
            $result[$key][] = $i;
        }
        return $result;
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if (!$this->recaptcha_status) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }
}

class Dungeon_Controller extends MY_Controller
{
    public $___root;
    protected $_language;
    protected $_dungeon;
    public function __construct()
    {
        parent::__construct();
        $this->load->helpers(array("dungeon_helper"));
        $this->load->model(['Dungeon_model']);
        $this->_dungeon = new Dungeon_model();
        $this->___root = $this->___root();
    }

    public function ___root()
    {
        $this->___checkGuest();
        $this->__die();
        $this->__uplevel();
        $root = [
            'lang' => $this->language(),
            'online' => $this->_dungeon->getOnline('list'),
            'guest' => $this->_dungeon->getGuest('list'),
        ];
        if (!empty($_SESSION['users'])) {
            $root['users'] = $_SESSION['users'];
            $_SESSION['users']['last_signin'] = time();
            $this->_dungeon->updateData('users', ['id' => $_SESSION['users']['id']], ['last_signin' => time()]);
        };
        if (!empty($_SESSION['heroes'])) {
            $root['heroes'] = $_SESSION['heroes'];
            $root['restore'] = $this->restore($root);
            $root['heroes'] = $_SESSION['heroes'];
        };
        return $root;
    }

    public function ___checkGuest()
    {
        if (empty($_SESSION['users'])) {
            $ip = $this->input->ip_address();
            $par = [
                'ip' => $ip
            ];
            $list_tp = $this->_dungeon->getDataBy('dungeon_guest', $par);
            if (!$list_tp) {
                $time = time();
                $time2 = date('H:i:s d/m/y', time());
                $currentURL = current_url(); //http://myhost/main
                $params   = $_SERVER['QUERY_STRING']; //my_id=1,3
                $fullURL = $currentURL . '?' . $params;
                $log = "*$fullURL($time2)\n";
                $list_tp = [
                    'ip' => $ip,
                    'log' => $log,
                    'time_created' => $time,
                    'time_updated' => $time
                ];
                $this->_dungeon->inserData('dungeon_guest', $list_tp);
            } else {
                $time = time();
                $time2 = date('H:i:s d/m/y', time());
                $currentURL = current_url(); //http://myhost/main
                $params   = $_SERVER['QUERY_STRING']; //my_id=1,3
                $fullURL = $currentURL . '?' . $params;
                $log = $list_tp['log'] . "*$fullURL($time2)\n";
                $list_tp = [
                    'log' => $log,
                    'time_updated' => $time
                ];
                $this->_dungeon->updateData('dungeon_guest', ['ip' => $ip], $list_tp);
            };
        } else {
            $ip = $this->input->ip_address();
            $time2 = date('H:i:s d/m/y', time());
            $currentURL = current_url(); //http://myhost/main
            $params   = $_SERVER['QUERY_STRING']; //my_id=1,3
            $fullURL = $currentURL . '?' . $params;
            $log = $_SESSION['users']['log']."*$fullURL($time2)\n";
            $list_tp = [
                'ip' => $ip,
                'log' => $log
            ];
            $this->_dungeon->updateData('users', ['id' => $_SESSION['users']['id']], $list_tp);
        };
    }

    public function ___checkEmpty($check)
    {
        if (empty($check)) redirect(base_url('')); // Kiểm tra item tồn tại
    }

    public function staritems($item)
    {

        //$item['star'] = rand(1, 6);
        $x = 0;
        if (!empty($_SESSION['mode_Diamond'])) $x = 3000;
        $dom = rand($x, 10001);
        if ($dom >= 1 && $dom <= 6000) {
            $item['star'] = 1;
            $item['gold'] = ceil(($item['gold'] / 100) * 100);
        };
        if ($dom >= 6001 && $dom <= 8025) {
            $item['star'] = 2;
            $item['gold'] = ceil(($item['gold'] / 100) * 125);
        };
        if ($dom >= 8026 && $dom <= 9065) {
            $item['star'] = 3;
            $item['gold'] = ceil(($item['gold'] / 100) * 145);
        };
        if ($dom >= 9066 && $dom <= 9085) {
            $item['star'] = 4;
            $item['gold'] = ceil(($item['gold'] / 100) * 175);
        };
        if ($dom >= 9086 && $dom <= 9095) {
            $item['star'] = 5;
            $item['gold'] = ceil(($item['gold'] / 100) * 200);
        };
        if ($dom >= 9096 && $dom <= 10000) {
            $item['star'] = 6;
            $item['gold'] = ceil(10000 + ($item['gold'] / 100) * 250);
        };
        if ($dom > 10000) {
            $item['star'] = 7;
            $item['gold'] = ceil((100000 + $item['gold'] / 100) * 400);
        };
        $item = $this->matchstaritem($item);

        return $item;
    }

    public function matchstaritem($item)
    {
        $item['data_update'] = json_decode($item['data_update'], true);
        if (!empty($item['data_update']) && $item['star'] > 1) foreach ($item['data_update'] as $key => $vl) {
            switch ($key) {
                default:
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 2) $item['data_update'][$key] = $vl + 5;
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 3) $item['data_update'][$key] = $vl + 15;
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 4) $item['data_update'][$key] = $vl + 25;
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 5) $item['data_update'][$key] = $vl + 35;
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 6) $item['data_update'][$key] = $vl + 45;
                    if (is_numeric($item['data_update'][$key]) && $vl > 0 && $item['star'] == 7) $item['data_update'][$key] = $vl * 3 + 50;
                    break;
            }
        }
        $item['data_update'] = json_encode($item['data_update']);

        return $item;
    }

    public function createmonster()
    {
        $map     = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $_SESSION['heroes']['map']]);
        if (!empty($map)) $map = $map[0];
        $hmap     = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map']]);
        $hmapboss     = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map'], 'type' => 'boss']);
        $num = count($hmap);
        if (!empty($map)) if ($num < $map['mon_length']) $monster = $this->_dungeon->getMonsterByMap($_SESSION['heroes']['map']);
        if (!empty($map)) if ($num < $map['mon_length']) $boss = $this->_dungeon->getMonsterByMap($_SESSION['heroes']['map'], 'boss');
        $rand = rand(0, 1);
        if (!empty($boss) && $rand == 1 && count($hmapboss) == 0) $monster = $boss;
        if (!empty($monster) || !empty($bosses)) while (count($monster) > 0 && ($num < $map['mon_length'])) {
            $monster = $monster[array_rand($monster)];

            $my_array = json_decode($map['background']);
            $allowed = json_decode($monster['tile_where']);
            $filtered = array_filter(
                $my_array,
                function ($key) use ($allowed) {
                    return in_array($key, $allowed);
                },
                ARRAY_FILTER_USE_BOTH
            );

            $where_random = array_rand($filtered, 1);
            $check     = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map'], 'where' => $where_random]);
            if (count($check) == 0) {
                $monsterRandom = $monster;
                unset($monsterRandom['id']);
                unset($monsterRandom['tile_where']);
                $monsterRandom['map'] = $_SESSION['heroes']['map'];
                $monsterRandom['where'] = $where_random;
                $randLV = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                $level = $randLV[rand(0, (count($randLV) - 1))];
                $monsterRandom['level'] = $level;
                $monsterRandom['exp'] = ceil($monsterRandom['exp'] + (($monsterRandom['exp'] * $level * 10) / 100));
                $monsterRandom['health'] = ceil($monsterRandom['health'] + (($monsterRandom['health'] * $level * 10) / 100));
                $monsterRandom['maxhealth'] = ceil($monsterRandom['maxhealth'] + (($monsterRandom['maxhealth'] * $level * 10) / 100));
                $monsterRandom['damage'] = ceil($monsterRandom['damage'] + (($monsterRandom['damage'] * $level * 10) / 100));
                $monsterRandom['maxdamage'] = ceil($monsterRandom['maxdamage'] + (($monsterRandom['maxdamage'] * $level * 10) / 100));
                $monsterRandom['strength'] = ceil($monsterRandom['strength'] + (($monsterRandom['strength'] * $level * 10) / 100));
                $monsterRandom['dexterity'] = ceil($monsterRandom['dexterity'] + (($monsterRandom['dexterity'] * $level * 10) / 100));
                $monsterRandom['endurance'] = ceil($monsterRandom['endurance'] + (($monsterRandom['endurance'] * $level * 10) / 100));
                $monsterRandom['wisdom'] = ceil($monsterRandom['wisdom'] + (($monsterRandom['wisdom'] * $level * 10) / 100));
                $monsterRandom['armor'] = ceil($monsterRandom['armor'] + (($monsterRandom['armor'] * $level * 10) / 100));

                $this->_dungeon->saveMonsterMap($monsterRandom);
                $num = $num + 1;
            }
            $map     = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $_SESSION['heroes']['map']])[0];
            $hmap     = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map']]);
            $hmapboss     = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map'], 'type' => 'boss']);
            $num = count($hmap);
            if ($num < $map['mon_length']) $monster = $this->_dungeon->getMonsterByMap($_SESSION['heroes']['map']);
            if ($num < $map['mon_length']) $boss = $this->_dungeon->getMonsterByMap($_SESSION['heroes']['map'], 'boss');
            $rand = rand(0, 1);
            if (!empty($boss) && $rand == 1 && count($hmapboss) == 0) $monster = $boss;
        }
    }

    public function bonus($data)
    {
        $data = (array) $data;
        $bonus = $this->_dungeon->getBonusData('*', 'dungeon_bonus', ['type' => $data['class'], 'level <=' => $data['level']])[0];
        $bonus_data = json_decode($bonus['data'], true);
        if (!empty($bonus_data)) foreach ($bonus_data as $key => $vl) {
            switch ($key) {
                default:
                    if ($vl > 0) {
                        $data[$key] = ($data[$key] + ceil(($data[$key] / 100) * $vl));
                    }
                    break;
            }
        };
        return $data;
    }

    public function __uplevel()
    {
        if (empty($_SESSION['heroes'])) return null;
        // Gán biến
        $heroes = $_SESSION['heroes'];
        // exp
        if (!empty($_SESSION['heroes']['id']))  if ($heroes['exp'] > $heroes['expmax']) {
            $newexpmax  = ($heroes['expmax'] + ceil(($heroes['level'] * 100)));
            $newhpmax = $heroes['maxhealth'] + 100;
            $newmnmax = $heroes['maxmana'] + 100;
            $newlev  = $heroes['level'] + 1;
            $newpoint = $heroes['point'] + 1;
            $upd = [
                'maxhealth' => $newhpmax,
                'maxmana' => $newmnmax,
                'exp' => 0,
                'expmax' => $newexpmax,
                'level' => $newlev,
                'point' => $newpoint
            ];
            $_SESSION['heroes']['maxhealth'] = $newhpmax;
            $_SESSION['heroes']['maxmana'] = $newmnmax;
            $_SESSION['heroes']['exp'] = 0;
            $_SESSION['heroes']['expmax'] = $newexpmax;
            $_SESSION['heroes']['level'] = $newlev;
            $_SESSION['heroes']['point'] = $newpoint;
            $this->_dungeon->updData('dungeon_uheroes', $upd, ['id' => $heroes['id']]);
        }
    }

    public function __die()
    {
        if (empty($_SESSION['heroes'])) return null;
        // Gán biến
        $heroes = $_SESSION['heroes'];
        // Die
        if (!empty($_SESSION['heroes']['id'])) if ($heroes['health'] <= 0 && $heroes['time_die'] <= time()) {
            $heroes = $this->_dungeon->getData('*', 'dungeon_heroes', ['name' => $heroes['name']])[0];
            //dd($heroes);
            $upd = [
                'map' => $heroes['map'],
                'x' => $heroes['x'],
                'health' => 1
            ];
            $_SESSION['heroes']['health'] = 1;
            $_SESSION['heroes']['map'] = $heroes['map'];
            $_SESSION['heroes']['x'] = $heroes['x'];
            $this->_dungeon->updData('dungeon_uheroes', $upd, ['id' => $heroes['id']]);
            $_SESSION['hp_rand'] = rand(1, 10);
            $_SESSION['heroes']['time_restore'] = time() + rand(5, 60);
        };
    }

    public function restore($root)
    {
        // Setup
        $heroes = $root['heroes'];
        $rd_hp = ($heroes['health'] >= $heroes['maxhealth']) ? 0 : rand(1, 25);
        $rd_mn = ($heroes['mana'] >= $heroes['maxmana']) ? 0 : rand(1, 25);
        $rd_st = ($heroes['stamina'] >= $heroes['maxstamina']) ? 0 : rand(1, 25);
        $td_tm = time() + rand(10, 50);
        if (empty($_SESSION['hp_rt'])) $_SESSION['hp_rt'] = $rd_hp;
        if (empty($_SESSION['mn_rt'])) $_SESSION['mn_rt'] = $rd_mn;
        if (empty($_SESSION['st_rt'])) $_SESSION['st_rt'] = $rd_st;
        //
        if (($heroes['time_restore'] <= time() || $heroes['time_restore'] === null) && ($rd_hp + $rd_mn + $rd_st) > 0) {
            // RS HP
            $heroes['health'] = (!empty($_SESSION['hp_rt']) && ($heroes['health'] + $_SESSION['hp_rt']) >= $heroes['maxhealth']) ? $heroes['maxhealth'] : $heroes['health'] + $_SESSION['hp_rt'];
            // RS MANA
            $heroes['mana'] = (!empty($_SESSION['mn_rt']) && ($heroes['mana'] + $_SESSION['mn_rt']) >= $heroes['maxmana']) ? $heroes['maxmana'] : $heroes['mana'] + $_SESSION['mn_rt'];
            // RS STAMINA
            $heroes['stamina'] = (!empty($_SESSION['st_rt']) && ($heroes['stamina'] + $_SESSION['st_rt']) >= $heroes['maxstamina']) ? $heroes['maxstamina'] : $heroes['stamina'] + $_SESSION['st_rt'];
            // Set new restore
            $heroes['time_restore'] = $td_tm;
            $_SESSION['hp_rt'] = $rd_hp;
            $_SESSION['mn_rt'] = $rd_mn;
            $_SESSION['st_rt'] = $rd_st;
        };
        // Update
        $_SESSION['heroes'] = $heroes;
        $this->_dungeon->updData('dungeon_uheroes', $heroes, ['id' => $heroes['id']]);
        // Return
        $sec_rt = $heroes['time_restore'] - time();
        return (($rd_hp + $rd_mn + $rd_st) == 0 || $heroes['health'] <= 0) ? "" : "<small>+$_SESSION[hp_rt] health, +$_SESSION[mn_rt] mana and +$_SESSION[st_rt] stamina in $sec_rt sec.</small>";;
    }

    public function craft($item = null, $title = null, $star = null)
    {
        if (!empty($item)) {
            if (!empty($title)) {
                if ($item['type'] != 'potion' && ($title['type'] == 1 || $title['type'] == 2)) {
                    $item['data_update'] = json_decode($item['data_update'], true);
                    if ($title['type'] == 1) $item['title'] = $item['title'] . ' ' . $title['title'];
                    if ($title['type'] == 2) $item['title'] = $title['title'] . ' ' . $item['title'];
                    if (!empty(json_decode($title['data_update'])) && ($title['type'] == 1 || $title['type'] == 2)) foreach (json_decode($title['data_update']) as $key => $vl) {
                        if (!empty($item['data_update'][$key])) {
                            $item['data_update'][$key] = $item['data_update'][$key] +  $vl;
                        } else {
                            $item['data_update'][$key] = $vl;
                        }
                    }
                    $item['data_update'] = json_encode($item['data_update']);
                    $item['gold'] = $item['gold'] + $title['gold'];
                }
            };
            return $item;
        }
    }

    public function language()
    {
        $lang = $_SERVER['PHP_SELF'];
        $cache_name = "dungeon_lang_$lang";
        $data_lang = $this->getCache($cache_name);
        if (empty($data_lang)) {
            $data_lang  = $this->_dungeon->getData('*', 'dungeon_lang', ['location' => $lang]);
            if (!empty($data_lang)) $data_lang  = $data_lang[0];
            $this->cache->save($cache_name, $data_lang, 84600);
        };
        $data = [];
        if (!empty($data_lang)) if ((empty($_SESSION['lang']))) {
            if (!empty($data_lang['en'])) $data['data_lang'] = json_decode($data_lang['en'], true);
        } else {
            if (!empty($data_lang[$_SESSION['lang']])) $data['data_lang'] = json_decode($data_lang[$_SESSION['lang']], true);
        }
        if (!empty($data['data_lang'])) return $data['data_lang'];
    }
}

class ADMIN_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view($viewMain, $data)
    {
        $data['main'] = $this->load->view($viewMain, $data, true);
        $this->load->view('admin/layout', $data);
    }
}

class Public_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function getFeeds(string $url, int $feedLimit)
    {
        $feeds = [];
        $rss_tags = array('title', 'link', 'guid', 'comments', 'description', 'pubDate', 'category');
        $rss_item_tag = 'item';
        $doc = new DOMdocument();
        $doc->load($url);
        $items = array();
        foreach ($doc->getElementsByTagName($rss_item_tag) as $node) {
            foreach ($rss_tags as $key => $value) {
                if (is_object($node->getElementsByTagName($value)->item(0))) {
                    //do your stuff
                    if ($value === 'description') {
                        $str = $node->getElementsByTagName($value)->item(0)->nodeValue;
                        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $str, $image);
                        $items['image'] = null;
                        if (!empty($image['src'])) $items['image'] = $image['src'];
                        $items[$value] = strip_tags($str);
                    } else {
                        $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
                    }
                }
            }
            array_push($feeds, $items);
        };
        if (!empty($feedLimit)) return array_slice($feeds, 0, $feedLimit);
        return $feeds;
    }
    public function pagination($table, $page = null, $limit_per_page = 10, $where = null)
    {
        // load Pagination library
        $this->load->library('pagination');
        // load URL helper
        $this->load->helper('url');
        // Load model
        $this->load->model(['Pagination_model']);
        $Data_model = new Pagination_model();
        // init params
        $params = array();
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $Data_model->getCountData($table);
        if (!empty($where)) $total_records = $Data_model->getCountDataWhe($table, $where);
        if ($total_records > 0) {
            // custom paging configuration
            $params["results"] = $Data_model->get_current_page_records($table, $limit_per_page, $start_index);
            $config['base_url'] = '?page=';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = FALSE;

            $config['full_tag_open'] = '<ul class="pagination" data-page="' . $page . '">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</span>';

            $config['cur_tag_open'] = '<li class="page-item active">';
            $config['cur_tag_close'] = '</li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);

            // build paging links
            $params = $this->pagination->create_links();
            return $params;
        }
    }

    public function breadcrumb($parent = null, $child = null, $my = null)
    {
        ///////////////////////
        $ul = '<ol class="breadcrumb">';
        $ul_end = "</ol>";
        $ul = $ul . "<li class='breadcrumb-item'><a href='" . base_url() . "'><i class='fa fa-home'></i></a></li>";
        if (!empty($parent)) {
            $ul = $ul . "<li class='breadcrumb-item'><a href='" . base_url($parent['slug']) . "'>" . $parent['title'] . "</a></li>";
        };
        if (!empty($child)) {
            $ul = $ul . "<li class='breadcrumb-item'><a href='" . base_url($child['slug']) . "'>" . $child['title'] . "</a></li>";
        };
        if (!empty($my)) {
            $ul = $ul . "<li class='breadcrumb-item active' aria-current='page'><a href='" . base_url($my['slug']) . "'>" . $my['title'] . "</a></li>";
        };
        $ul = $ul . "<li></li>" . $ul_end;
        return $ul;
    }
}
