<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    $config['num_links'] = 3;
    $config['enable_query_strings'] = TRUE;
    $config['use_page_numbers'] = TRUE;
    /*SET PARAM PAGE*/
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    /*SET PARAM PAGE*/
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '';
    $config['first_tag_close'] = '';
    $config['next_tag_open'] = '<li class="next">';
    $config['next_tag_close'] = '';
    $config['prev_tag_open'] = '<li class="pre">';
    $config['prev_tag_close'] = '';
    $config['cur_tag_open'] = '<li class="num active"><a href="javascript:;" title="Trang hiện tại">';
    $config['cur_tag_close'] = '</a>';
    $config['num_tag_open'] = '<li class="num">';
    $config['num_tag_close'] = '';
    $config['last_tag_open'] = '<li class="last">';
    $config['last_tag_close'] = '';
    $config['first_link'] = '&laquo;';
    $config['last_link'] = '&raquo;';
    $config['prev_link'] = '<span aria-hidden="true">&lsaquo;</span>';
    $config['next_link'] = '<span aria-hidden="true">&rsaquo;</span>';
    $config['display_pages'] = true;