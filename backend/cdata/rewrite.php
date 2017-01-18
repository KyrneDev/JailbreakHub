<?php
// description: Rewrite url plugin.

add_hook('cnsc_files', 'add_htaccess_to_check_perm');
function add_htaccess_to_check_perm($check_files)
{
    $check_files[] = '/.htaccess';
    return $check_files;
}

if (getoption('#installed:rewrite') == 0)
{
    add_hook('more_options', 'add_install_rw_to_options');
    add_hook('options_additional_actions', 'run_rw_install');

    function add_install_rw_to_options($options)
    {
        $PHP_SELF = PHP_SELF;

        $options[] = array
        (
            'name'              => lang('Install rewrite plugin', 'options'),
            'url'               => "$PHP_SELF?mod=options&action=rewriteinst",
            'access'            => ACL_LEVEL_ADMIN,
        );

        return $options;
    }

    function set_default_htaccess_path($path)
    {
        include SERVDIR.'/cdata/plugins/rewrite/conf_rw.php';
        $conf_rw_arr = get_defined_vars();
        $conf_rw_arr['conf_rw_htaccess'] = $path;
        unset($conf_rw_arr['path']);

        $fail = array();
        $cf = fopen(SERVDIR.'/cdata/plugins/rewrite/conf_rw.php', 'w');
        if(!$cf) $fail[] = array('Cannot open the file ', SERVDIR.'/cdata/plugins/rewrite/conf_rw.php');
        flock($cf, LOCK_EX);
        fwrite($cf, '<'."?php\n");
        foreach($conf_rw_arr as $varName=>$varValue)
            fwrite($cf, '$'.$varName.' = "'.$varValue."\";\n");
        fwrite($cf, "?>");
        flock($cf, LOCK_UN);
        fclose($cf);

        return $fail;
    }

    function run_rw_install()
    {
        global $member_db;

        if (REQ('action','GET') == 'rewriteinst')
        {
            if ($member_db[UDB_ACL] != ACL_LEVEL_ADMIN)
                msg("error", lang("Access Denied"), lang("You don't have permission for this section", '#GOBACK'));

            if(is_writable(SERVDIR))
            {
                require SERVDIR."/core/zip.class.php";
                $zipfile = new zipfile;
                $zipfile->read_zip(SERVDIR.'/cdata/plugins/rewrite/main_htaccess.zip');

                $fail = array();

                foreach($zipfile->files as $filea)
                {
                    $w = fopen(SERVDIR.'/'.$filea['name'], 'w');
                    if(!$w) $fail[] = array('Cannot open the file ', SERVDIR.'/'.$filea['name']);
                    if(!fwrite($w, $filea['data'])) $fail[] = array('Cannot create the file', SERVDIR.'/'.$filea['name']);
                    fclose($w);
                }

                $fail = array_merge($fail, set_default_htaccess_path(SERVDIR.'/'.$filea['name']));

                setoption('#installed:rewrite', 1);

                if(count($fail) == 0) unlink(SERVDIR.'/cdata/plugins/rewrite/main_htaccess.zip');

                $found_problems = proc_tpl('install/problemlist', array('fail' => $fail, 'problemlist_title'=>'Some problem occurred by install the rewrite plugin'));
                if(empty($found_problems))
                {
                    $result_title = lang('Installation success');
                    $result_text = lang("Congrats! You installed rewrite plugin."). " | <a href='../index.php'>Main page</a> ";
                }
                else
                {
                    $result_title = lang('Installation error');
                    $result_text = "Cannot install automatic. Please, unzip main_htaccess.zip from plugins folder to the root of the site manualy. Also study mistakes in the table given below.".$found_problems;
                }
                msg('info', $result_title, $result_text);
            }
            else
            {
                if(file_exists(SERVDIR.'/.htaccess'))
                    setoption('#installed:rewrite', 1);
                msg('info', lang('Installation error'), "Cannot install automatic. Please, unzip main_htaccess.zip from plugins folder to the root of the site manualy.| <a href='../index.php'>Main page</a> ");
            }
        }
    }
}
else
{
    add_hook('options_additional_actions', 'rewrite_options');
    add_hook('more_options', 'rewrite_options_link');

    add_hook('rewrite_active_news_plink', 'change_an_links');
    add_hook('rewrite_active_news_nlink', 'change_an_links');
    add_hook('rewrite_active_news_link', 'change_an_links');

    add_hook('rewrite_allow_comments_nlink', 'change_ac_links');
    add_hook('rewrite_allow_comments_plink', 'change_ac_links');
    add_hook('rewrite_allow_comments_link', 'change_ac_links');

    add_hook('init_header_after', 'init_global_rewrite');
    add_hook('field_options_general', 'add_option_to_syscon');

    add_hook('rewrite_com_link_template_url', 'change_com_link_template_url');
    add_hook('rewrite_link_template_url', 'change_link_and_fulllink_template_url');
    add_hook('rewrite_full_link_template_url', 'change_link_and_fulllink_template_url');

    add_hook('rewrite_url_in_search', 'change_url_in_search');
    add_hook('rewrite_link_in_archives', 'change_archive_url');
    add_hook('rewrite_add_comment_url', 'change_ac_links');

    function add_option_to_syscon()
    {
        echo syscon('use_replacement',      'Custom rewrite|allow rewrite news url path', 'Y/N');
    }

    function rewrite_options_link($options)
    {
        global $config_use_replacement;

        $PHP_SELF = PHP_SELF;

        if ($config_use_replacement)
        {
            $options[] = array(
                'name'              => lang('URL Rewrite manager', 'options'),
                'url'               => "$PHP_SELF?mod=options&action=rewrite",
                'access'            => ACL_LEVEL_ADMIN,
            );
        }

        return $options;
    }

    function rewrite_options()
    {
        global $member_db, $config_use_replacement;

        $PHP_SELF = PHP_SELF;

        if ($config_use_replacement && REQ('action','GETPOST') == 'rewrite')
        {
            if ($member_db[UDB_ACL] != ACL_LEVEL_ADMIN)
                msg("error", lang("Access Denied"), lang("You don't have permissions to access this section"), '#GOBACK');

            $subaction = REQ('subaction','POST');
            $update_htaccess = REQ('update_htaccess','POST');

            if ($subaction == 'save')
            {
                $w = fopen(SERVDIR.'/cdata/plugins/rewrite/conf_rw.php', 'w');
                if(!$w) $message = getpart('saved_not_ok', array('Cannot open the file: '.SERVDIR.'/cdata/plugins/rewrite/conf_rw.php'));
                flock($w, LOCK_EX);
                fwrite($w, '<'."?php\n");
                foreach ($_REQUEST as $i => $v)
                    if (substr($i, 0, 5) == 'conf_')
                        fwrite( $w, '$conf_rw_'.substr($i, 5).' = "'.str_replace('"', '\"', $v) . "\";\n" );
                flock($w, LOCK_UN);
                fclose($w);

                if(!$message) $message = getpart('saved_ok');

                // Read data from datatable
                if (file_exists(SERVDIR.'/cdata/plugins/rewrite/conf_rw.php'))
                {
                    include ( SERVDIR.'/cdata/plugins/rewrite/conf_rw.php' );
                    $varsarr = get_defined_vars();
                    foreach($varsarr as $varName => $varValue)
                    {
                        if(substr($varName, 0, 8) == 'conf_rw_')
                            $GLOBALS[$varName] = $varValue;
                    }
                }
            }

            // Try to update htaccess
            if ($update_htaccess == 'Y')
            {
                $w = fopen($conf_rw_htaccess, 'w');
                flock($w, LOCK_EX);
                fwrite($w, "RewriteEngine ON\n");
                fwrite($w, "RewriteCond %{REQUEST_FILENAME} !-d\n");
                fwrite($w, "RewriteCond %{REQUEST_FILENAME} !-f\n");
                fwrite($w, "RewriteRule ^(.*)\$ cdata/plugins/rewrite/cn_friendly_url.php?rew=\$1&%{QUERY_STRING}[L]\n");
                flock($w, LOCK_UN);
                fclose($w);
            }

            // view template
            echoheader('home', lang('URL Rewrite Manager'), make_breadcrumbs('main=main/options:options=options/options:rewrite=Rewrite Manager', true));
            echo proc_tpl
            (
                '/rewrite/index',
                array
                (
                    'message' => $message
                )
            );
            echofooter();
        }
    }

    function change_an_links($URL)
    {
        global $url_archive, $config_http_script_dir;

        $type = ($url_archive) ? 'archpage' : 'newspage';
        $URL = $config_http_script_dir.RWU($type, $URL);

        return $URL;
    }

    function change_ac_links($data)
    {
        global $archive, $config_http_script_dir;

        list($URL, $news_arr) = $data;

        $type = ($archive) ? 'archcommpage' : 'commpage';

        $URL = add_title_to_url($URL, $news_arr[NEW_TITLE]);
        $URL = $config_http_script_dir.RWU($type, $URL);

        return array($URL, $news_arr);
    }

    function init_global_rewrite()
    {
        global $config_use_replacement;
        if ($config_use_replacement && file_exists(SERVDIR.'/cdata/plugins/rewrite/conf_rw.php'))
        {
            include (SERVDIR.'/cdata/plugins/rewrite/conf_rw.php');
            $varsarr = get_defined_vars();
            foreach($varsarr as $varName => $varValue)
                $GLOBALS[$varName] = $varValue;
        }
    }

    function change_com_link_template_url($data)
    {
        global $archive, $config_http_script_dir;
        list($URL, $news_arr) = $data;

        $type = ($archive) ? 'archreadcomm' : 'readcomm';
        $URL = add_title_to_url($URL, $news_arr[NEW_TITLE]);
        $URL = $config_http_script_dir.RWU($type, $URL);

        return array($URL, $news_arr);
    }

    function change_link_and_fulllink_template_url($data)
    {
        global $archive, $config_http_script_dir;
        list($URL, $news_arr) = $data;

        $type = ($archive) ? 'archreadmore' : 'readmore';
        $URL = add_title_to_url($URL, $news_arr[NEW_TITLE]);
        $URL = $config_http_script_dir.RWU($type, $URL);

        return array($URL, $news_arr);
    }

    function change_url_in_search($data)
    {
        global $config_http_script_dir, $archive;

        list($URL, $title) = $data;

        $type = ($archive) ? 'archreadmore' : 'readmore';
        $URL = add_title_to_url($URL, $title);
        $URL = $config_http_script_dir.RWU($type, $URL);

        return array($URL, $title);
    }

    function change_archive_url($arch_url)
    {
        global $config_http_script_dir;

        $arch_url = $config_http_script_dir.RWU('archread', $arch_url);

        return $arch_url;
    }

    // Manual replacements in URLs --------------
    // $type - apply template
    function RWU($type = 'readmore', $url, $html = true)
    {
        global $config_use_replacement;

        // Disable to use mod_rewrite ---> it is a safe way
        if (!$config_use_replacement) return $url;

        // get default template
        $tpl    = $GLOBALS["conf_rw_$type"];
        $layout = $GLOBALS["conf_rw_{$type}_layout"];
        $adds   = array();

        // If url contains PHP_SELF and html [&amp;], remove it
        $url = str_replace( '&amp;', '&', $url );
        if (preg_match('~.*?\?(.*)$~', $url, $ourl)) $url = $ourl[1];

        // Make parts with replace: if param not present, out it at query string
        $parts = explode('&', $url);
        foreach ($parts as $v)
        {
            list($c, $s) = explode('=', $v, 2);
            if (empty($c)) continue;

            /* If in template is %var template, replace it */
            if (strpos($tpl, '%'.$c) !== false) $tpl = str_replace('%'.$c, $s, $tpl);

            /* If in layout variable present key, skip */
            elseif (!preg_match('~'.$c.'\='.$s.'~i', $layout)) $adds[] = "$c=$s";
        }

        // Set unused as 0
        $tpl = preg_replace('~\%\w+~', '0', $tpl);

        if (count($adds)) $tpl .= '?'.implode(($html?'&amp;':'&'), $adds);
        return $tpl;
    }

    function neat_title($title)
    {
        if(preg_match('|&#\d{0,4};|',trim($title)))
            $title = mb_convert_encoding($title, 'UTF-8', 'HTML-ENTITIES');

        return url_slug($title, array('delimiter' => '_', 'transliterate' => true, 'limit' => 40));
    }


    /**
     * Create a web friendly URL slug from a string.
     *
     * Although supported, transliteration is discouraged because
     * 1) most web browsers support UTF-8 characters in URLs
     * 2) transliteration causes a loss of information
     *
     * @author Sean Murphy <sean@iamseanmurphy.com>
     * @copyright Copyright 2012 Sean Murphy. All rights reserved.
     * @license http://creativecommons.org/publicdomain/zero/1.0/
     *
     * @param string $str
     * @param array $options
     * @return string
     */
    function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    function add_title_to_url($URL, $title)
    {
        global $config_use_replacement;

        if(!$config_use_replacement) return $URL;

        return substr_replace($URL, '&title='.neat_title($title), strpos($URL, '&'), 0);
    }
}
?>