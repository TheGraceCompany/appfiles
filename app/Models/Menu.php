<?php

namespace App\Models;

use URL;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Page\PageRepository;
use App\Repositories\PhotoGallery\PhotoGalleryRepository;

/**
 * Class Menu.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Menu extends Model
{
    public $table = 'menus';
    protected $fillable = ['title', 'url', 'order', 'type', 'selected'];

    /**
      * @method getMaxOrder
      * @public
      * @return {any}
      */
    public function getMaxOrder()
    {
        $menu = $this->where('lang', getLang())->orderBy('order', 'desc')->first();
        if (isset($menu)) {
            return $menu->order;
        }

        return 0;
    }

	/**
	 * @method generateMenu
	 * @public
	 * @param {any} $menu
	 * @param {any} [$parentId = 0]
	 * @return null|string
	 */
    public function generateMenu($menu, $parentId = 0)
    {
        $result = null;

        foreach ($menu as $item) {
            if ($item->parent_id == $parentId) {
                $imageName = ($item->is_published) ? 'publish_16x16.png' : 'not_publish_16x16.png';

                $result .= "<li class='dd-item' data-id='{$item->id}'>
                                            <button type='button' data-action='collapse'>Collapse</button>
                                            <button type='button' data-action='expand' style='display: none;'>Expand</button>
                                            <div class='dd-handle'></div>
                                            <div class='dd-content'><span>{$item->title}</span>
                                            <div class='ns-actions'>
                                            <a title='Publish Menu' id='{$item->id}' class='publish' href='#'><img id='publish-image-".$item->id."' alt='Publish' src='".url('/').'/assets/images/'.$imageName."'></a>
                                            <a title='Edit Menu' class='edit-menu' href='".langRoute('admin.menu.edit', $item->id)."'><img alt='Edit' src='".url('/').'/assets/images/edit.png'."'></a>
                                            <a class='delete-menu' href='".URL::route('admin.menu.delete', $item->id)."'><img alt='Delete' src='".url('/').'/assets/images/cross.png'."'></a><input type='hidden' value='1' name='menu_id'>
                                            </div>
                                            </div>".$this->generateMenu($menu, $item->id)."</li>";
                }
            }


        return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
    }

    /**
      * @method getMenuHTML
      * @public
      * @param {any} $items
      * @return {any}
      */
    public function getMenuHTML($items)
    {
        return $this->generateMenu($items);
    }

    /**
      * @method parseJsonArray
      * @public
      * @param {any} $jsonArray
      * @param {any} [$parentID = 0]
      * @return {any}
      */
    public function parseJsonArray($jsonArray, $parentID = 0)
    {
        $return = array();

        foreach ($jsonArray as $subArray) {
            $returnSubArray = array();

            if (isset($subArray['children'])) {
                $returnSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
            }

            $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
            $return = array_merge($return, $returnSubArray);
        }

        return $return;
    }

    /**
      * @method changeParentById
      * @public
      * @param {any} $data
      */
    public function changeParentById($data)
    {
        foreach ($data as $k => $v) {
            $item = $this->find($v['id']);
            $item->parent_id = $v['parentID'];
            $item->order = $k + 1;
            $item->save();
        }
    }

    /**
      * @method hasChildItems
      * @public
      * @param {any} $id
      * @return {any}
      */
    public function hasChildItems($id)
    {
        $count = $this->where('parent_id', $id)->where('lang', getLang())->where('is_published', 1)->get()->count();
        if ($count === 0) {
            return false;
        }

        return true;
    }

    /**
      * @method getMenuOptions
      * @public
      * @return {any}
      */
    public function getMenuOptions()
    {
        $opts = array();
        $page = new PageRepository(new Page());
        $pageOpts = $page->lists();

        foreach ($pageOpts as $k => $v) {
            $opts['Page']['App\Models\Page-'.$k] = $v;
        }

        $photoGallery = new PhotoGalleryRepository(new PhotoGallery());
        $photoGalleryOpts = $photoGallery->lists();

        foreach ($photoGalleryOpts as $k => $v) {
            $opts['PhotoGallery']['App\Models\PhotoGallery-'.$k] = $v;
        }

        $menuOptions = array(
            'General' => array(
            'home' => 'Home',
            'automation' => 'Automation',
            'blog' => 'Blog',
            'contact' => 'Contact',
            'events' => 'Events',
            'faq' => 'Faq',
            'hand-quilting' => 'Hand Quilting',
            'machine-frames' => 'Machine Frames',
            'news' => 'News',
            'project' => 'Project',
            'add-ons' => 'Add-Ons',
            'community' => 'Community',
            'qnique' => 'Qnique',
            'sewing-machines' => 'Sewing Machines',
            'shop' => 'Shop',
            'truecut' => 'True Cut',
            'videos' => 'Videos', ),
            'Page' => (isset($opts['Page']) ? $opts['Page'] : array()),
            'Photo Gallery' => (isset($opts['PhotoGallery']) ? $opts['PhotoGallery'] : array()), );

        return $menuOptions;
    }

       /**
         * @method getUrl
         * @public
         * @param {any} $option
         * @return {any}
         */
       public function getUrl($option)
    {
        $url = '';

        switch ($option) {

            case 'home':                    $url = "/";                                     break;
            case 'add-ons':                    $url = "/add-ons";                                     break;
            case 'automation':              $url = "/automation/qct";                   break;
            case 'blog':                    $url = '/community/blog';                   break;
            case 'contact':                     $url = '/contact';                              break;
            case 'events':                      $url = "/community/events";                 break;
            case 'faq':                         $url = '/community/faq';                    break;
            case 'hand-quilting':       $url = "/hand-quilting";                    break;
            case 'machine-frames':  $url = "/machine-frames";                   break;
            case 'news':                        $url = '/community/news';                   break;
            case 'project':                     $url = '/community/project';                break;
            case 'qnique':                      $url = "/sewing-machines/qnique";       break;
            case 'community':               $url = "/community";                        break;
            case 'sewing-machines':         $url = "/sewing-machines/qnique";       break;
            case 'shop':                        $url = "/shop";                                 break;
            case 'truecut':                     $url = "/truecut";                          break;
            case 'videos':                      $url = "/community/videos";                 break;

            default: $url = $this->getModuleUrl($option); break; }

        $url = '/'.getLang().'/'.ltrim($url, '/');

        return $url;
    }

    /**
      * @method getModuleUrl
      * @public
      * @param {any} $option
      * @return {any}
      */
    public function getModuleUrl($option)
    {
        $pieces = explode('-', $option);
        $reflection = new \ReflectionClass(ucfirst($pieces[0]));

        $module = $reflection->newInstance();
        $module = $module::find($pieces[1]);

        return $module->url;
    }

    /**
      * @method generateFrontMenu
      * @public
      * @param {any} $menu
      * @param {any} [$parentId = 0]
      * @param {any} [$starter = false]
      * @return {any}
      */
    public function generateFrontMenu($menu, $parentId = 0, $starter = false)
    {
        $result = null;

        foreach ($menu as $item) {
            if ($item->parent_id == $parentId) {
                $childItem = $this->hasChildItems($item->id);

                $result .= "<li class='menu-item ".(($childItem) ? 'dropdown' : null).(($childItem && $item->parent_id != 0) ? ' dropdown-submenu' : null)."'>
                                <a href='".url($item->url)."' ".(($childItem) ? 'class="dropdown-toggle" data-toggle="dropdown"' : null).">{$item->title}".(($childItem && $item->parent_id == 0) ? '<b class="caret"></b>' : null).'</a>'.$this->generateFrontMenu($menu, $item->id).'
                            </li>';
            }
        }

        return $result ? "\n<ul class='".(($starter) ? ' nav navbar-nav navbar-right ' : null).((!$starter) ? ' dropdown-menu ' : null)."'>\n$result</ul>\n" : null;
    }

    /**
      * @method getFrontMenuHTML
      * @public
      * @param {any} $items
      * @return {any}
      */
    public function getFrontMenuHTML($items)
    {
        return $this->generateFrontMenu($items, 0, true);
    }
}
