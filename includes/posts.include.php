<?php

// make the time in facebook style
function eff_time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function eff_make_photo($data, $page){
    $photo = null;
    $photo .= "
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <img src='{$page->cover->source}' alt='Facebook page cover' border=0 style='max-height:30px' > 
                <a href='{$page->link}' class='transicion' target='_blank'> {$data->from->name} </a>
            </div>
            <div class='panel-body'>
                
                <div class='row'>
                    <div class='col-md-12'>";
                        $photo .= (isset($data->message) ? "<p>".$data->message."</p>" : '');
                        if (strpos($data->picture,'v/t1.0-9/p130x130/')) {
                            $photo .= "<img src='".str_replace("v/t1.0-9/p130x130/", "", $data->picture) ."' alt='Facebook photo' style='max-width:100%' >";
                        } elseif(strpos($data->picture,'v/t1.0-9/s130x130/')) {
                            $photo .= "<img src='".str_replace("v/t1.0-9/s130x130/", "", $data->picture) ."' alt='Facebook photo' style='max-width:100%' >";
                        }
                        $photo .= "
                    </div>
                </div>
            </div>
            <div class='panel-footer'>
                <div class='row'>
                    <div class='col-lg-8 col-md-8 col-sm-8'>
                        <i class='fa fa-clock-o'></i> ";
                            $photo .= eff_time_elapsed_string($data->created_time);
                            $photo .= "
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4'>
                        <a class='pull-right' href='{$data->link}'><i class='fa fa-facebook-square' target='_blank'></i> View</a>
                    </div>
                </div>
            </div>
        </div>
    ";

    return $photo;
}


function eff_make_status($data, $page){
    $status = null;
    $status .= "
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <img src='{$page->cover->source}' alt='Facebook page cover' border=0 style='max-height:30px' > 
                <a href='{$page->link}' class='transicion' target='_blank'> {$data->from->name} </a>
            </div>
            <div class='panel-body'>
                
                <div class='row'>
                    <div class='col-md-12'>";
                        $status .= (isset($data->message) ? "<p>".$data->message."</p>" : '');
                        $status .= "
                    </div>
                </div>
            </div>
            <div class='panel-footer'>
                <div class='row'>
                    <div class='col-lg-8 col-md-8 col-sm-8'>
                        <i class='fa fa-clock-o'></i> ";
                            $status .= eff_time_elapsed_string($data->created_time);
                            $status .= "
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4'>
                        
                    </div>
                </div>
            </div>
        </div>
    ";

    return $status;
}


function eff_make_link($data, $page){
    $link = null;
    $link .= "
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <img src='{$page->cover->source}' alt='Facebook page cover' border=0 style='max-height:30px' > 
                <a href='{$page->link}' class='transicion' target='_blank'>";
                     $link .= (isset($data->story) ? $data->story : $data->from->name);
                     $link .= "
                </a>
            </div>
            <div class='panel-body'>
                
                <div class='row'>
                    <div class='col-md-12'>";
                        $link .= (isset($data->message) ? "<p>".$data->message."</p>" : '');
                        $link .= "
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                    <div class='row'>
                                    <div class='col-md-4'>
                                        <img src='$data->picture' alt='Link photo' style='max-width:100%' >
                                    </div>
                                    <div class='col-md-8'>
                                        <p><a href='{$data->link}' target='_blank'> {$data->name}</a></p>";
                                        $link .= (isset($data->description) ? "$data->description" : '');
                                        $link .= "
                                    </div>
                                    </div>
                                </div>
                            </div>
                        ";
                        $link .= "
                    </div>
                </div>
            </div>
            <div class='panel-footer'>
                <div class='row'>
                    <div class='col-lg-8 col-md-8 col-sm-8'>
                        <i class='fa fa-clock-o'></i> ";
                            $link .= eff_time_elapsed_string($data->created_time);
                            $link .= "
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4'>
                        <a class='pull-right' href='{$data->link}' target='_blank'><i class='fa fa-facebook-square'></i> View</a>
                    </div>
                </div>
            </div>
        </div>
    ";

    return $link;
}


function eff_make_video($data, $page){
    $photo = null;
    $photo .= "
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <img src='{$page->cover->source}' alt='Facebook page cover' border=0 style='max-height:30px' > 
                <a href='{$page->link}' class='transicion' target='_blank'> {$data->from->name} </a>
            </div>
            <div class='panel-body'>
                
                <div class='row'>
                    <div class='col-md-12'>";
                        if(strpos($data->source,'fbcdn')) {
                            $photo .= "<div class='cff-html5-video'><a href='javascript:void(0);'' class='cff-html5-play' style='display: none;'><i class='fa fa-play cff-playbtn'></i></a><video src='{$data->source}' poster='{$data->picture}' style='width:100%' controls='controls'><a title='View' class='cff-vidLink' href='{$data->link}' target='_blank'><i class='fa fa-play cff-playbtn'></i><img class='cff-poster' src='{$data->picture}' alt='View'></a></video></div>";
                        } else {
                            $photo .= "<a href='{$data->link}' target='_blank'><img src='{$data->picture}' alt='Video' style='width:100%' ></a>";
                        }
                        
                       $photo .= " 
                    </div>
                </div>
            </div>
            <div class='panel-footer'>
                <div class='row'>
                    <div class='col-lg-8 col-md-8 col-sm-8'>
                        <i class='fa fa-clock-o'></i> ";
                            $photo .= eff_time_elapsed_string($data->created_time);
                            $photo .= "
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4'>
                        <a class='pull-right' href='{$data->link}' target='_blank'><i class='fa fa-facebook-square'></i> View</a>
                    </div>
                </div>
            </div>
        </div>
    ";

    return $photo;
}