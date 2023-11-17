<?php

namespace TypechoPlugin\TypechoPluginPostViews;

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 文章访问的时候，contents 表的 views 字段自增 1。注意：表中要新建 views 字段，不优雅
 *
 * @package PostViews
 * @author gggwvg
 * @version 1.0.0
 * @link https://jian.wang
 */
class Plugin implements PluginInterface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        \Typecho\Plugin::factory('Widget_Archive')->afterRender = __CLASS__ . '::incrViews';
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config(Form $form)
    {
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function incrViews($archive)
    {
        $db = \Typecho\Db::get();
        $prefix = $db->getPrefix();
        $db->query($db->update($prefix . 'contents')->expression('views', 'views+1')->where('cid = ?', $archive->cid));
    }
}
