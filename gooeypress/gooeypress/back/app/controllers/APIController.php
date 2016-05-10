<?php

class APIController extends BaseController {

	public function yslow($id)
	{
        $theme = Theme::findOrFail($id);

        $request = Request::instance();

        $yslow = json_decode($request->getContent());
        $yslow->comps = [];


        $theme->yslow = json_encode($yslow);
        $theme->save();
	}

}
