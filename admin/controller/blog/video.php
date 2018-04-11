<?php

class ControllerBlogVideo extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('blog/video');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/video');
        $this->load->model('blog/ocblog');

        $this->getList();
    }

    public function add()
    {
      $this->load->language('blog/video');

      $this->document->setTitle($this->language->get('heading_title'));

      $this->load->model('blog/video');

      if (($this->request->server['REQUEST_METHOD'] == 'POST'))
      {

        $blogvideo_last_id = $this->model_blog_video->addBlogvideo($this->request->post);

        $this->session->data['success'] = $this->language->get('text_success');

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $this->response->redirect($this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true));
      }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('blog/video');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/video');

        if (($this->request->server['REQUEST_METHOD'] == 'POST'))
        {
          $this->model_blog_video->editvideo($this->request->get['blogvideo_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('blog/video');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/video');

        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $blogvideo_id) {
                $this->model_blog_video->deleteBlogvideo($blogvideo_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    public function copy()
    {
        $this->load->language('blog/videolist');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/videolist');

        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $article_list_id) {
                $this->model_blog_videolist->copyArticlesList($article_list_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('blog/videolist', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    public function getList()
    {
        $data = array();

        if (isset($this->request->get['page']))
        {
          $page = $this->request->get['page'];
        }
        else
        {
          $page = 1;
        }

        $url = '';

        if (isset($this->request->get['page']))
        {
          $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['module_id']))
        {
          $url .= '&module_id=' . $this->request->get['module_id'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_blog'),
            'href' => $this->url->link('extension/module/ocblog', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['add']    = $this->url->link('blog/video/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['copy']   = $this->url->link('blog/video/copy', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('blog/video/delete', 'token=' . $this->session->data['token'] . $url, true);

        $data['blogvideo_list'] = array();

        $filter_data = array(
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $blogvideolist_total = $this->model_blog_video->getTotalBlogvideoList();

        $results = $this->model_blog_video->getAllBlogvideoList($filter_data);

        foreach ($results as $result)
        {
          $data['blogvideo_list'][] = array(
                'blogvideo_id' => $result['id'],
                'title'        => $result['title'],
                'status'       => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'edit'         => $this->url->link('blog/video/edit', 'token=' . $this->session->data['token'] . '&blogvideo_id=' . $result['id'] . $url, true)
            );
        }

        $data['token'] = $this->session->data['token'];

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list']       = $this->language->get('text_list');
        $data['text_enabled']    = $this->language->get('text_enabled');
        $data['text_disabled']   = $this->language->get('text_disabled');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm']    = $this->language->get('text_confirm');

        $data['column_name']   = $this->language->get('column_name');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_name']     = $this->language->get('entry_name');
        $data['entry_quantity'] = $this->language->get('entry_quantity');
        $data['entry_status']   = $this->language->get('entry_status');

        $data['button_copy']   = $this->language->get('button_copy');
        $data['button_add']    = $this->language->get('button_add');
        $data['button_edit']   = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $pagination        = new Pagination();
        $pagination->total = $blogvideolist_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url   = $this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($blogvideolist_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($blogvideolist_total - $this->config->get('config_limit_admin'))) ? $blogvideolist_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $blogvideolist_total, ceil($blogvideolist_total / $this->config->get('config_limit_admin')));

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('blog/video.tpl', $data));
    }

    public function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form']     = !isset($this->request->get['blogvideo_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_none']     = $this->language->get('text_none');
        $data['text_yes']      = $this->language->get('text_yes');
        $data['text_no']       = $this->language->get('text_no');
        $data['text_default']  = $this->language->get('text_default');

        $data['entry_name']              = $this->language->get('entry_name');
        $data['entry_url']               = $this->language->get('entry_url');
        $data['entry_description']       = $this->language->get('entry_description');
        $data['entry_short_description'] = $this->language->get('entry_short_description');
        $data['entry_article_list']      = $this->language->get('entry_article_list');
        $data['entry_status']            = $this->language->get('entry_status');

        $data['help_keyword']    = $this->language->get('help_keyword');
        $data['help_category']   = $this->language->get('help_keyword');
        $data['help_intro_text'] = $this->language->get('help_intro_text');

        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['module_id'])) {
            $url .= '&module_id=' . $this->request->get['module_id'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_blog'),
            'href' => $this->url->link('extension/module/ocblog', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true)
        );

        if (!isset($this->request->get['blogvideo_id'])) {
            $data['action'] = $this->url->link('blog/video/add', 'token=' . $this->session->data['token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('blog/video/edit', 'token=' . $this->session->data['token'] . '&blogvideo_id=' . $this->request->get['blogvideo_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('blog/video', 'token=' . $this->session->data['token'] . $url, true);

        if (isset($this->request->get['blogvideo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $blogvideo_info            = $this->model_blog_video->getvideo($this->request->get['blogvideo_id']);
            $blogvideo_info['blogvideo'] = $this->model_blog_video->getBlogvdieo($this->request->get['blogvideo_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['id'])) {
            $data['id'] = $this->request->post['id'];
        } elseif (!empty($article_list_info)) {
            $data['id'] = $article_list_info['id'];
        } else {
            $data['id'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($article_list_info)) {
            $data['status'] = $article_list_info['status'];
        } else {
            $data['status'] = true;
        }

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($blogvideo_info)) {
            $data['title'] = $blogvideo_info['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->request->post['url'])) {
            $data['url'] = $this->request->post['url'];
        } elseif (!empty($blogvideo_info)) {
            $data['url'] = $blogvideo_info['url'];
        } else {
            $data['url'] = '';
        }

        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($blogvideo_info)) {
            $data['description'] = $blogvideo_info['description'];
        } else {
            $data['description'] = '';
        }

        if (isset($this->request->post['short_description'])) {
            $data['short_description'] = $this->request->post['short_description'];
        } elseif (!empty($blogvideo_info)) {
            $data['short_description'] = $blogvideo_info['short_description'];
        } else {
            $data['short_description'] = '';
        }

        $this->load->model('blog/video');

        $data['blogvideos'] = array();

        if (isset($this->request->post['article'])) {
            $articles = $this->request->post['article'];
        } elseif (!empty($article_list_info)) {
            $articles = $article_list_info['article'];
        } else {
            $articles = array();
        }

        foreach ($articles as $article) {
            $article_info = $this->model_blog_article->getArticle($article['article_id']);

            if ($article_info) {
                $data['articles'][] = array(
                    'article_id' => $article_info['article_id'],
                    'name' => $article_info['name']
                );
            }
        }

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('blog/video_form.tpl', $data));
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'blog/videolist')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateCopy()
    {
        if (!$this->user->hasPermission('modify', 'blog/video')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
