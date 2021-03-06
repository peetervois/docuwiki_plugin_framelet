<?php 

/**
 * Framemaker for framelet plugin
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Peeter Vois <peeter@tauria.ee>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

function framemaker( $data )
{
    global $REV;
    global $ID;
    
    $rv = "";
    $rv .= '<form class="" method="post" action="'.DOKU_BASE.'doku.php">';
    $rv .= '<div class="no">';
    $rv .= '<input type="hidden" name="do" value="edit">';
    $rv .= '<input type="hidden" name="rev" value="'.$data['rev'].'">'; 
    $rv .= '<input type="hidden" name="summary" value="[framelet] ">';
    $rv .= '<input type="hidden" name="target" value="plugin_framelet">';
    $rv .= '<input type="hidden" name="iframeparams" value="'.$data["iframeparams"].'">';
    $rv .= '<input type="hidden" name="iframedivid" value="'.$data["iframedivid"].'">';
    $rv .= '<input type="hidden" name="iframehref" value="'.$data["iframehref"].'">';
    $rv .= '<input type="hidden" name="range" value="'.$data["bytepos_start"]."-".$data["bytepos_end"].'">';
    //$rv .= '<input type="hidden" name="hid" value="">';
    $rv .= '<input type="hidden" name="id" value="'.$ID.'">';
    $rv .= '<input type="hidden" name="framewidth" value="'.$data["framewidth"].'">';
    $rv .= '<input type="hidden" name="frameheight" value="'.$data["frameheight"].'">';
    $rv .= '<button type="submit" >Edit</button><br>';
    $rv .= '</div>';
    $rv .= '</form>';
    //
    $rv .= '<input type="hidden" id="'. $data["iframedivid"].'_data" name="B64JSON" value="'. $data["database"] .'" >';
    $rv .= '<div id="'. $data["iframedivid"].'_ifdiv"'.
        ' iframerequestwidth="'. $data["framewidth"].'"'.
        ' iframerequestheight="'. $data["frameheight"].'"'.
        ' style="width:100%; height:'.$data["frameheight"].'px; margin:0px; padding:0px; border-width:0px" >'; // this div is used for autoscaling
    $rv .= '<iframe ' .base64_decode($data["iframeparams"]).
    ' id="'. $data["iframedivid"].'_frame" frameborder=0 '.
    ' src=" ' . DOKU_BASE . $data["iframehref"] .'" ></iframe>';
    $rv .= '</div>';
    $rv .= '<script type="text/javascript" defer="defer">framelet_push("'.$data['iframedivid'].'")</script>';
    
    
    return $rv;
}

function frameoverlaystyle( $width )
{
    $style = ' style="';
    $style .= "position: fixed; "; /* Stay in place */
    $style .= "z-index: 1; "; /* Sit on top */
    $style .= "padding-top: 0px; "; /* Location of the box */
    $style .= "left: 0px; ";
    $style .= "top: 0px; ";
    $style .= "min-width: ".$width."; "; /* Full width */
    $style .= "height: 100%; "; /* Full height */
    $style .= "overflow: auto; "; /* Enable scroll if needed */
    $style .= "background-color: rgb(200,200,200); "; /* Fallback color */
    $style .= "background-color: rgba(209, 215, 211, 0.9); "; /* Black w/ opacity */
    $style .= "-webkit-transform-origin: 0 0;";
    $style .= '" ';
    return $style;
}

function frameedit( $data )
{
    $style = frameoverlaystyle($data["framewidth"]."px");
    if( $data["framewidth"] <= 0 ){
        $style = frameoverlaystyle("100%");
    }
    $rv = "";
    $rv .= '<input type="hidden" id="'. $data["iframedivid"].'_data" name="B64JSON" value="'. $data["database"] .'" >';
    //$rv .= '<input type="button" onclick="framelet_pull('."'".$data['iframedivid']."'".')" value="SAVE">';
    //$rv .= '<input type="button" onclick="framelet_push('."'".$data['iframedivid']."'".')" value="REVERT">';
    $rv .= '<div id="'. $data["iframedivid"].'_ifdiv"'.
        ' iframerequestwidth="'. $data["framewidth"].'"'. 
        ' iframerequestheight="'. $data["frameheight"].'"'.
        frameoverlaystyle("100%").
        ' >'; // this div is used for autoscaling
        $rv .= '<iframe ' .$style.
        ' id="'. $data["iframedivid"].'_frame" frameborder=0 '.
        ' src=" ' . DOKU_BASE . $data["iframehref"] .'" ></iframe>';
    $rv .= '</div>';
    $rv .= '<script type="text/javascript" defer="defer">framelet_push("'.$data['iframedivid'].'")</script>';
    $rv .= '<script type="text/javascript" defer="defer" src="lib/plugins/framelet/vendor/no_back_please.js"></script>';
    
    
    return $rv;
}

?>