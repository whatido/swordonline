<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('colorStar')) {
    function colorStar($item)
    {
        if ($item['star'] == 1) return '<span style="color: #d1d1d1">' . $item['title'] . '</span>';
        if ($item['star'] == 2) return '<span style="color: #1eff00">' . $item['title'] . '</span>';
        if ($item['star'] == 3) return '<span style="color: #0070ff">' . $item['title'] . '</span>';
        if ($item['star'] == 4) return '<span style="color: #a335ee">' . $item['title'] . '</span>';
        if ($item['star'] == 5) return '<span style="color: #ff9800">' . $item['title'] . '</span>';
        if ($item['star'] == 6) return '<span style="color: #c34949">' . $item['title'] . '</span>';
        if ($item['star'] == 7) return '<span style="color: #21b6a8">' . $item['title'] . '</span>';
    }
}

if (!function_exists('viewDataItem')) {
    function viewDataItem($item)
    {
        if (!is_array($item)) $item = json_decode($item);
        $item = (object) $item;
        $newitem = [];
        if (!empty($item->damage)) $newitem['damage'] = (string)$item->damage;
        if (!empty($item->maxdamage)) $newitem['maxdamage'] = (string)$item->maxdamage;
        if (!empty($item->armor)) $newitem['armor'] = (string)$item->armor;
        if (!empty($item->magic_resistance)) $newitem['magic_resistance'] = (string)$item->magic_resistance;
        if (!empty($item->health)) $newitem['health'] = (string)$item->health;
        if (!empty($item->mana)) $newitem['mana'] = (string)$item->mana;
        if (!empty($item->strength)) $newitem['strength'] = (string)$item->strength;
        if (!empty($item->dexterity)) $newitem['dexterity'] = (string)$item->dexterity;
        if (!empty($item->endurance)) $newitem['endurance'] = (string)$item->endurance;
        if (!empty($item->wisdom)) $newitem['wisdom'] = (string)$item->wisdom;
        if (!empty($item->life_leech)) $newitem['life_leech'] = (string)$item->life_leech;
        if (!empty($item->water)) $newitem['water'] = (string)$item->water;
        if (!empty($item->fire)) $newitem['fire'] = (string)$item->fire;
        if (!empty($item->wind)) $newitem['wind'] = (string)$item->wind;
        if (!empty($item->earth)) $newitem['earth'] = (string)$item->earth;

        return $newitem;
    }
}

if (!function_exists('countBag')) {
    function countBag()
    {
        $ci = &get_instance();
        // Get data from db
        $ci->db->select("*");
        $ci->db->where(["user" => $_SESSION['heroes']['id']]);
        $ci->db->where(["equip" => '0']);
        $query = $ci->db->get('dungeon_uitems');
        $item = $query->result_array();

        if (count($item) < $_SESSION['heroes']['max_inventory']) {
            return count($item);
        } else {
            return 'FULL';
        };
    }
}

if (!function_exists('viewListItem')) {
    function viewListItem($item)
    {
        $html = '';
        if (!empty($item)) foreach ($item as $key => $list) :
            $html .= '<div class="d-flex bd-highlight">';
            $html .= '<div class="p-2 flex-grow-1 bd-highlight">';
            $html .= '<a href="' . base_url('dungeon/item/info/' . $list[0]['id']) . '">';
            if (count($list) > 1) $html .= 'x' . count($list) . ' ';
            $html .= $key . '</a>';
            if ($list[0]['star'] == 2) $html .= '<span class="small" style="color: #1eff00">[Uncommon]</span>';
            if ($list[0]['star'] == 3) $html .= '<span class="small" style="color: #0070ff">[Rare]</span>';
            if ($list[0]['star'] == 4) $html .= '<span class="small" style="color: #a335ee">[Epic]</span>';
            if ($list[0]['star'] == 5) $html .= '<span class="small" style="color: #ff9800">[Mythic]</span>';
            if ($list[0]['star'] == 6) $html .= '<span class="small" style="color: #c34949">[Heroic]</span>';
            if ($list[0]['star'] == 7) $html .= '<span class="small" style="color: #21b6a8">[Divine]</span>';
            $html .= '</div>';
            $html .= '<div class="p-2 bd-highlight">';
            if ($list[0]['type'] == 'potion') :
                $html .= '<a href="' . base_url('dungeon/item/info/' . $list[0]['id'] . '?status=use') . '">[Use]</a>';
            endif;
            $html .= '</div>';
            $html .= '<div class="p-2 bd-highlight">';
            $html .= '<img src="' . base_url('dungeon/images/icon/gold.png') . '" width="16px" alt="">';
            $html .= '<img src="' . base_url('public/dungeon/images/icon/gold.png') . '" alt="">' . $list[0]['gold'];
            $html .= '</div>';
            $html .= '</div>';
        endforeach;
        return $html;
    }
}

if (!function_exists('matchMap2')) {
    function matchMap2($location, $map)
    {
        $data = [];
        $mapData = $map['background'];
        // row 1
        $min = (floor(($location / $map['x'])) - 2) * $map['x']; // ô giới hạn bên trái
        $locl = $location - ($map['x'] * 2) - 2;
        if ($locl < $min) $locl = $min;$locr = $locl + 4;
        $max = $min + $map['x'] - 1; // ô giới hạn bên phải
        if ($locr >= $max) $locr = $max;
        $locl = $locr - 4;
        for ($i = $locl; $i <= $locr; $i++) {
            if (!empty($mapData[$i]) && $i < ($map['x'] * $map['y'])) $data[$i] = $mapData[$i];
        };
        //
        // row 2
        $min = (floor(($location / $map['x'])) - 1) * $map['x'];
        $locl = $location - ($map['x']) - 2;
        if ($locl < $min) $locl = $min;$locr = $locl + 4;
        $max = $min + $map['x'] - 1;
        if ($locr >= $max) $locr = $max;$locl = $locr - 4;
        for ($i = $locl; $i <= $locr; $i++) {
            if (!empty($mapData[$i]) && $i < ($map['x'] * $map['y'])) $data[$i] = $mapData[$i];
        };
        //
        // row 3
        $min = (floor(($location / $map['x']))) * $map['x'];
        $locl = $location - 2;
        if ($locl < $min) $locl = $min;$locr = $locl + 4;
        $max = $min + $map['x'] - 1;
        if ($locr >= $max) $locr = $max;$locl = $locr - 4;
        for ($i = $locl; $i <= $locr; $i++) {
            if (!empty($mapData[$i]) && $i < ($map['x'] * $map['y'])) $data[$i] = $mapData[$i];
        };
        //
        // row 4
        $min = (floor(($location / $map['x'])) + 1) * $map['x'];
        $locl = $location + $map['x'] - 2;
        if ($locl < $min) $locl = $min;$locr = $locl + 4;
        $max = $min + $map['x'] - 1;
        if ($locr >= $max) $locr = $max;$locl = $locr - 4;
        for ($i = $locl; $i <= $locr; $i++) {
            if (!empty($mapData[$i]) && $i < ($map['x'] * $map['y'])) $data[$i] = $mapData[$i];
        };
        //
        // row 5
        $min = (floor(($location / $map['x'])) + 2) * $map['x'];
        $locl = $location + $map['x'] + 9;
        if ($map['x'] == 5) $locl = $location + $map['x'] + 8;
        if ($locl < $min) $locl = $min;
        $locr = $locl + 4;
        $max = $min + $map['x'] - 1;
        if ($locr >= $max) $locr = $max;
        $locl = $locr - 4;
        for ($i = $locl; $i <= $locr; $i++) {
            if (!empty($mapData[$i]) && $i < ($map['x'] * $map['y'])) $data[$i] = $mapData[$i];
        };
        //
        return $data;
    };
};

if (!function_exists('matchMap')) {
    function matchMap($location, $map)
    {
        $data = [];
        $data = $map['background'];
        
        //
        return $data;
    };
};

if (!function_exists('requirements')) {
    function requirements()
    {
        
    };
};

if (!function_exists('langTrans')) {
    function langTrans($location, $lang = 'vi')
    {
    };
};
