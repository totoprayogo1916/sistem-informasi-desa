<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    public function parent()
    {
        return $this->belongsTo($this, 'parrent');
    }

    public function children()
    {
        return $this->hasMany($this, 'id');
    }

    /**
     * View menu atas
     */
    public static function list_atas(): string
    {
        $getMenu   = self::where(['parrent' => '1', 'enabled' => '1', 'tipe' => '1'])->orderBy('id')->get();
        $html_menu = '';

        foreach ($getMenu as $menu) {
            $html_menu .= '<li>';
            $html_menu .= '<a href="' . site_url('first/' . $menu->link) . '">' . $menu->nama . '</a>';

            // 'SELECT s.* FROM menu s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $subMenu = self::where(['parrent' => $menu->id, 'enabled' => '1', 'tipe' => '3'])->get();

            if ($subMenu->count() > 0) {
                $html_menu .= '<ul>';

                foreach ($subMenu as $sub_menu) {
                    $html_menu .= '<li>';
                    $html_menu .= '<a href="' . site_url('first/' . $sub_menu->link) . '">' . $sub_menu->nama . '</a>';
                    $html_menu .= '</li>';
                }
                $html_menu .= '</ul>';
            }

            $html_menu .= '</li>';
        }

        return $html_menu;
    }
}
