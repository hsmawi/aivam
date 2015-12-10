<?php

class Controller_Admin_Rest_Models extends Controller_Rest
{

	public function get_list()
    {
        $query = DB::select(array("model", "title"))->from('items');

        if(Input::get('make')) {
            $query->where('make', Input::get('make'));
        }

        $items = $query->distinct(true)
                       ->order_by('model','asc')
                       ->execute();

        return $this->response($items);
    }

    public function post_model()
    {
        $title = Input::post('title');

        $entry = Model_Model::find('all', array(
            'where' => array(
                array('title', $title)
            )
        ));

        if(!count($entry)) {
            $item = new Model_Model();
            $item->title = $title;
            $item->save();
        }

        return $this->response(array(
            'status' => 'ok',
            'count' => count($entry)
        ));
    }


}